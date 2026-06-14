<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $cart  = Cart::where('user_id', auth()->id())->first();
        $items = $cart ? $cart->items()->with('product')->get() : collect();
        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name'   => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
        ]);

        $cart  = Cart::where('user_id', auth()->id())->first();
        $items = $cart ? $cart->items()->with('product')->get() : collect();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Кошик порожній');
        }

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'total_price'      => $total,
            'shipping_address' => $request->shipping_address,
            'phone'            => $request->phone,
            'recipient_name'   => $request->recipient_name,
            'status'           => 'pending',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

           
            $item->product->decrement('quantity', $item->quantity);
        }

      
        $cart->items()->delete();

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'Замовлення оформлено!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->latest()
                       ->get();

        return view('orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('order', compact('order'));
    }
}