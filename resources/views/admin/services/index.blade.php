@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">⚙️ 资源管理</h1>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,158,196,.1)">
<tr>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">订单号</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">客户</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">产品</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">IP</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">状态</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($services as $service)
<tr style="border-top:1px solid rgba(255,158,196,.15)">
<td class="px-5 py-3 font-mono text-sm">{{ optional($service->order)->order_no ?? '-' }}</td>
<td class="px-5 py-3 text-sm">{{ optional($service->user)->name ?? '-' }}</td>
<td class="px-5 py-3 text-sm">{{ optional($service->product)->name ?? '-' }}</td>
<td class="px-5 py-3 font-mono text-sm" style="color:#7A7A9A">{{ $service->ip_address ?? '待分配' }}</td>
<td class="px-5 py-3">
@if($service->status === 'active')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已激活</span>
@elseif($service->status === 'pending')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏳ 待分配</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(248,113,113,.25);color:#DC2626">{{ $service->status }}</span>
@endif
</td>
<td class="px-5 py-3">
@if($service->status !== 'active')
<a href="{{ route('admin.services.edit',$service) }}" class="anime-btn-soft text-xs">🌸 分配资源</a>
@else
<span class="text-xs" style="color:#9CA3AF">已分配</span>
@endif
</td>
</tr>
@empty
<tr><td colspan="6" class="px-5 py-10 text-center" style="color:#9CA3AF">🌙 暂无服务</td></tr>
@endforelse
</tbody>
</table>
<div class="px-5 py-4">{{ $services->links() }}</div>
</div>
@endsection
