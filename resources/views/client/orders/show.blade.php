@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<a href="{{ route('client.orders.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回订单列表</a>

<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🌸 订单详情</h1>

<div class="anime-card p-8">
<div class="flex items-center gap-4 mb-6 pb-6" style="border-bottom:2px dashed rgba(255,158,196,.3)">
<div class="text-5xl">
@if($order->status === 'paid')💖
@elseif($order->status === 'pending')💤
@else 💔 @endif
</div>
<div>
<div class="text-xl font-bold">{{ optional($order->product)->name ?? '产品' }}</div>
<div class="text-xs mt-1 font-mono" style="color:#9CA3AF">{{ $order->order_no }}</div>
</div>
</div>

<div class="space-y-3">
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">📦 数量</span>
<span class="font-bold">x{{ $order->quantity }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">💰 金额</span>
<span class="font-bold text-lg" style="color:#FF9EC4">¥{{ $order->total_amount }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">📅 下单时间</span>
<span class="font-bold">{{ $order->created_at->format('Y-m-d H:i') }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">💳 支付时间</span>
<span class="font-bold">{{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i') : '未支付' }}</span>
</div>
<div class="flex justify-between py-2">
<span class="text-sm" style="color:#9CA3AF">📊 状态</span>
<span class="font-bold">
@if($order->status === 'paid')<span style="color:#16A34A">✓ 已支付</span>
@elseif($order->status === 'pending')<span style="color:#D97706">⏳ 待支付</span>
@elseif($order->status === 'cancelled')<span style="color:#6B7280">✗ 已取消</span>
@else<span>{{ $order->status }}</span>@endif
</span>
</div>
</div>

@if($order->status === 'pending')
<div class="flex gap-3 mt-6 pt-6" style="border-top:2px dashed rgba(255,158,196,.3)">
<a href="{{ route('payment.checkout',$order) }}" class="anime-btn flex-1 text-center">💗 立即支付</a>
<form method="POST" action="{{ route('client.orders.cancel',$order) }}" class="flex-1" onsubmit="return confirm('确认取消该订单？')">
@csrf
<button type="submit" class="anime-btn-soft w-full">✗ 取消订单</button>
</form>
</div>
@endif

@if($order->services->count() > 0)
<div class="mt-6">
<h3 class="font-bold mb-3" style="color:#B39DDB">🔗 关联服务</h3>
<div class="space-y-2">
@foreach($order->services as $s)
<a href="{{ route('client.services.show',$s) }}" class="block anime-card p-4 hover:shadow-lg transition">
<div class="flex justify-between items-center">
<span class="text-sm font-bold">🖥️ 服务 #{{ $s->id }}</span>
<span class="text-xs px-3 py-1 rounded-full" style="background:rgba(168,216,255,.25);color:#2563EB">{{ $s->status }}</span>
</div>
</a>
@endforeach
</div>
</div>
@endif
</div>
@endsection
