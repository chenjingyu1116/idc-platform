@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">

<a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-pink-500">← 返回产品列表</a>

<div class="grid md:grid-cols-2 gap-8 mt-4 mb-12">
    {{-- 左：产品信息 --}}
    <div class="anime-card p-8">
        <div class="text-6xl mb-4 text-center">🖥️</div>
        <h1 class="text-3xl font-bold mb-3 text-center">{{ $product->name }}</h1>
        <p class="text-gray-500 text-center mb-6">{{ $product->description }}</p>

        <div class="text-center mb-6">
            <span class="text-5xl font-bold" style="color:#FF9EC4">¥{{ $product->price }}</span>
            <span class="text-gray-500">/ 月</span>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-6 text-sm">
            <div class="p-3 rounded-xl" style="background:rgba(255,158,196,.1)">
                <div class="text-gray-400 text-xs">CPU</div>
                <div class="font-bold">{{ $product->config['cpu'] ?? '1核' }}</div>
            </div>
            <div class="p-3 rounded-xl" style="background:rgba(168,216,255,.15)">
                <div class="text-gray-400 text-xs">内存</div>
                <div class="font-bold">{{ $product->config['memory'] ?? '1G' }}</div>
            </div>
            <div class="p-3 rounded-xl" style="background:rgba(179,157,219,.15)">
                <div class="text-gray-400 text-xs">硬盘</div>
                <div class="font-bold">{{ $product->config['disk'] ?? '20G' }}</div>
            </div>
            <div class="p-3 rounded-xl" style="background:rgba(255,229,180,.2)">
                <div class="text-gray-400 text-xs">带宽</div>
                <div class="font-bold">{{ $product->config['bandwidth'] ?? '20M' }}</div>
            </div>
        </div>

        <div class="flex gap-3">
            <form method="POST" action="{{ route('orders.store') }}" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full anime-btn">⚡ 立即购买</button>
            </form>
            <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full anime-btn-soft">🛒 加入购物车</button>
            </form>
        </div>
    </div>

    {{-- 右：详情 --}}
    <div>
        <div class="anime-card p-6 mb-4">
            <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">🌸 产品特色</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex gap-3"><span class="text-xl">✨</span><div><div class="font-semibold">高性能硬件</div><div class="text-gray-500">企业级 SSD 与高主频 CPU</div></div></li>
                <li class="flex gap-3"><span class="text-xl">⚡</span><div><div class="font-semibold">CN2 直连</div><div class="text-gray-500">中国大陆优化线路</div></div></li>
                <li class="flex gap-3"><span class="text-xl">🛡️</span><div><div class="font-semibold">DDoS 防护</div><div class="text-gray-500">默认 5Gbps 防护</div></div></li>
                <li class="flex gap-3"><span class="text-xl">🎀</span><div><div class="font-semibold">7×24 客服</div><div class="text-gray-500">樱花喵全天候守护</div></div></li>
            </ul>
        </div>

        <div class="anime-card p-6">
            <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">📖 常见问题</h2>
            <div class="space-y-3 text-sm">
                <details>
                    <summary class="cursor-pointer font-semibold">💡 多久能开通？</summary>
                    <p class="mt-2 text-gray-500">支付后自动开通，通常 1-3 分钟内完成。</p>
                </details>
                <details>
                    <summary class="cursor-pointer font-semibold">💡 支持退款吗？</summary>
                    <p class="mt-2 text-gray-500">开通 24 小时内可联系客服申请退款。</p>
                </details>
                <details>
                    <summary class="cursor-pointer font-semibold">💡 可以升级配置吗？</summary>
                    <p class="mt-2 text-gray-500">支持升级，补差价即可。</p>
                </details>
            </div>
        </div>
    </div>
</div>

{{-- 相关产品 --}}
@if($related->count() > 0)
<h2 class="text-xl font-bold mb-4">🎁 猜你喜欢</h2>
<div class="grid md:grid-cols-4 gap-4">
    @foreach($related as $p)
    <a href="{{ route('product.show', $p) }}" class="anime-card p-5 block hover:shadow-lg transition">
        <div class="text-3xl mb-2">🖥️</div>
        <div class="font-semibold mb-1">{{ $p->name }}</div>
        <div class="text-xl font-bold" style="color:#FF9EC4">¥{{ $p->price }}</div>
    </a>
    @endforeach
</div>
@endif

</div>
@endsection
