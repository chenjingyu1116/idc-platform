@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">📜 审计日志</h1>
<form method="GET" class="anime-card p-4 mb-6 flex gap-3">
<input type="text" name="kw" value="{{ request('kw') }}" placeholder="搜索事件 / IP" class="flex-1 px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<button type="submit" class="anime-btn">🔍 搜索</button>
</form>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">事件</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">IP</th>
</tr></thead>
<tbody>
@forelse($logs as $log)
<tr class="border-b border-pink-50">
<td class="px-6 py-3 text-xs text-gray-500">{{ optional($log->created_at)->format('Y-m-d H:i:s') }}</td>
<td class="px-6 py-3">{{ optional($log->user)->name ?? '系统' }}</td>
<td class="px-6 py-3 font-mono text-sm">{{ $log->event }}</td>
<td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $log->ip_address ?? '-' }}</td>
</tr>
@empty<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无日志</td></tr>@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $logs->links() }}</div>
</div>
@endsection
