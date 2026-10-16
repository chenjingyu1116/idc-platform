@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💸 提现审核</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">代理</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">金额</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">操作</th>
</tr></thead>
<tbody>
@forelse($withdrawals as $w)
<tr class="border-b border-pink-50">
<td class="px-6 py-3">{{ optional(optional($w->agent)->user)->name ?? '-' }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">¥{{ $w->amount }}</td>
<td class="px-6 py-3">
@if($w->status === 'approved')<span class="text-green-500">已批准</span>
@elseif($w->status === 'rejected')<span class="text-red-500">已拒绝</span>
@else<span class="text-yellow-500">待审核</span>@endif
</td>
<td class="px-6 py-3 space-x-2">
@if($w->status === 'pending')
<form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}" class="inline">@csrf<button class="text-green-500 hover:underline">批准</button></form>
<form method="POST" action="{{ route('admin.withdrawals.reject', $w) }}" class="inline">@csrf<button class="text-red-500 hover:underline">拒绝</button></form>
@else<span class="text-gray-400">已处理</span>@endif
</td>
</tr>
@empty<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无提现记录</td></tr>@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $withdrawals->links() }}</div>
</div>
@endsection
