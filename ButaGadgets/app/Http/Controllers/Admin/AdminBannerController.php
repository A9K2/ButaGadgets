<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_link' => 'nullable|string|max:255',
            'sort_order' => 'required|integer'
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/banners'), $imageName);

        Banner::create([
            'title' => $request->title,
            'image' => 'images/banners/' . $imageName,
            'url_link' => $request->url_link,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Банер успішно додано!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if (file_exists(public_path($banner->image))) {
            @unlink(public_path($banner->image));
        }
        $banner->delete();

        return redirect()->back()->with('success', 'Банер видалено.');
    }
}