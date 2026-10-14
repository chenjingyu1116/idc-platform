@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">📡 系统监控</h1>

{{-- 计数卡片 --}}
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="anime-card p-6 text-center">
        <div class="text-sm text-gray-500">订单总数</div>
        <div class="text-3xl font-bold" style="color:#FF9EC4">{{ $counts['orders'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6 text-center">
        <div class="text-sm text-gray-500">服务总数</div>
        <div class="text-3xl font-bold" style="color:#A8D8FF">{{ $counts['services'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6 text-center">
        <div class="text-sm text-gray-500">已激活</div>
        <div class="text-3xl font-bold" style="color:#B39DDB">{{ $counts['active_services'] ?? 0 }}</div>
    </div>
</div>

{{-- 系统信息 --}}
<div class="anime-card p-6">
    <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">🖥️ 系统信息</h2>
    <div class="grid md:grid-cols-2 gap-3">
        @forelse(($info ?? []) as $key => $value)
        <div class="flex justify-between py-2 border-b border-pink-100 last:border-0">
            <span class="text-gray-500 text-sm">{{ $key }}</span>
            <span class="font-mono text-sm">{{ is_array($value) ? json_encode($value) : $value }}</span>
        </div>
        @empty
        <div class="text-center text-gray-400 py-4 col-span-2">暂无系统信息</div>
        @endforelse
    </div>
</div>
@endsection
