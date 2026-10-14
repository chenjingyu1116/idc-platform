@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<a href="{{ route('client.services.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回服务列表</a>

<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🌸 服务详情</h1>

<div class="anime-card p-8">
<div class="flex items-center gap-4 mb-6 pb-6" style="border-bottom:2px dashed rgba(255,158,196,.3)">
<div class="text-5xl">🖥️</div>
<div class="flex-1">
<div class="text-xl font-bold">{{ optional($service->product)->name ?? '云服务器' }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">订单号：{{ optional($service->order)->order_no ?? '-' }}</div>
</div>
<div>
@if($service->status === 'active')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已激活</span>
@elseif($service->status === 'suspended')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏸ 已暂停</span>
@elseif($service->status === 'pending')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(255,158,196,.25);color:#FF6B9E">⏳ 等待分配</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(156,163,175,.25);color:#6B7280">{{ $service->status }}</span>
@endif
</div>
</div>

<div class="space-y-3">
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">🌐 IP 地址</span>
<span class="font-mono font-bold">{{ $service->ip_address ?? '等待分配' }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">👤 用户名</span>
<span class="font-mono font-bold">{{ $service->username ?? '等待分配' }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">🔑 密码</span>
<span class="font-mono font-bold" style="color:#FF6B9E">{{ $service->password_encrypted ?? '等待分配' }}</span>
</div>
<div class="flex justify-between py-2" style="border-bottom:1px dashed rgba(255,158,196,.2)">
<span class="text-sm" style="color:#9CA3AF">📅 到期时间</span>
<span class="font-bold">{{ $service->expires_at ? $service->expires_at->format('Y-m-d H:i') : '未设置' }}</span>
</div>
<div class="flex justify-between py-2">
<span class="text-sm" style="color:#9CA3AF">💴 续费价格</span>
<span class="font-bold" style="color:#FF9EC4">¥{{ optional($service->product)->price ?? 0 }} / 月</span>
</div>
</div>

<div class="flex gap-3 mt-6 pt-6" style="border-top:2px dashed rgba(255,158,196,.3)">
@if($service->status === 'active')
<form method="POST" action="{{ route('client.services.renew',$service) }}" class="flex-1">
@csrf
<button type="submit" class="anime-btn w-full" onclick="return confirm('确认续费 ¥{{ optional($service->product)->price ?? 0 }} 一个月？')">💗 立即续费</button>
</form>
<form method="POST" action="{{ route('client.services.suspend',$service) }}" class="flex-1">
@csrf
<button type="submit" class="anime-btn-soft w-full" onclick="return confirm('确认暂停服务？')">⏸ 暂停服务</button>
</form>
@elseif($service->status === 'suspended')
<form method="POST" action="{{ route('client.services.unsuspend',$service) }}" class="flex-1">
@csrf
<button type="submit" class="anime-btn w-full">▶️ 恢复服务</button>
</form>
@endif
</div>
</div>

@if($renewals->count() > 0)
<div class="mt-8">
<h3 class="text-xl font-bold mb-4" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">📜 续费记录</h3>
<div class="anime-card overflow-hidden">
@foreach($renewals as $r)
<div class="flex justify-between items-center p-4" style="border-top:1px solid rgba(255,158,196,.15)">
<div>
<div class="text-sm font-bold">💴 ¥{{ $r->amount }} · {{ $r->cycle === 'monthly' ? '包月' : $r->cycle }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">{{ $r->created_at->format('Y-m-d H:i') }}</div>
</div>
<div class="text-xs" style="color:#9CA3AF">
到期时间：{{ $r->expires_at ? $r->expires_at->format('Y-m-d') : '-' }}
</div>
</div>
@endforeach
</div>
</div>
@endif

<div class="mt-6 anime-card p-5 text-sm" style="background:rgba(255,229,180,.15)">
💡 <strong>提示：</strong>如果服务长时间未激活，请前往工单页面联系客服，樱花喵会尽快为您处理。
</div>
</div>
@endsection
