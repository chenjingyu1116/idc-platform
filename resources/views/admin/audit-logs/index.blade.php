@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">📜 审计日志</h1>
<div class="anime-card rounded-lg overflow-hidden">
<table class="min-w-full divide-y divide-pink-100">
<thead class="bg-pink-50">
<tr>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">时间</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">用户</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">事件</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">IP</th>
</tr>
</thead>
<tbody class="divide-y divide-pink-100">
@forelse($logs as $l)
<tr>
<td class="px-6 py-4 text-sm text-gray-500">{{ $l->created_at->format('Y-m-d H:i:s') }}</td>
<td class="px-6 py-4">{{ optional($l->user)->name ?? '系统' }}</td>
<td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs" style="background:rgba(255,158,196,.15);color:#FF9EC4">{{ $l->event }}</span></td>
<td class="px-6 py-4 font-mono text-sm text-gray-500">{{ $l->ip_address ?? '-' }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无日志</td></tr>
@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $logs->links() }}</div>
</div>
@endsection
