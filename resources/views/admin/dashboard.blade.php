@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">👑 管理看板</h1>

@php
    $stats = $stats ?? [];
    $recentOrders = $recentOrders ?? collect();
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总用户</div>
        <div class="text-3xl font-bold" style="color:#FF9EC4">{{ $stats['users'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总订单</div>
        <div class="text-3xl font-bold" style="color:#A8D8FF">{{ $stats['orders'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">总收入</div>
        <div class="text-3xl font-bold" style="color:#B39DDB">¥{{ $stats['revenue'] ?? 0 }}</div>
    </div>
    <div class="anime-card p-6">
        <div class="text-sm text-gray-500">已激活服务</div>
        <div class="text-3xl font-bold" style="color:#FFB6D5">{{ $stats['active_services'] ?? 0 }}</div>
    </div>
</div>

<h2 class="text-xl font-bold mb-4">🌸 最近订单</h2>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">订单号</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">金额</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
</tr></thead>
<tbody>
@forelse($recentOrders as $o)
<tr class="border-b border-pink-50">
<td class="px-6 py-4 font-mono text-xs">{{ $o->order_no }}</td>
<td class="px-6 py-4">{{ optional($o->user)->name ?? '-' }}</td>
<td class="px-6 py-4 font-mono">¥{{ $o->total_amount }}</td>
<td class="px-6 py-4">{{ $o->status }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无订单</td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
