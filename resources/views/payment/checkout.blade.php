@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-3xl font-bold text-center mb-2" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🌸 收银台</h1>
<p class="text-center text-sm mb-8" style="color:#9CA3AF">选择一种支付方式完成订单</p>

<div class="anime-card p-8 mb-6">
<div class="text-center mb-6">
<div class="text-sm mb-2" style="color:#9CA3AF">订单金额</div>
<div class="text-5xl font-bold" style="color:#FF9EC4">¥{{ $order->total_amount }}</div>
<div class="text-xs mt-3 font-mono" style="color:#9CA3AF">订单号：{{ $order->order_no }}</div>
</div>

<div class="pt-6" style="border-top:2px dashed rgba(255,158,196,.3)">
<div class="text-sm mb-3" style="color:#7A7A9A">📦 商品信息</div>
<div class="flex justify-between items-center p-4 rounded-2xl" style="background:rgba(255,245,250,.7)">
<div class="font-bold">{{ optional($order->product)->name ?? '产品' }}</div>
<div class="text-sm" style="color:#9CA3AF">x{{ $order->quantity }}</div>
</div>
</div>
</div>

<h2 class="text-xl font-bold mb-4" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">💳 选择支付方式</h2>

<div class="space-y-3">
{{-- 余额支付 --}}
<form method="POST" action="{{ route('payment.balance',$order) }}">
@csrf
<div class="anime-card p-5 flex justify-between items-center cursor-pointer hover:shadow-lg transition">
<div class="flex items-center gap-3">
<div class="text-3xl">💰</div>
<div>
<div class="font-bold">余额支付</div>
<div class="text-xs mt-1" style="color:#9CA3AF">
当前余额：¥{{ auth()->user()->balance }}
@if(auth()->user()->balance < $order->total_amount)
<span style="color:#DC2626">（余额不足）</span>
@endif
</div>
</div>
</div>
<button type="submit" class="anime-btn text-sm" style="padding:10px 24px" @if(auth()->user()->balance < $order->total_amount) disabled style="opacity:.5;padding:10px 24px" @endif>
🌸 立即支付
</button>
</div>
</form>

{{-- 易支付 --}}
<form method="POST" action="{{ route('payment.epay',$order) }}">
@csrf
<div class="anime-card p-5 flex justify-between items-center cursor-pointer hover:shadow-lg transition">
<div class="flex items-center gap-3">
<div class="text-3xl">🅰️</div>
<div>
<div class="font-bold">支付宝 / 易支付</div>
<div class="text-xs mt-1" style="color:#9CA3AF">跳转到第三方支付平台</div>
</div>
</div>
<button type="submit" class="anime-btn-soft text-sm" style="padding:10px 24px">💫 去支付</button>
</div>
</form>

{{-- 提示 --}}
<div class="anime-card p-4 text-xs" style="background:rgba(255,229,180,.15)">
💡 <strong>提示：</strong>如果易支付无法使用，请先在 .env 中配置 EPAY_API_URL、EPAY_PID、EPAY_KEY。或者联系管理员充值余额。
</div>
</div>

<div class="text-center mt-8">
<a href="{{ route('client.orders.show',$order) }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回订单详情</a>
</div>
</div>
@endsection
