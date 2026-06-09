<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class AdminDirectoryController extends Controller
{
    // Головна сторінка керування довідниками
    public function index()
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = Subcategory::with('category')->latest()->get();

        return view('admin.directories.index', compact('brands', 'categories', 'subcategories'));
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:brands,name|max:255',
        ]);
        Brand::create($validated);
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

    // ================= МЕТОДИ ДЛЯ ВИДАЛЕННЯ =================

    public function destroyBrand($id)
    {
        $brand = Brand::findOrFail($id);
        
        // Перевірка: чи є товари у цього бренду
        if ($brand->products()->exists()) {
            return redirect()->back()->with('error', 'Не можна видалити бренд, оскільки до нього прив\'язані товари!');
        }

        $brand->delete();
        return redirect()->back()->with('success', 'Бренд успішно видалено.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        // Перевірка: чи є підкатегорії або товари в цій категорії
        if ($category->subcategories()->exists() || $category->products()->exists()) {
            return redirect()->back()->with('error', 'Не можна видалити категорію, оскільки вона містить товари або підкатегорії!');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Категорію успішно видалено.');
    }

    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        // Перевірка: чи є товари в цій підкатегорії
        if ($subcategory->products()->exists()) {
            return redirect()->back()->with('error', 'Не можна видалити підкатегорію, до якої прив\'язані товари!');
        }

        $subcategory->delete();
        return redirect()->back()->with('success', 'Підкатегорію успішно видалено.');
    }
}