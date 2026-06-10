<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AdminSpecificationController extends Controller
{
    public function index()
{
    $categories = Category::with('attributes.values')->get();
    
    return view('admin.specifications.index', compact('categories'));
}

    // app/Http/Controllers/Admin/AdminSpecificationController.php

    public function storeAttribute(Request $request, $id) 
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        \App\Models\Attribute::create([
            'category_id' => $id, // ЦЕ ОБОВ'ЯЗКОВО!
            'name' => $request->name
        ]);
        
        return back()->with('success', 'Атрибут додано!');
    }

    public function storeValue(Request $request, $attributeId) 
    {
        $request->validate(['value' => 'required|string|max:255']);
        
        AttributeValue::create([
            'attribute_id' => $attributeId,
            'value'        => $request->value
        ]);
        
        return back()->with('success', 'Значення додано!');
    }

    public function destroy($id)
    {
        // Це видалить характеристику (і всі її значення, якщо у вас каскадне видалення)
        Attribute::findOrFail($id)->delete();
        return back()->with('success', 'Характеристику видалено!');
    }
}