@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🎀 选择产品</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($products as $product)
    <div class="anime-card p-6">
        <h2 class="text-xl font-semibold mb-2">
            <a href="/product/{{ $product->id }}" class="hover:text-pink-500">{{ $product->name }}</a>
        </h2>
        <p class="text-gray-400 mb-4 text-sm">{{ $product->description ?? '优质云服务资源' }}</p>
        <div class="text-3xl font-bold mb-4" style="color:#FF9EC4">
            ¥{{ $product->price }} <span class="text-sm text-gray-500 font-normal">/ 月</span>
        </div>
        <div class="text-sm text-gray-400 mb-6 space-y-1">
            <p>CPU: {{ $product->config['cpu'] ?? '1核' }}</p>
            <p>内存: {{ $product->config['memory'] ?? '1G' }}</p>
            <p>硬盘: {{ $product->config['disk'] ?? '20G' }}</p>
            <p>带宽: {{ $product->config['bandwidth'] ?? '20M' }}</p>
        </div>

        {{-- 两个按钮 --}}
        <div class="flex gap-2">
            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="anime-btn-soft w-full text-sm py-2">🛒 加入购物车</button>
            </form>
            <form action="{{ route('orders.store') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="anime-btn w-full text-sm py-2">⚡ 立即购买</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
