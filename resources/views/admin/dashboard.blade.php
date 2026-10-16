@extends('layouts.app')
@section('content')

@php
    // 最近 7 天数据
    $days = [];
    $revenueData = [];
    $orderData = [];
    $userData = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = now()->subDays($i)->format('m-d');
        $days[] = $d;
        $revenueData[] = \App\Models\Order::whereDate('created_at', now()->subDays($i))
            ->where('status', 'paid')->sum('total_amount') ?? 0;
        $orderData[] = \App\Models\Order::whereDate('created_at', now()->subDays($i))->count();
        $userData[] = \App\Models\User::whereDate('created_at', now()->subDays($i))->count();
    }

    $stats = [
        'users' => \App\Models\User::count(),
        'orders' => \App\Models\Order::count(),
        'revenue' => \App\Models\Order::where('status', 'paid')->sum('total_amount'),
        'active' => \App\Models\Service::where('status', 'active')->count(),
        'pending' => \App\Models\Service::where('status', 'pending')->count(),
    ];
@endphp

<h1 class="text-2xl font-bold mb-6">👑 管理看板</h1>

{{-- 统计卡片 --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="anime-card p-5 text-center">
        <div class="text-3xl mb-1">👥</div>
        <div class="text-xs text-gray-500">总用户</div>
        <div class="text-2xl font-bold" style="color:#FF9EC4">{{ $stats['users'] }}</div>
    </div>
    <div class="anime-card p-5 text-center">
        <div class="text-3xl mb-1">📦</div>
        <div class="text-xs text-gray-500">总订单</div>
        <div class="text-2xl font-bold" style="color:#A8D8FF">{{ $stats['orders'] }}</div>
    </div>
    <div class="anime-card p-5 text-center">
        <div class="text-3xl mb-1">💰</div>
        <div class="text-xs text-gray-500">总收入</div>
        <div class="text-2xl font-bold" style="color:#B39DDB">¥{{ number_format($stats['revenue'], 0) }}</div>
    </div>
    <div class="anime-card p-5 text-center">
        <div class="text-3xl mb-1">✅</div>
        <div class="text-xs text-gray-500">已激活</div>
        <div class="text-2xl font-bold" style="color:#7FD8BE">{{ $stats['active'] }}</div>
    </div>
    <div class="anime-card p-5 text-center">
        <div class="text-3xl mb-1">⏳</div>
        <div class="text-xs text-gray-500">待分配</div>
        <div class="text-2xl font-bold" style="color:#FFB6D5">{{ $stats['pending'] }}</div>
    </div>
</div>

{{-- 收入曲线 --}}
<div class="anime-card p-6 mb-6">
    <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">💴 最近 7 天收入</h2>
    @include('components.chart', [
        'id' => 'revenueChart',
        'type' => 'line',
        'labels' => $days,
        'datasets' => [[
            'label' => '收入 (¥)',
            'data' => $revenueData,
            'borderColor' => '#FF9EC4',
            'backgroundColor' => 'rgba(255,158,196,.15)',
            'tension' => .4,
            'fill' => true,
        ]],
    ])
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="anime-card p-6">
        <h2 class="text-lg font-bold mb-4" style="color:#A8D8FF">📦 订单趋势</h2>
        @include('components.chart', [
            'id' => 'orderChart',
            'type' => 'bar',
            'labels' => $days,
            'datasets' => [[
                'label' => '订单数',
                'data' => $orderData,
                'backgroundColor' => 'rgba(168,216,255,.6)',
                'borderColor' => '#7AB8E8',
                'borderWidth' => 1,
            ]],
            'height' => 250,
        ])
    </div>
    <div class="anime-card p-6">
        <h2 class="text-lg font-bold mb-4" style="color:#B39DDB">👥 新增用户</h2>
        @include('components.chart', [
            'id' => 'userChart',
            'type' => 'line',
            'labels' => $days,
            'datasets' => [[
                'label' => '新增用户',
                'data' => $userData,
                'borderColor' => '#B39DDB',
                'backgroundColor' => 'rgba(179,157,219,.15)',
                'tension' => .4,
                'fill' => true,
            ]],
            'height' => 250,
        ])
    </div>
</div>

@endsection
