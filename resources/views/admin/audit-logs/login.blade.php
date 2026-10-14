@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🔐 登录记录</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">IP</th>
</tr></thead>
<tbody>
@forelse($logs as $log)
<tr class="border-b border-pink-50">
<td class="px-6 py-3 text-xs text-gray-500">{{ optional($log->created_at)->format('Y-m-d H:i:s') }}</td>
<td class="px-6 py-3">{{ optional($log->user)->name ?? '-' }}</td>
<td class="px-6 py-3 font-mono text-xs">{{ $log->ip_address ?? '-' }}</td>
</tr>
@empty<tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">暂无记录</td></tr>@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $logs->links() }}</div>
</div>
@endsection
