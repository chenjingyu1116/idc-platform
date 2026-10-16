<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        return view('orders.index', compact('products'));
    }

        public function store(Request $request)
    {
        $request->validate([
            "product_id" => "required|exists:products,id",
            "quantity"   => "required|integer|min:1|max:10",
        ]);

        $product = Product::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;
        $user = auth()->user();

        if ($user->balance < $total) {
            return back()->with("error", "余额不足，需要 ¥{$total}，当前余额 ¥{$user->balance}");
        }

        $user->decrement("balance", $total);

        $order = Order::create([
            "order_no"     => "ORD".date("YmdHis").strtoupper(\Str::random(4)),
            "user_id"      => $user->id,
            "product_id"   => $product->id,
            "quantity"     => $request->quantity,
            "total_amount" => $total,
            "status"       => "paid",
            "paid_at"      => now(),
        ]);

        // 查产品映射，决定用哪个上游
        $mapping = \App\Models\ProductMapping::where("product_id", $product->id)
            ->with("provider")->first();

        $providerType = "manual";
        $providerId = null;

        if ($mapping && $mapping->provider) {
            $providerType = $mapping->provider->driver;
            $providerId = $mapping->provider->id;
        }

        foreach (range(1, $request->quantity) as $i) {
            $service = $order->services()->create([
                "user_id" => $user->id,
                "product_id" => $product->id,
                "service_type" => "vps",
                "provider_type" => $providerType,
                "provider_id" => $providerId,
                "resource_config" => [
                    "domain" => "user{$user->id}-{$order->id}.example.com",
                    "php_version" => $product->config["php_version"] ?? "82",
                ],
                "status" => "pending",
            ]);
            \App\Jobs\ProvisionService::dispatch($service);
        }

        return redirect()->route("client.services.index")->with("success", "订单提交成功，正在为您开通资源！");
    }
}
