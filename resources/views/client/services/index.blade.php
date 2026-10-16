@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💗 我的服务</h1>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">产品</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">IP 地址</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">到期时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr>
</thead>
<tbody>
@forelse($services ?? collect() as $service)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-4">
    {{ optional($service->product)->name ?? '-' }}
    {{-- 优惠标识 --}}
    @if($service->order && ($service->order->discount_amount ?? 0) > 0)
        <span class="ml-2 px-2 py-0.5 rounded-full text-xs"
              style="background:rgba(255,158,196,.15);color:#FF9EC4">
            🎫 已省 ¥{{ number_format($service->order->discount_amount, 2) }}
        </span>
    @endif
</td>
<td class="px-6 py-4">
    @if($service->status === 'active')
        <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-600 text-xs border border-green-500/30">已激活</span>
    @elseif($service->status === 'pending')
        <span class="px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-600 text-xs border border-yellow-500/30">等待分配</span>
    @else
        <span class="px-3 py-1 rounded-full bg-gray-500/20 text-gray-600 text-xs">{{ $service->status }}</span>
    @endif
</td>
<td class="px-6 py-4 font-mono text-gray-600">{{ $service->ip_address ?? '待分配' }}</td>
<td class="px-6 py-4 text-xs text-gray-500">
    {{ $service->expires_at ? $service->expires_at->format('Y-m-d') : '-' }}
</td>
<td class="px-6 py-4">
    <a href="{{ route('client.services.show', $service) }}" class="text-cyan-500 hover:underline text-sm">查看详情</a>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">
    <div class="text-4xl mb-3">💗</div>
    <div>暂无服务，去产品页选购吧</div>
</td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
