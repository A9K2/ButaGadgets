<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
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

    public function storeAttribute(Request $request, $id) 
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        \App\Models\Attribute::create([
            'category_id' => $id, 
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
        Attribute::findOrFail($id)->delete();
        return back()->with('success', 'Характеристику видалено!');
    }
}