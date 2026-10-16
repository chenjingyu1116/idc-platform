@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">💰 充值审核</h1>
</div>

<form method="POST" action="{{ route('admin.recharges.batchApprove') }}" id="batch-form">
@csrf

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left"><input type="checkbox" id="check-all" onclick="toggleAll(this)"></th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">金额</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr>
</thead>
<tbody>
@forelse(($recharges ?? collect()) as $r)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-4 py-3">
    @if($r->status === 'pending')
    <input type="checkbox" name="ids[]" value="{{ $r->id }}" class="row-check">
    @endif
</td>
<td class="px-6 py-3">
    @if($r->user)
        {{ $r->user->name }}
        <span class="text-xs text-gray-400">({{ $r->user->email }})</span>
    @else
        <span class="text-gray-400">已删除用户 #{{ $r->user_id }}</span>
    @endif
</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">¥{{ $r->amount ?? 0 }}</td>
<td class="px-6 py-3">
    @if($r->status === 'approved')
        <span class="text-green-500">✅ 已到账</span>
    @elseif($r->status === 'rejected')
        <span class="text-red-500">❌ 已拒绝</span>
    @else
        <span class="text-yellow-500">⏳ 待审核</span>
    @endif
</td>
<td class="px-6 py-3 text-xs text-gray-500">
    {{ $r->created_at ? $r->created_at->format('Y-m-d H:i') : '-' }}
</td>
<td class="px-6 py-3">
    @if($r->status === 'pending')
        <form method="POST" action="{{ route('admin.recharges.approve', $r) }}" class="inline">
            @csrf
            <button class="text-green-500 hover:underline">批准</button>
        </form>
    @else
        <span class="text-gray-400">已处理</span>
    @endif
</td>
</tr>
@empty
<tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">暂无充值记录</td></tr>
@endforelse
</tbody>
</table>

@if(method_exists($recharges ?? collect(), 'links'))
<div class="px-6 py-4">{{ $recharges->links() }}</div>
@endif
</div>

<div class="mt-4 flex justify-end">
<button type="submit" class="anime-btn">✅ 批量批准选中</button>
</div>
</form>

<script>
function toggleAll(el) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = el.checked);
}
</script>
@endsection
