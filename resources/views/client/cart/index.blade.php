@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🛒 购物车</h1>

@if(empty($items) || count($items) === 0)
<div class="anime-card p-12 text-center text-gray-400">
    <div class="text-5xl mb-4">🛒</div>
    <div>购物车是空的</div>
    <a href="/products" class="anime-btn inline-block mt-4">去选购产品</a>
</div>
@else

<div class="anime-card rounded-2xl overflow-hidden mb-6">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">产品</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">单价</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">数量</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">小计</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">操作</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
<tr class="border-b border-pink-50">
<td class="px-6 py-3">{{ $item['product']->name }}</td>
<td class="px-6 py-3 font-mono">¥{{ $item['product']->price }}</td>
<td class="px-6 py-3">{{ $item['quantity'] }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">
    ¥{{ number_format($item['product']->price * $item['quantity'], 2) }}
</td>
<td class="px-6 py-3">
    <form method="POST" action="{{ route('cart.remove') }}" class="inline">
        @csrf
        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
        <button class="text-red-500 hover:underline text-sm">移除</button>
    </form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="anime-card rounded-2xl p-6">
<form method="POST" action="{{ route('cart.checkout') }}" id="checkout-form">
@csrf
<input type="hidden" name="coupon_code" id="coupon-hidden">

{{-- 原价 --}}
<div class="flex justify-between items-center text-lg mb-2">
    <span class="text-gray-500">商品合计</span>
    <span class="font-bold">¥{{ number_format($total ?? 0, 2) }}</span>
</div>

{{-- 优惠行（默认隐藏）--}}
<div class="flex justify-between items-center text-lg mb-2" id="discount-row" style="display:none">
    <span class="text-green-600">🎫 优惠券折扣</span>
    <span class="font-bold text-green-600" id="discount-text">-¥0.00</span>
</div>

{{-- 实付行（默认隐藏）--}}
<div class="flex justify-between items-center text-lg mb-4 pb-4 border-b-2 border-pink-100" id="final-row" style="display:none">
    <span class="font-bold">实付金额</span>
    <span class="font-bold text-2xl" style="color:#FF9EC4" id="final-text">¥0.00</span>
</div>

{{-- 优惠券输入 --}}
<div class="border-t-2 border-pink-100 pt-4 mb-4">
    <label class="block text-sm font-semibold mb-2" style="color:#4A4A6A">🎫 优惠券</label>
    <div class="flex gap-2">
        <input type="text" id="coupon-input" placeholder="输入优惠码"
               class="flex-1 px-4 py-3 rounded-2xl border-2 font-mono uppercase"
               style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none;letter-spacing:1px">
        <button type="button" onclick="applyCoupon()"
                class="px-6 py-3 rounded-2xl font-semibold text-white"
                style="background:linear-gradient(135deg,#FF9EC4,#B39DDB)">
            应用
        </button>
    </div>
    <div id="coupon-msg" class="text-xs mt-2"></div>
</div>

<div class="flex gap-3">
    <button type="button" onclick="document.getElementById('clear-form').submit()"
            class="px-6 py-3 rounded-2xl border-2 font-semibold"
            style="border-color:#FFD1E8;color:#999">
        清空
    </button>
    <button type="submit" class="anime-btn flex-1">⚡ 提交订单</button>
</div>

<div class="text-center text-xs text-gray-400 mt-3">💡 结算将从余额扣款</div>
</form>

<form id="clear-form" method="POST" action="{{ route('cart.clear') }}" class="hidden">
    @csrf
</form>
</div>

<script>
async function applyCoupon() {
    var input = document.getElementById('coupon-input');
    var msg = document.getElementById('coupon-msg');
    var code = input.value.trim();
    if (!code) { msg.innerHTML = '<span class="text-red-500">请输入优惠码</span>'; return; }

    msg.innerHTML = '<span class="text-gray-400">验证中...</span>';

    try {
        var token = document.querySelector('meta[name="csrf-token"]')?.content;
        var formData = new FormData();
        formData.append('_token', token);
        formData.append('code', code);

        var resp = await fetch('{{ route("cart.apply-coupon") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
            body: formData
        });
        var data = await resp.json();

        if (data.success) {
            msg.innerHTML = '<span class="text-green-600">✅ ' + data.message + '（' + data.coupon.name + '）</span>';
            document.getElementById('discount-text').innerText = '-¥' + data.discount.toFixed(2);
            document.getElementById('final-text').innerText = '¥' + data.total.toFixed(2);
            document.getElementById('discount-row').style.display = 'flex';
            document.getElementById('final-row').style.display = 'flex';
            document.getElementById('coupon-hidden').value = code;
        } else {
            msg.innerHTML = '<span class="text-red-500">❌ ' + data.message + '</span>';
            document.getElementById('discount-row').style.display = 'none';
            document.getElementById('final-row').style.display = 'none';
            document.getElementById('coupon-hidden').value = '';
        }
    } catch (e) {
        msg.innerHTML = '<span class="text-red-500">请求失败：' + e.message + '</span>';
    }
}
</script>

@endif
@endsection
