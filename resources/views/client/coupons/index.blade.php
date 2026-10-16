@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🎫 我的优惠券</h1>

@php
    $userCoupons = auth()->user()->userCoupons()->with('coupon')->latest()->get();
    $unused = $userCoupons->where('status', 'unused');
    $used   = $userCoupons->where('status', 'used');
@endphp

<div class="mb-8">
    <h2 class="text-lg font-bold mb-3" style="color:#FF9EC4">✅ 可用（{{ $unused->count() }}）</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @forelse($unused as $uc)
        <div class="anime-card p-5" style="border-color:rgba(255,158,196,.6)">
            <div class="text-3xl font-bold mb-2" style="color:#FF9EC4">
                {{ $uc->coupon->type === 'fixed' ? '¥'.$uc->coupon->value : $uc->coupon->value.'%' }}
            </div>
            <div class="font-semibold mb-1">{{ $uc->coupon->name }}</div>
            <div class="text-xs font-mono text-gray-500 mb-2">{{ $uc->coupon->code }}</div>
            @if($uc->coupon->min_amount > 0)
            <div class="text-xs text-gray-400">满 ¥{{ $uc->coupon->min_amount }} 可用</div>
            @endif
            @if($uc->coupon->expires_at)
            <div class="text-xs text-red-400 mt-1">有效期至 {{ $uc->coupon->expires_at->format('Y-m-d') }}</div>
            @endif
        </div>
        @empty
        <div class="col-span-3 anime-card p-8 text-center text-gray-400">暂无可用优惠券</div>
        @endforelse
    </div>
</div>

<div>
    <h2 class="text-lg font-bold mb-3 text-gray-400">已使用（{{ $used->count() }}）</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @forelse($used as $uc)
        <div class="anime-card p-5 opacity-50">
            <div class="text-3xl font-bold mb-2 text-gray-400">
                {{ $uc->coupon->type === 'fixed' ? '¥'.$uc->coupon->value : $uc->coupon->value.'%' }}
            </div>
            <div class="font-semibold mb-1">{{ $uc->coupon->name }}</div>
            <div class="text-xs font-mono text-gray-500">{{ $uc->coupon->code }}</div>
            <div class="text-xs text-gray-400 mt-1">使用于 {{ optional($uc->used_at)->format('Y-m-d') }}</div>
        </div>
        @empty
        <div class="col-span-3 anime-card p-8 text-center text-gray-400">暂无已使用记录</div>
        @endforelse
    </div>
</div>
@endsection
