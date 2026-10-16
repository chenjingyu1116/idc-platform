<?php
namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index() {
        $products = Product::where('is_active', true)->get();
        return view('orders.index', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:10',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();
        $cart = session('cart', []);

        // 判断是购物车结算还是单品购买
        if ($request->filled('product_id')) {
            $lines = [
                ['product_id' => $request->product_id, 'quantity' => $request->input('quantity', 1)],
            ];
        } elseif (!empty($cart)) {
            $lines = [];
            foreach ($cart as $pid => $qty) {
                $lines[] = ['product_id' => $pid, 'quantity' => $qty];
            }
        } else {
            return back()->with('error', '购物车是空的');
        }

        // 计算小计
        $subtotal = 0;
        $items = [];
        foreach ($lines as $line) {
            $product = Product::find($line['product_id']);
            if (!$product || !$product->is_active) continue;
            $lineTotal = $product->price * $line['quantity'];
            $items[] = ['product' => $product, 'quantity' => $line['quantity'], 'line_total' => $lineTotal];
            $subtotal += $lineTotal;
        }

        if (empty($items)) return back()->with('error', '没有有效商品');

        // 优惠券
        $discount = 0;
        $coupon = null;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::whereRaw("UPPER(code) = ?", [strtoupper(trim($request->coupon_code))])->first();
            if (!$coupon) {
                return back()->with('error', '优惠券不存在');
            }
            if (!$coupon->is_active) {
                return back()->with('error', '优惠券已停用');
            }
            if ($coupon->expires_at && $coupon->expires_at->isPast()) {
                return back()->with('error', '优惠券已过期');
            }
            if ($coupon->total > 0 && $coupon->used >= $coupon->total) {
                return back()->with('error', '优惠券已用完');
            }
            if ($coupon->min_amount > 0 && $subtotal < $coupon->min_amount) {
                return back()->with('error', "需要满 ¥{$coupon->min_amount} 才能使用此优惠券");
            }

            if ($coupon->type === 'fixed') {
                $discount = min($coupon->value, $subtotal);
            } else {
                $discount = round($subtotal * $coupon->value / 100, 2);
            }
        }

        $total = max(0, $subtotal - $discount);

        if ($user->balance < $total) {
            return back()->with('error', "余额不足，需要 ¥{$total}，当前余额 ¥{$user->balance}");
        }

        // 扣余额
        $user->decrement('balance', $total);

        // 创建订单
        $firstProduct = $items[0]['product'];
        $order = Order::create([
            'order_no' => 'ORD'.date('YmdHis').strtoupper(Str::random(4)),
            'user_id' => $user->id,
            'product_id' => $firstProduct->id,
            'quantity' => array_sum(array_column($items, 'quantity')),
            'total_amount' => $total,
            'discount_amount' => $discount,
            'coupon_id' => $coupon?->id,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // 生成服务
        foreach ($items as $item) {
            foreach (range(1, $item['quantity']) as $i) {
                $service = $order->services()->create([
                    'user_id' => $user->id,
                    'product_id' => $item['product']->id,
                    'service_type' => 'vps',
                    'provider_type' => 'manual',
                    'status' => 'pending',
                    'resource_config' => [
                        'domain' => 'user'.$user->id.'-'.$order->id.'-'.uniqid().'.example.com',
                    ],
                ]);
                \App\Jobs\ProvisionService::dispatch($service);
            }
        }

        // 更新优惠券使用次数
        if ($coupon) $coupon->increment('used');

        // 清空购物车
        session()->forget('cart');

        return redirect()->route('client.services.index')->with('success', '订单提交成功，正在为您开通资源！');
    }
}
