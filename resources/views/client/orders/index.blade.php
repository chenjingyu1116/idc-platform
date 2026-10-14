@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">📋 我的订单</h1>
<a href="{{ route('orders.index') }}" class="anime-btn text-sm" style="padding:10px 24px">+ 购买新服务</a>
</div>

@forelse($orders as $order)
<div class="anime-card p-6 mb-4">
<div class="flex flex-wrap justify-between items-center gap-4">
<div class="flex items-center gap-4">
<div class="text-3xl">
@if($order->status === 'paid')💖
@elseif($order->status === 'pending')💤
@elseif($order->status === 'cancelled')💔
@else 📦 @endif
</div>
<div>
<div class="font-bold text-lg">{{ optional($order->product)->name ?? '产品' }}</div>
<div class="text-xs mt-1 font-mono" style="color:#9CA3AF">订单号：{{ $order->order_no }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">🕐 {{ $order->created_at->format('Y-m-d H:i') }}</div>
</div>
</div>
<div class="flex items-center gap-3">
<div class="text-right">
<div class="text-2xl font-bold" style="color:#FF9EC4">¥{{ $order->total_amount }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">x{{ $order->quantity }}</div>
</div>
@if($order->status === 'pending')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏳ 待支付</span>
@elseif($order->status === 'paid')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已支付</span>
@elseif($order->status === 'cancelled')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(156,163,175,.25);color:#6B7280">✗ 已取消</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(168,216,255,.25);color:#2563EB">{{ $order->status }}</span>
@endif
<a href="{{ route('client.orders.show',$order) }}" class="anime-btn-soft text-xs">详情 →</a>
</div>
</div>
</div>
@empty
<div class="anime-card p-12 text-center">
<div class="text-6xl mb-4">📭</div>
<div class="text-lg font-bold mb-2" style="color:#FF9EC4">还没有任何订单</div>
<p class="text-sm mb-6" style="color:#9CA3AF">快去挑选一台樱花喵守护的服务器吧</p>
<a href="{{ route('orders.index') }}" class="anime-btn">✨ 立即选购</a>
</div>
@endforelse

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
