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
    public function index(Request $request)
    {
        $query = \App\Models\Product::query();

        // Пошук за назвою
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(15)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    // У AdminProductController.php
    public function create(Request $request)
    {
        $categories    = Category::all();
        $subcategories = Subcategory::all();
        $category      = null;
        $brands        = collect(); // порожня колекція за замовчуванням

        if ($request->has('category_id')) {
            $category      = Category::with('attributes.values', 'brands')->find($request->category_id);
            $brands        = $category ? $category->brands : collect();
            $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        }

        return view('admin.products.create', compact('categories', 'category', 'brands', 'subcategories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name'           => 'required|string',
        'category_id'    => 'required|exists:categories,id',
        'brand_id'       => 'required|exists:brands,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'price'          => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'attributes'     => 'array'
    ]);

    DB::transaction(function () use ($request, $validated) {
        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attribute_id => $value_id) {
                if (!empty($value_id)) {
                    ProductAttributeValue::create([
                        'product_id'         => $product->id,
                        'attribute_id'       => (int) $attribute_id,
                        'attribute_value_id' => (int) $value_id,
                    ]);
                }
            }
        }
    });

    return redirect()->route('admin.products.index')->with('success', 'Товар додано!');
}

    /**
     * МЕТОД ЕDIT: Відображення форми редагування
     */
    // У AdminProductController.php
    public function edit(Request $request, $id)
{
    $product       = Product::with('attributeValues')->findOrFail($id);
    $categories    = Category::all();
    $categoryId    = $request->get('category_id', $product->category_id);
    $category      = Category::with('attributes.values', 'brands')->find($categoryId);
    $brands        = $category ? $category->brands : Brand::all();
    $subcategories = Subcategory::where('category_id', $categoryId)->get();

    // ✅ Будуємо масив [attribute_id => value_id] з поточних значень продукту
    $currentAttributes = [];
    foreach ($product->attributeValues as $av) {
        $currentAttributes[$av->attribute_id] = $av->attribute_value_id;
    }

    return view('admin.products.edit', compact(
        'product', 'categories', 'brands', 'subcategories', 'category', 'currentAttributes'
    ));
}

    /**
     * МЕТОД UPDATE: Оновлення даних у базі даних
     */
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name'           => 'required|string|max:255',
        'brand_id'       => 'required|exists:brands,id',
        'category_id'    => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'price'          => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'attributes'     => 'array',
    ]);

    $product->update($validated);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_path' => $path]);
        }
    }

    if ($request->has('attributes')) {
        ProductAttributeValue::where('product_id', $product->id)->delete();

        foreach ($request->input('attributes') as $attribute_id => $value_id) {
            if (!empty($value_id)) {
                ProductAttributeValue::create([
                    'product_id'         => $product->id,
                    'attribute_id'       => (int) $attribute_id,
                    'attribute_value_id' => (int) $value_id,
                ]);
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Товар оновлено!');
}

        
    

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар видалено.');
    }
}