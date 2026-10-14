@extends('layouts.app')
@section('content')
<div class="text-center mb-10">
<h1 class="text-4xl font-bold mb-3" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🎀 挑选你的云产品</h1>
<p class="text-sm" style="color:#9CA3AF">每一台都有樱花喵守护 🌸</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@forelse($products as $product)
<div class="anime-card p-6 flex flex-col">
<div class="text-4xl mb-3 text-center">
@if(str_contains($product->name,'香港'))🇭🇰
@elseif(str_contains($product->name,'美国'))🇺🇸
@elseif(str_contains($product->name,'日本'))🇯🇵
@else 🌸 @endif
</div>
<h2 class="text-xl font-bold mb-2 text-center" style="color:#4A4A6A">{{ $product->name }}</h2>
<p class="text-sm mb-4 text-center" style="color:#9CA3AF">{{ $product->description ?? '优质云服务' }}</p>

<div class="text-center my-4">
<span class="text-3xl font-bold" style="color:#FF9EC4">¥{{ $product->price }}</span>
<span class="text-sm" style="color:#9CA3AF">/ {{ $product->billing_cycle === 'monthly' ? '月' : $product->billing_cycle }}</span>
</div>

<div class="grid grid-cols-2 gap-2 text-xs mb-6">
<div class="px-3 py-2 rounded-lg" style="background:rgba(255,158,196,.1)">💻 CPU: {{ $product->config['cpu'] ?? '1核' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(168,216,255,.15)">🧠 内存: {{ $product->config['memory'] ?? '1G' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(255,229,180,.2)">💾 硬盘: {{ $product->config['disk'] ?? '20G' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(179,157,219,.15)">🌐 带宽: {{ $product->config['bandwidth'] ?? '20M' }}</div>
</div>

<form action="{{ route('orders.store') }}" method="POST" class="mt-auto">
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">
<input type="hidden" name="quantity" value="1">
<button type="submit" class="anime-btn w-full">🌸 立即购买</button>
</form>
</div>
@empty
<div class="col-span-3 text-center py-12" style="color:#9CA3AF">
<div class="text-5xl mb-4">🌙</div>
暂无产品，请等待管理员上架
</div>
@endforelse
</div>
@endsection
