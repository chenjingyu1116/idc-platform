@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-3">
    <h1 class="text-2xl font-bold">📦 订单管理</h1>
    <a href="{{ route('admin.orders.export', request()->query()) }}" class="anime-btn-soft text-sm">📥 导出 CSV</a>
</div>

{{-- 统计卡 --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="anime-card p-4 text-center">
        <div class="text-xs text-gray-500">总订单</div>
        <div class="text-2xl font-bold" style="color:#FF9EC4">{{ $summary['total'] }}</div>
    </div>
    <div class="anime-card p-4 text-center">
        <div class="text-xs text-gray-500">已支付</div>
        <div class="text-2xl font-bold" style="color:#7FD8BE">{{ $summary['paid'] }}</div>
    </div>
    <div class="anime-card p-4 text-center">
        <div class="text-xs text-gray-500">收入总额</div>
        <div class="text-2xl font-bold" style="color:#B39DDB">¥{{ number_format($summary['amount'], 2) }}</div>
    </div>
</div>

{{-- 搜索/筛选 --}}
<form method="GET" class="anime-card p-4 mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-xs text-gray-500 mb-1">关键词</label>
        <input type="text" name="kw" value="{{ request('kw') }}" placeholder="订单号 / 用户名 / 邮箱" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">状态</label>
        <select name="status" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
            <option value="">全部</option>
            @foreach(['pending','paid','active','cancelled','refunded'] as $s)
                <option value="{{ $s }}" @if(request('status')===$s) selected @endif>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="anime-btn">🔍 搜索</button>
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">重置</a>
</form>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400">订单号</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">用户</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">产品</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">金额</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">状态</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">时间</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">操作</th>
</tr></thead>
<tbody>
@forelse($orders as $o)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-4 py-3 font-mono text-xs">{{ $o->order_no }}</td>
<td class="px-4 py-3">{{ optional($o->user)->name ?? '-' }}</td>
<td class="px-4 py-3">{{ optional($o->product)->name ?? '-' }}</td>
<td class="px-4 py-3 font-mono" style="color:#FF9EC4">¥{{ $o->total_amount }}</td>
<td class="px-4 py-3">
@if($o->status === 'paid')
<span class="px-2 py-0.5 rounded-full text-xs" style="background:rgba(127,216,190,.2);color:#2E7D5C">已支付</span>
@elseif($o->status === 'pending')
<span class="px-2 py-0.5 rounded-full text-xs" style="background:rgba(255,229,180,.3);color:#B8860B">待支付</span>
@else
<span class="px-2 py-0.5 rounded-full text-xs" style="background:rgba(200,200,200,.3);color:#666">{{ $o->status }}</span>
@endif
</td>
<td class="px-4 py-3 text-xs text-gray-500">{{ optional($o->created_at)->format('m-d H:i') }}</td>
<td class="px-4 py-3">
<a href="{{ route('admin.orders.show', $o) }}" class="text-pink-500 hover:underline text-sm">详情</a>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">没有符合条件的订单</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $orders->links() }}</div>
</div>
@endsection
