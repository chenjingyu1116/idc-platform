@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">💌 工单管理</h1>

<div class="anime-card overflow-hidden">
<table class="min-w-full table-responsive">
<thead style="background:rgba(255,158,196,.1)">
<tr>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">用户</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">标题</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">状态</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">时间</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($tickets as $t)
<tr style="border-top:1px solid rgba(255,158,196,.15)">
<td class="px-5 py-3 text-sm">{{ optional($t->user)->name ?? '-' }}</td>
<td class="px-5 py-3 text-sm font-bold">{{ $t->title }}</td>
<td class="px-5 py-3">
@if($t->status === 'closed')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(156,163,175,.25);color:#6B7280">已关闭</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">处理中</span>
@endif
</td>
<td class="px-5 py-3 text-xs" style="color:#9CA3AF">{{ $t->created_at->format('Y-m-d H:i') }}</td>
<td class="px-5 py-3"><a href="{{ route('admin.tickets.show',$t) }}" class="anime-btn-soft text-xs">查看回复</a></td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-10 text-center" style="color:#9CA3AF">🌙 暂无工单</td></tr>
@endforelse
</tbody>
</table>
<div class="px-5 py-4">{{ $tickets->links() }}</div>
</div>
@endsection
