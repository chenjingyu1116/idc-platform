@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🛒 购物车</h1>

@if(empty($cartItems) || count($cartItems) === 0)
<div class="anime-card p-12 text-center text-gray-400">
    <div class="text-5xl mb-4">🛒</div>
    <div>购物车是空的</div>
    <a href="/products" class="anime-btn inline-block mt-4">去选购产品</a>
</div>
@else

{{-- 商品列表 --}}
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
@foreach($cartItems as $item)
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

{{-- 结算 + 优惠券 --}}
<div class="anime-card rounded-2xl p-6">
<form method="POST" action="{{ route('cart.checkout') }}">
@csrf

<div class="flex justify-between items-center text-lg mb-4">
    <span class="text-gray-500">商品合计</span>
    <span class="font-bold">¥{{ number_format($cartTotal ?? 0, 2) }}</span>
</div>

{{-- 优惠券输入框 --}}
<div class="border-t-2 border-pink-100 pt-4 mb-4">
    <label class="block text-sm font-semibold mb-2" style="color:#4A4A6A">🎫 优惠券</label>
    <input type="text" name="coupon_code" placeholder="输入优惠码（可选）"
           class="w-full px-4 py-2 rounded-2xl border-2 font-mono uppercase"
           style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
           value="{{ old('coupon_code') }}">
    <div class="text-xs text-gray-400 mt-1">💡 输入优惠码后提交订单，系统会自动验证并扣减</div>
    @error('coupon_code')
    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="anime-btn w-full">⚡ 提交订单</button>
</form>
</div>

@endif
@endsection
