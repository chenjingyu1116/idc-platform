@extends('layouts.app')
@section('content')

@php
    $u = $user ?? auth()->user();
    $referralCount = $referralCount ?? 0;
    $totalCommission = $totalCommission ?? 0;
    $referralCode = $u->referral_code ?? ('REF' . str_pad($u->id ?? 0, 6, '0', STR_PAD_LEFT));
@endphp

<h1 class="text-2xl font-bold mb-6">🌸 代理中心</h1>

{{-- 推荐码 --}}
<div class="anime-card p-6 mb-6">
    <div class="text-sm text-gray-500 mb-2">我的推荐码</div>
    <div class="flex items-center gap-3">
        <code class="text-2xl font-bold" style="color:#FF9EC4">{{ $referralCode }}</code>
        <button onclick="navigator.clipboard.writeText('{{ $referralCode }}');this.innerText='已复制✓'"
                class="anime-btn-soft text-xs">复制</button>
    </div>
    <div class="text-xs text-gray-400 mt-3">
        分享链接：{{ url('/register?ref=' . $referralCode) }}
    </div>
</div>

{{-- 统计卡片 --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="anime-card p-6 text-center">
        <div class="text-4xl mb-2">🎖️</div>
        <div class="text-xs text-gray-500">当前等级</div>
        <div class="text-lg font-bold mt-1" style="color:#FF9EC4">
            @if(method_exists($u, 'agentLevelName'))
                {{ $u->agentLevelName() }}
            @else
                普通代理
            @endif
        </div>
    </div>
    <div class="anime-card p-6 text-center">
        <div class="text-4xl mb-2">👥</div>
        <div class="text-xs text-gray-500">我的下级</div>
        <div class="text-3xl font-bold" style="color:#B39DDB">{{ $referralCount }}</div>
    </div>
    <div class="anime-card p-6 text-center">
        <div class="text-4xl mb-2">💰</div>
        <div class="text-xs text-gray-500">累计返佣</div>
        <div class="text-3xl font-bold" style="color:#FF9EC4">¥{{ number_format($totalCommission, 2) }}</div>
    </div>
    <div class="anime-card p-6 text-center">
        <div class="text-4xl mb-2">💴</div>
        <div class="text-xs text-gray-500">可提现</div>
        <div class="text-3xl font-bold" style="color:#A8D8FF">¥{{ number_format($u->balance ?? 0, 2) }}</div>
    </div>
</div>

{{-- 说明 --}}
<div class="anime-card p-6">
    <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">📖 代理说明</h2>
    <ul class="space-y-2 text-sm text-gray-600">
        <li>🌸 分享推荐码给朋友，他们注册后自动成为你的下级</li>
        <li>💎 下级下单购买产品，你获得订单金额的返佣</li>
        <li>💰 返佣自动计入余额，可随时提现或用于续费</li>
        <li>👑 下级越多、消费越多，你的等级越高，返佣比例越高</li>
    </ul>
</div>

@endsection
