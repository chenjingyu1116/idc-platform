@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">⚙️ 资源管理</h1>

<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="anime-card p-4 text-center"><div class="text-xs text-gray-500">总数</div><div class="text-2xl font-bold">{{ $stats['total'] }}</div></div>
    <div class="anime-card p-4 text-center"><div class="text-xs text-gray-500">已激活</div><div class="text-2xl font-bold" style="color:#7FD8BE">{{ $stats['active'] }}</div></div>
    <div class="anime-card p-4 text-center"><div class="text-xs text-gray-500">待分配</div><div class="text-2xl font-bold" style="color:#FFB6D5">{{ $stats['pending'] }}</div></div>
    <div class="anime-card p-4 text-center"><div class="text-xs text-gray-500">已暂停</div><div class="text-2xl font-bold" style="color:#FFB3B3">{{ $stats['suspended'] }}</div></div>
</div>

<form method="GET" class="anime-card p-4 mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-xs text-gray-500 mb-1">关键词</label>
        <input type="text" name="kw" value="{{ request('kw') }}" placeholder="IP / 用户 / 订单号" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">状态</label>
        <select name="status" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
            <option value="">全部</option>
            @foreach(['pending','active','suspended','terminated'] as $s)
                <option value="{{ $s }}" @if(request('status')===$s) selected @endif>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="anime-btn">🔍 搜索</button>
    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">重置</a>
</form>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400">订单号</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">客户</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">产品</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">状态</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">操作</th>
</tr></thead>
<tbody>
@forelse($services as $service)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-4 py-3 font-mono text-xs">{{ optional($service->order)->order_no ?? '-' }}</td>
<td class="px-4 py-3">{{ optional($service->user)->name ?? '-' }}</td>
<td class="px-4 py-3">{{ optional($service->product)->name ?? '-' }}</td>
<td class="px-4 py-3">
<span class="px-2 py-0.5 rounded-full text-xs
    @if($service->status==='active') bg-green-100 text-green-700
    @elseif($service->status==='pending') bg-yellow-100 text-yellow-700
    @elseif($service->status==='suspended') bg-red-100 text-red-700
    @else bg-gray-100 text-gray-600 @endif">{{ $service->status }}</span>
</td>
<td class="px-4 py-3 space-x-2 text-sm">
@if($service->status === 'pending')
<a href="{{ route('admin.services.edit', $service) }}" class="text-pink-500 hover:underline">分配</a>
@elseif($service->status === 'active')
<form method="POST" action="{{ route('admin.services.suspend', $service) }}" class="inline">@csrf<button class="text-yellow-600 hover:underline">暂停</button></form>
@elseif($service->status === 'suspended')
<form method="POST" action="{{ route('admin.services.unsuspend', $service) }}" class="inline">@csrf<button class="text-green-600 hover:underline">恢复</button></form>
@endif
<form method="POST" action="{{ route('admin.services.terminate', $service) }}" class="inline" onsubmit="return confirm('确认终止该服务？不可恢复')">@csrf<button class="text-red-500 hover:underline">终止</button></form>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">没有符合条件的服务</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $services->links() }}</div>
</div>
@endsection
