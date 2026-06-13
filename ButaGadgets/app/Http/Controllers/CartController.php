<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart  = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('cart', compact('items', 'total'));
    }

    public function add(Product $product)
    {
        $cart = $this->getOrCreateCart();

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Товар додано до кошика');
    }

    public function update(CartItem $item, Request $request)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item->update(['quantity' => $request->quantity]);
        return back();
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Товар видалено');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
        return back()->with('success', 'Кошик очищено');
    }
}
