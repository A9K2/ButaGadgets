<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $orders = Order::with(['user'])
            ->when($search, function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('username', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('orders', 'search'));
    }

    public function update(Request $request, Order $comment)
    {
        $comment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Статус замовлення змінено.');
    }

    public function destroy(Order $comment)
    {
        $comment->items()->delete();
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Замовлення видалено.');
    }
}