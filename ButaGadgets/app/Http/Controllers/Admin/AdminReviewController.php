<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class AdminReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Завантажуємо відгуки разом із авторами та товарами (економить запити до БД)
       $reviews = Review::with(['user', 'product'])->latest()->paginate(15);
       return view('admin.comments.index', compact('reviews'));
    }

    
    public function update(Request $request, Review $comment)
    {
        $comment->update([
            'is_visible' => $request->has('is_visible') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Статус видимості коментаря змінено.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Коментар видалено.');
    }
}
