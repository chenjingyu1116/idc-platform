@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">💸 提现审核</h1>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,229,244,.5)">
<tr>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">用户</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">金额</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">收款方式</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">状态</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">时间</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($withdrawals as $w)
<tr class="border-t border-pink-100">
<td class="px-6 py-4">
<div class="font-semibold">{{ optional($w->user)->name ?? '-' }}</div>
<div class="text-xs" style="color:#9CA3AF">{{ optional($w->user)->email ?? '-' }}</div>
</td>
<td class="px-6 py-4 font-bold" style="color:#FF9EC4">¥{{ $w->amount }}</td>
<td class="px-6 py-4 text-xs">
<div>{{ $w->method }}</div>
<div style="color:#9CA3AF">{{ $w->account }} @if($w->account_name) ({{ $w->account_name }}) @endif</div>
</td>
<td class="px-6 py-4">
@if($w->status === 'approved')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,255,200,.4);color:#4A9E6B">✅ 已通过</span>
@elseif($w->status === 'rejected')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,200,200,.4);color:#C66">❌ 已拒绝</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,229,180,.5);color:#C68A00">⏳ 待审核</span>
@endif
</td>
<td class="px-6 py-4 text-xs" style="color:#9CA3AF">{{ $w->created_at->format('Y-m-d H:i') }}</td>
<td class="px-6 py-4 space-y-1">
@if($w->status === 'pending')
<form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}" class="inline">@csrf
<button type="submit" class="text-xs font-semibold" style="color:#4A9E6B">✅ 批准</button>
</form>
<form method="POST" action="{{ route('admin.withdrawals.reject', $w) }}" class="inline">@csrf
<button type="submit" class="text-xs font-semibold" style="color:#C66">❌ 拒绝</button>
</form>
@else
<span class="text-xs" style="color:#9CA3AF">已处理</span>
@endif
</td>
</tr>
@empty
<tr><td colspan="6" class="px-6 py-12 text-center">
<div class="text-5xl mb-3">💸</div>
<div style="color:#9CA3AF">暂无提现申请</div>
</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $withdrawals->links() }}</div>
</div>
@endsection
