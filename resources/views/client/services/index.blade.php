@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">💗 我的服务</h1>
<a href="{{ route('orders.index') }}" class="anime-btn-soft text-sm">+ 购买新服务</a>
</div>

@forelse($services as $service)
<div class="anime-card p-6 mb-4">
<div class="flex flex-wrap justify-between items-center gap-4">
<div class="flex items-center gap-4">
<div class="text-3xl">🖥️</div>
<div>
<div class="font-bold text-lg">{{ optional($service->product)->name ?? '服务' }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">
订单号：{{ optional($service->order)->order_no ?? '-' }}
</div>
</div>
</div>
<div class="flex items-center gap-3">
@if($service->status === 'active')
<span class="px-4 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已激活</span>
@elseif($service->status === 'suspended')
<span class="px-4 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏸ 已暂停</span>
@else
<span class="px-4 py-1 rounded-full text-xs font-bold" style="background:rgba(255,158,196,.25);color:#FF6B9E">⏳ 等待分配</span>
@endif
<a href="{{ route('client.services.show',$service) }}" class="anime-btn-soft text-xs">查看详情 →</a>
</div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4 text-xs">
<div class="px-3 py-2 rounded-lg" style="background:rgba(168,216,255,.15)">🌐 IP: {{ $service->ip_address ?? '待分配' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(255,229,180,.2)">👤 用户: {{ $service->username ?? '待分配' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(179,157,219,.15)">📅 到期: {{ $service->expires_at ? $service->expires_at->format('Y-m-d') : '未设置' }}</div>
<div class="px-3 py-2 rounded-lg" style="background:rgba(255,158,196,.1)">💰 ¥{{ optional($service->product)->price ?? 0 }}/月</div>
</div>
</div>
@empty
<div class="anime-card p-12 text-center">
<div class="text-6xl mb-4">🌸</div>
<div class="text-lg font-bold mb-2" style="color:#FF9EC4">还没有任何服务</div>
<p class="text-sm mb-6" style="color:#9CA3AF">快去挑选一台樱花喵守护的服务器吧</p>
<a href="{{ route('orders.index') }}" class="anime-btn">✨ 立即选购</a>
</div>
@endforelse
@endsection
