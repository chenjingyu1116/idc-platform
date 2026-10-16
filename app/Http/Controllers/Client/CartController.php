<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductMapping;
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

        foreach ($cart as $pid => $qty) {
            $product = Product::find($pid);
            if ($product) {
                $items[] = [
                    'product'  => $product,
                    'quantity' => (int) $qty,
                ];
                $total += $product->price * $qty;
            }
        }

        return view('client.cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->getCart();
        $pid = (int) $request->product_id;
        $cart[$pid] = ($cart[$pid] ?? 0) + (int) $request->quantity;
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', '已加入购物车');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1|max:10',
        ]);
        $cart = $this->getCart();
        $pid = (int) $request->product_id;
        if (isset($cart[$pid])) {
            $cart[$pid] = (int) $request->quantity;
        }
        $this->saveCart($cart);
        return back()->with('success', '已更新');
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        unset($cart[(int) $request->product_id]);
        $this->saveCart($cart);
        return back()->with('success', '已移除');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', '购物车已清空');
    }

    public function checkout(Request $request)
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return back()->with('error', '购物车为空');
        }

        $user = auth()->user();
        $originalTotal = 0;
        $items = [];
        foreach ($cart as $pid => $qty) {
            $product = Product::find($pid);
            if ($product) {
                $items[] = ['product' => $product, 'quantity' => (int) $qty];
                $originalTotal += $product->price * $qty;
            }
        }

        // 优惠券处理
        $coupon = null;
        $discount = 0;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::whereRaw("UPPER(code) = ?", [strtoupper(trim($request->coupon_code))])->first();
            if (!$coupon) return back()->with('error', '优惠券不存在');
            if (!($coupon->is_active ?? true)) return back()->with('error', '优惠券已停用');
            if ($coupon->expires_at && $coupon->expires_at < now()) return back()->with('error', '优惠券已过期');
            if ($coupon->total > 0 && $coupon->used >= $coupon->total) return back()->with('error', '优惠券已用完');
            if ($coupon->min_amount > 0 && $originalTotal < $coupon->min_amount) {
                return back()->with('error', '订单未达优惠券门槛 ¥' . $coupon->min_amount);
            }
            $discount = $coupon->type === 'fixed'
                ? min($coupon->value, $originalTotal)
                : $originalTotal * ($coupon->value / 100);
            $discount = round($discount, 2);
        }

        $total = max(0, $originalTotal - $discount);

        if ($user->balance < $total) {
            return back()->with('error', "余额不足，需要 ¥{$total}，当前 ¥{$user->balance}");
        }

        $user->decrement('balance', $total);

        foreach ($items as $item) {
            $product = $item['product'];
            $qty = $item['quantity'];
            $subtotal = $product->price * $qty;
            $itemDiscount = $originalTotal > 0 ? round($discount * ($subtotal / $originalTotal), 2) : 0;
            $itemTotal = $subtotal - $itemDiscount;

            $order = Order::create([
                'order_no'        => 'ORD' . date('YmdHis') . strtoupper(Str::random(4)),
                'user_id'         => $user->id,
                'product_id'      => $product->id,
                'quantity'        => $qty,
                'total_amount'    => $itemTotal,
                'coupon_id'       => $coupon?->id,
                'discount_amount' => $itemDiscount,
                'status'          => 'paid',
                'paid_at'         => now(),
            ]);

            $mapping = ProductMapping::where('product_id', $product->id)->with('provider')->first();
            $providerType = $mapping && $mapping->provider ? $mapping->provider->driver : 'manual';
            $providerId = $mapping && $mapping->provider ? $mapping->provider->id : null;

            foreach (range(1, $qty) as $i) {
                $service = $order->services()->create([
                    'user_id'       => $user->id,
                    'product_id'    => $product->id,
                    'service_type'  => 'vps',
                    'provider_type' => $providerType,
                    'provider_id'   => $providerId,
                    'resource_config' => [
                        'domain' => 'user' . $user->id . '-' . $order->id . '-' . $i . '.example.com',
                        'php_version' => $product->config['php_version'] ?? '82',
                    ],
                    'status' => 'pending',
                ]);
                \App\Jobs\ProvisionService::dispatch($service);
            }
        }

        if ($coupon) $coupon->increment('used');

        session()->forget('cart');

        $msg = '订单提交成功！';
        if ($discount > 0) $msg .= "已优惠 ¥{$discount}";
        return redirect()->route('client.services.index')->with('success', $msg);
    }
    public function applyCoupon(Request $request)
    {
        $request->validate(["code" => "required|string|max:50"]);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::whereRaw("UPPER(code) = ?", [$code])->first();

        if (!$coupon) return response()->json(["success" => false, "message" => "优惠券不存在"]);
        if (!($coupon->is_active ?? true)) return response()->json(["success" => false, "message" => "优惠券已停用"]);
        if ($coupon->expires_at && $coupon->expires_at < now()) return response()->json(["success" => false, "message" => "优惠券已过期"]);
        if ($coupon->total > 0 && $coupon->used >= $coupon->total) return response()->json(["success" => false, "message" => "优惠券已用完"]);

        $cart = $this->getCart();
        $originalTotal = 0;
        foreach ($cart as $pid => $qty) {
            $product = Product::find($pid);
            if ($product) $originalTotal += $product->price * $qty;
        }

        if ($coupon->min_amount > 0 && $originalTotal < $coupon->min_amount) {
            return response()->json(["success" => false, "message" => "订单未达门槛 ¥" . $coupon->min_amount]);
        }

        $discount = $coupon->type === "fixed"
            ? min($coupon->value, $originalTotal)
            : $originalTotal * ($coupon->value / 100);
        $discount = round($discount, 2);
        $total = max(0, $originalTotal - $discount);

        return response()->json([
            "success" => true,
            "message" => "优惠券可用",
            "coupon" => ["code" => $coupon->code, "name" => $coupon->name],
            "original_total" => $originalTotal,
            "discount" => $discount,
            "total" => $total,
        ]);
    }
}
