<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected function getCart(): array
    {
        return session()->get('cart', []);
    }

    protected function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $p = Product::find($productId);
            if (!$p || !$p->is_active) continue;
            $subtotal = $p->price * $qty;
            $total += $subtotal;
            $items[] = ['product' => $p, 'qty' => $qty, 'subtotal' => $subtotal];
        }

        return view('client.cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1|max:10',
        ]);

        $qty = (int) ($request->quantity ?? 1);
        $cart = $this->getCart();
        $productId = (int) $request->product_id;

        $cart[$productId] = min(10, ($cart[$productId] ?? 0) + $qty);
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', '已加入购物车');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:0|max:10',
        ]);

        $cart = $this->getCart();
        $productId = (int) $request->product_id;
        $qty = (int) $request->quantity;

        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $qty;
        }

        $this->saveCart($cart);
        return back()->with('success', '已更新');
    }

    public function remove(Request $request)
    {
        $productId = (int) $request->product_id;
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
        return back()->with('success', '已移除');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', '购物车已清空');
    }

    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', '购物车为空');
        }

        $user = auth()->user();
        $total = 0;
        $items = [];

        foreach ($cart as $productId => $qty) {
            $p = Product::find($productId);
            if (!$p || !$p->is_active) continue;
            $total += $p->price * $qty;
            $items[] = ['product' => $p, 'qty' => $qty];
        }

        if ($user->balance < $total) {
            return back()->with('error', "余额不足，需要 ¥{$total}，当前 ¥{$user->balance}");
        }

        // 扣余额
        $user->decrement('balance', $total);

        // 创建订单
        $order = Order::create([
            'order_no'     => 'ORD' . date('YmdHis') . strtoupper(Str::random(4)),
            'user_id'      => $user->id,
            'product_id'   => $items[0]['product']->id, // 主产品
            'quantity'     => array_sum(array_column($items, 'qty')),
            'total_amount' => $total,
            'status'       => 'paid',
            'paid_at'      => now(),
        ]);

        // 为每个商品创建服务
        foreach ($items as $item) {
            foreach (range(1, $item['qty']) as $i) {
                $service = $order->services()->create([
                    'user_id'         => $user->id,
                    'product_id'      => $item['product']->id,
                    'service_type'    => 'vps',
                    'provider_type'   => 'manual',
                    'resource_config' => [
                        'domain' => 'user' . $user->id . '-' . $order->id . '-' . $item['product']->id . '-' . $i . '.example.com',
                    ],
                    'status'          => 'pending',
                ]);
                \App\Jobs\ProvisionService::dispatch($service);
            }
        }

        session()->forget('cart');

        return redirect()->route('client.services.index')
            ->with('success', "已下单，共 ¥{$total}，正在开通！");
    }
}
