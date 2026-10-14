@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💸 提现记录</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">代理</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">金额</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr></thead>
<tbody>
@forelse($withdrawals as $w)
<tr class="border-b border-pink-50">
<td class="px-6 py-4">{{ optional(optional($w->agent)->user)->name ?? '-' }}</td>
<td class="px-6 py-4 font-mono" style="color:#FF9EC4">¥{{ $w->amount }}</td>
<td class="px-6 py-4">{{ $w->status }}</td>
<td class="px-6 py-4 text-xs text-gray-500">{{ optional($w->created_at)->format('Y-m-d H:i') }}</td>
<td class="px-6 py-4">
@if($w->status === 'pending')
<form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}" class="inline">@csrf<button class="text-pink-500 hover:underline">批准</button></form>
@else
<span class="text-gray-400">已处理</span>
@endif
</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">暂无记录</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $withdrawals->links() }}</div>
</div>
@endsection
