<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function getCart(): array {
        return session('cart', []);
    }

    protected function saveCart(array $cart): void {
        session(['cart' => $cart]);
    }

    public function index() {
        $cart = $this->getCart();
        $items = [];
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) continue;
            $lineTotal = $product->price * $qty;
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
            $subtotal += $lineTotal;
        }
        return view('cart.index', compact('items', 'subtotal'));
    }

    public function add(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);
        $cart = $this->getCart();
        $qty = $request->input('quantity', 1);
        $cart[$request->product_id] = ($cart[$request->product_id] ?? 0) + $qty;
        $this->saveCart($cart);
        return back()->with('success', '已加入购物车 🌸');
    }

    public function update(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0|max:10',
        ]);
        $cart = $this->getCart();
        if ($request->quantity == 0) {
            unset($cart[$request->product_id]);
        } else {
            $cart[$request->product_id] = $request->quantity;
        }
        $this->saveCart($cart);
        return back()->with('success', '购物车已更新');
    }

    public function remove(Request $request) {
        $cart = $this->getCart();
        unset($cart[$request->product_id]);
        $this->saveCart($cart);
        return back()->with('success', '已移除');
    }

    public function clear() {
        session()->forget('cart');
        return back()->with('success', '购物车已清空');
    }
}
