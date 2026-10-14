@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">📊 报表统计</h1>

{{-- 汇总卡片 --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总用户</div>
        <div class="text-3xl font-bold" style="color:#FF9EC4">{{ $summary['total_users'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总服务</div>
        <div class="text-3xl font-bold" style="color:#A8D8FF">{{ $summary['total_services'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总佣金</div>
        <div class="text-3xl font-bold" style="color:#B39DDB">¥{{ $summary['total_commission'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">统计天数</div>
        <div class="text-3xl font-bold" style="color:#FFB6D5">{{ count($days ?? []) }} 天</div>
    </div>
</div>

{{-- 收入走势 --}}
<div class="anime-card p-6 mb-8">
    <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">💴 收入走势</h2>
    <div class="space-y-2">
        @foreach((is_array($days ?? null) ? $days : ($days ?? collect())->toArray()) as $i => $day)
        <div class="flex items-center gap-3">
            <span class="w-24 text-sm text-gray-500">{{ $day }}</span>
            <div class="flex-1 h-6 rounded-full overflow-hidden" style="background:rgba(255,158,196,.15)">
                @php $revArr = is_array($revenue ?? null) ? $revenue : (($revenue ?? collect())->toArray() ?: []); $max = max(array_values($revArr ?: [1])) ?: 1; @endphp
                <div class="h-full rounded-full" style="width:{{ min(100, (($revArr[$i] ?? 0) / $max) * 100) }}%;background:linear-gradient(90deg,#FF9EC4,#B39DDB)"></div>
            </div>
            <span class="w-20 text-right font-mono text-sm">¥{{ $revenue[$i] ?? 0 }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- 订单 + 用户 --}}
<div class="grid md:grid-cols-2 gap-6 mb-8">
    <div class="anime-card p-6">
        <h2 class="text-lg font-bold mb-4" style="color:#A8D8FF">📦 订单数走势</h2>
        @foreach((is_array($days ?? null) ? $days : ($days ?? collect())->toArray()) as $i => $day)
        <div class="flex justify-between text-sm py-1">
            <span class="text-gray-500">{{ $day }}</span>
            <span class="font-mono">{{ $orderCount[$i] ?? 0 }}</span>
        </div>
        @endforeach
    </div>
    <div class="anime-card p-6">
        <h2 class="text-lg font-bold mb-4" style="color:#B39DDB">👥 新增用户走势</h2>
        @foreach((is_array($days ?? null) ? $days : ($days ?? collect())->toArray()) as $i => $day)
        <div class="flex justify-between text-sm py-1">
            <span class="text-gray-500">{{ $day }}</span>
            <span class="font-mono">{{ $userCount[$i] ?? 0 }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- 热门产品 --}}
<div class="anime-card p-6">
    <h2 class="text-lg font-bold mb-4" style="color:#FFB6D5">🔥 热门产品 Top 5</h2>
    @forelse(($topProducts ?? []) as $p)
    <div class="flex justify-between py-2 border-b border-pink-100 last:border-0">
        <span>{{ $p->name ?? $p['name'] ?? '-' }}</span>
        <span class="font-mono text-sm" style="color:#FF9EC4">{{ $p->count ?? $p['count'] ?? 0 }} 笔</span>
    </div>
    @empty
    <div class="text-center text-gray-400 py-4">暂无数据</div>
    @endforelse
</div>
@endsection
