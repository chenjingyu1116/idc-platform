@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🛒 购物车</h1>

@if(empty($items))
<div class="anime-card p-12 text-center text-gray-400">
    <div class="text-5xl mb-3">🛒</div>
    <div class="mb-4">购物车还是空的</div>
    <a href="{{ route('orders.index') }}" class="anime-btn">去逛逛产品</a>
</div>
@else

<div class="anime-card rounded-2xl overflow-hidden mb-4">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">产品</th>
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">单价</th>
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">数量</th>
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">小计</th>
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
<tr class="border-b border-pink-50">
    <td class="px-4 py-3">
        <div class="font-semibold">{{ $item['product']->name }}</div>
        <div class="text-xs text-gray-400">{{ $item['product']->description }}</div>
    </td>
    <td class="px-4 py-3 font-mono">¥{{ $item['product']->price }}</td>
    <td class="px-4 py-3">
        <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
            <input type="number" name="quantity" value="{{ $item['qty'] }}" min="1" max="10"
                   class="w-16 px-2 py-1 rounded-lg border-2 text-center"
                   style="border-color:#FFD1E8;outline:none"
                   onchange="this.form.submit()">
        </form>
    </td>
    <td class="px-4 py-3 font-mono font-bold" style="color:#FF9EC4">¥{{ $item['subtotal'] }}</td>
    <td class="px-4 py-3">
        <form method="POST" action="{{ route('cart.remove') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
            <button type="submit" class="text-red-500 hover:underline text-sm">移除</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="anime-card p-5 flex items-center justify-between">
    <div>
        <div class="text-sm text-gray-500">合计</div>
        <div class="text-3xl font-bold" style="color:#FF9EC4">¥{{ $total }}</div>
    </div>
    <div class="flex gap-3">
        <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('清空购物车？')">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-2xl border-2 text-sm" style="border-color:#FFD1E8">清空</button>
        </form>
        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <button type="submit" class="anime-btn">💳 结算</button>
        </form>
    </div>
</div>

<div class="mt-3 text-xs text-gray-400 text-center">
    💡 结算将从余额扣款
</div>

@endif
</div>
@endsection
