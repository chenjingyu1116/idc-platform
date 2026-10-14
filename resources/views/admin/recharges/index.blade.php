@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">💰 充值审核</h1>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,158,196,.1)">
<tr>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">用户</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">金额</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">状态</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">时间</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($recharges as $r)
<tr style="border-top:1px solid rgba(255,158,196,.15)">
<td class="px-5 py-3 text-sm">
<div>{{ optional($r->user)->name ?? '-' }}</div>
<div class="text-xs" style="color:#9CA3AF">{{ optional($r->user)->email ?? '-' }}</div>
</td>
<td class="px-5 py-3 font-bold" style="color:#FF9EC4">¥{{ $r->amount }}</td>
<td class="px-5 py-3">
@if($r->status === 'approved')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已到账</span>
@elseif($r->status === 'rejected')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(248,113,113,.25);color:#DC2626">✗ 已拒绝</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏳ 待审核</span>
@endif
</td>
<td class="px-5 py-3 text-xs" style="color:#9CA3AF">{{ $r->created_at->format('Y-m-d H:i') }}</td>
<td class="px-5 py-3">
@if($r->status === 'pending')
<form method="POST" action="{{ route('admin.recharges.approve',$r) }}" class="inline">@csrf
<button type="submit" class="anime-btn text-xs" style="padding:6px 16px">💗 批准到账</button>
</form>
@else
<span class="text-xs" style="color:#9CA3AF">已处理</span>
@endif
</td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-10 text-center" style="color:#9CA3AF">🌙 暂无充值记录</td></tr>
@endforelse
</tbody>
</table>
<div class="px-5 py-4">{{ $recharges->links() }}</div>
</div>
@endsection
