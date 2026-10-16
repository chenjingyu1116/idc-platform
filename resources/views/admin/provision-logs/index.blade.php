@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">📋 开通日志</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">服务</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">动作</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">上游</th>
</tr></thead>
<tbody>
@forelse($logs as $log)
<tr class="border-b border-pink-50">
<td class="px-6 py-4 text-xs text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</td>
<td class="px-6 py-4">#{{ $log->service_id ?? '-' }}</td>
<td class="px-6 py-4">{{ $log->action ?? '-' }}</td>
<td class="px-6 py-4">
@if(($log->status ?? '') === 'success')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,255,196,.3);color:#2E7D5C">成功</span>
@elseif(($log->status ?? '') === 'failed')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,158,196,.3);color:#C2185B">失败</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,229,180,.3);color:#B8860B">{{ $log->status ?? '-' }}</span>
@endif
</td>
<td class="px-6 py-4">{{ optional($log->provider)->name ?? '-' }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">暂无日志</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $logs->links() }}</div>
</div>
@endsection
