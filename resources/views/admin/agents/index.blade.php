@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🌸 代理管理</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">推荐码</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">佣金</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">已提现</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
</tr></thead>
<tbody>
@forelse($agents as $a)
<tr class="border-b border-pink-50">
<td class="px-6 py-4">{{ optional($a->user)->name ?? '-' }}</td>
<td class="px-6 py-4 font-mono">{{ $a->referral_code ?? '-' }}</td>
<td class="px-6 py-4 font-mono" style="color:#FF9EC4">¥{{ $a->commission ?? 0 }}</td>
<td class="px-6 py-4 font-mono">¥{{ $a->withdrawn ?? 0 }}</td>
<td class="px-6 py-4">@if($a->is_active ?? true)<span class="text-green-500">启用</span>@else<span class="text-gray-400">停用</span>@endif</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">暂无代理</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $agents->links() }}</div>
</div>
@endsection
