<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class AdminDirectoryController extends Controller
{
    
    public function index()
    {
        $brands = Brand::with('categories')->latest()->get();
        $categories = Category::latest()->get();
        $subcategories = Subcategory::with('category')->latest()->get();

        return view('admin.directories.index', compact('brands', 'categories', 'subcategories'));
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|unique:brands,name|max:255',
            'category_ids'   => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $brand = Brand::create(['name' => $validated['name']]);
        $brand->categories()->sync($validated['category_ids']);

        return redirect()->back()->with('success', 'Бренд успішно додано!');
    }


    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);
        Category::create($validated);
        return redirect()->back()->with('success', 'Категорію успішно додано!');
    }

    public function storeSubcategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
        Subcategory::create($validated);
        return redirect()->back()->with('success', 'Підкатегорію успішно додано!');
    }

    public function destroyBrand($id)
    {
        $brand = Brand::findOrFail($id);
        
        
        if ($brand->products()->exists()) {
            return redirect()->back()->with('error', 'Не можна видалити бренд, оскільки до нього прив\'язані товари!');
        }

        $brand->delete();
        return redirect()->back()->with('success', 'Бренд успішно видалено.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
    
        if ($category->subcategories()->exists() || $category->products()->exists()) {
            return redirect()->route('admin.directories.index')
                ->with('error', 'Не можна видалити категорію, оскільки вона містить товари або підкатегорії!');
        }
    
        $category->delete();
        return redirect()->route('admin.directories.index')
            ->with('success', 'Категорію успішно видалено.');
    }
    
    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();
        return redirect()->route('admin.directories.index')
            ->with('success', 'Підкатегорію успішно видалено.');
    }
}