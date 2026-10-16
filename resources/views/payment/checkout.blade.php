@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">

<h1 class="text-2xl font-bold mb-6">💳 收银台</h1>

<div class="anime-card p-6 mb-6">
    <div class="flex justify-between mb-3">
        <span class="text-gray-500">订单号</span>
        <span class="font-mono">{{ $order->order_no }}</span>
    </div>
    <div class="flex justify-between mb-3">
        <span class="text-gray-500">产品</span>
        <span>{{ optional($order->product)->name }}</span>
    </div>
    <div class="flex justify-between mb-3">
        <span class="text-gray-500">数量</span>
        <span>{{ $order->quantity }}</span>
    </div>
    <div class="border-t-2 border-pink-100 pt-3 mt-3 flex justify-between items-center">
        <span class="font-bold">应付金额</span>
        <span class="text-3xl font-bold" style="color:#FF9EC4">¥{{ number_format($order->total_amount, 2) }}</span>
    </div>
</div>

<form method="POST" action="{{ route('payment.pay', $order) }}">
@csrf

<div class="anime-card p-6 mb-6">
    <h2 class="font-bold mb-4" style="color:#FF9EC4">选择支付方式</h2>
    <div class="space-y-3">
        {{-- 余额支付 --}}
        <label class="flex items-center gap-3 p-3 rounded-2xl border-2 cursor-pointer hover:bg-pink-50/30" style="border-color:#FFD1E8">
            <input type="radio" name="gateway" value="balance" checked>
            <span class="text-2xl">💎</span>
            <div class="flex-1">
                <div class="font-semibold">余额支付</div>
                <div class="text-xs text-gray-500">当前余额：¥{{ number_format(auth()->user()->balance, 2) }}</div>
            </div>
        </label>

        {{-- 网关支付 --}}
        @foreach($gateways as $gw)
        <label class="flex items-center gap-3 p-3 rounded-2xl border-2 cursor-pointer hover:bg-pink-50/30" style="border-color:#FFD1E8">
            <input type="radio" name="gateway" value="{{ $gw->driver }}">
            <span class="text-2xl">{{ $gw->driver === 'epay' ? '💰' : '💳' }}</span>
            <div class="flex-1">
                <div class="font-semibold">{{ $gw->name }}</div>
                <div class="text-xs text-gray-500">跳转第三方支付</div>
            </div>
        </label>
        @endforeach
    </div>
</div>

<div class="flex justify-between">
    <a href="{{ route('orders.index') }}" class="px-6 py-3 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
    <button type="submit" class="anime-btn text-lg px-8 py-3">立即支付 →</button>
</div>

</form>
</div>
@endsection
