<?php

namespace App\Http\Controllers\Admin;

use \App\Models\ProductAttributeValue;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Phone;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // У AdminProductController.php
    public function create(Request $request)
{
    $categories = Category::all();
    $category = null;

    if ($request->has('category_id')) {
        // Додаємо get() або first(), щоб отримати об'єкт
        $category = Category::with('attributes.values')->find($request->category_id);
    }

    return view('admin.products.create', compact('categories', 'category'));
}

    public function store(Request $request)
    {
        // ... ваш код валідації та завантаження фото ...

        DB::transaction(function () use ($request, $validatedProduct) {
            $product = Product::create($validatedProduct);

            // Припустимо, у формі приходять атрибути у масиві 'attributes'
            // наприклад: attributes => [1 => 5, 2 => 10] (де 1 — ID атрибута, 5 — ID значення)
            if ($request->has('attributes')) {
                foreach ($request->attributes as $attribute_id => $value_id) {
                    ProductAttributeValue::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute_id,
                        'value_id' => $value_id, // Або просто 'value' => $value_id
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Товар успішно додано!');
    }

    /**
     * МЕТОД ЕDIT: Відображення форми редагування
     */
    public function edit($id)
    {
        // Завантажуємо продукт
        $product = Product::findOrFail($id);

        // Завантажуємо всі необхідні довідники
        $categories = Category::all();
        $brands = Brand::all();
        $subcategories = Subcategory::all();

        $processors = DB::table('processors')->get();
        $rams = DB::table('rams')->get();
        $storages = DB::table('storages')->get();
        $batteries = DB::table('batteries')->get();
        $colors = DB::table('colors')->get();
        $screen_types = DB::table('screen_types')->get();
        $screen_sizes = DB::table('screen_sizes')->get();
        $video_cards = DB::table('video_cards')->get();
        $operating_systems = DB::table('operating_systems')->get();

        return view('admin.products.edit', compact(
            'product', 'categories', 'brands', 'subcategories',
            'processors', 'rams', 'storages', 'batteries', 
            'colors', 'screen_types', 'screen_sizes', 'video_cards', 'operating_systems'
        ));
    }

    /**
     * МЕТОД UPDATE: Оновлення даних у базі даних
     */
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validatedProduct = $request->validate([
        'name' => 'required|string|max:255',
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'price' => 'required|numeric|min:0',
        'old_price' => 'nullable|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
    ]);

    $validatedProduct['is_popular'] = $request->has('is_popular');
    $validatedProduct['is_action'] = $request->has('is_action');

    if ($request->hasFile('image')) {
        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/products'), $imageName);
        $validatedProduct['image'] = 'images/products/' . $imageName;
    }

    DB::transaction(function () use ($request, $product, $validatedProduct) {
        $product->update($validatedProduct);

        if ($request->category_id == 1) {
            Phone::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'processor_id' => $request->processor_id,
                    'ram_id' => $request->ram_id,
                    'storage_id' => $request->storage_id,
                    'battery_id' => $request->battery_id,
                    'color_id' => $request->color_id,
                    'screen_type_id' => $request->screen_type_id,
                    'operating_system_id' => $request->operating_system_id,
                ]
            );
            Laptop::where('product_id', $product->id)->delete();
        } elseif ($request->category_id == 2) {
            Laptop::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'processor_id' => $request->processor_id,
                    'video_card_id' => $request->video_card_id,
                    'ram_id' => $request->ram_id,
                    'storage_id' => $request->storage_id,
                    'screen_size_id' => $request->screen_size_id,
                    'screen_type_id' => $request->screen_type_id,
                    'operating_system_id' => $request->operating_system_id,
                    'color_id' => $request->color_id,
                ]
            );
            Phone::where('product_id', $product->id)->delete();
        }
    });

    return redirect()->route('admin.products.index')->with('success', 'Товар оновлено!');
}

        
    

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар видалено.');
    }
}