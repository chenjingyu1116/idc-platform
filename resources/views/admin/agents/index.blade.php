@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🌸 代理管理</h1>
    <a href="{{ route('admin.agents.create') }}" class="anime-btn text-sm">+ 添加代理</a>
</div>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">推荐码</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">等级</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">佣金比例</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">累计收益</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">可提现</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
</tr>
</thead>
<tbody>
@forelse($agents ?? collect() as $a)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-3">
    {{ optional($a->user)->name ?? '-' }}
    <span class="text-xs text-gray-400">({{ optional($a->user)->email ?? '-' }})</span>
</td>
<td class="px-6 py-3 font-mono text-sm">{{ $a->code ?? '-' }}</td>
<td class="px-6 py-3">
    <span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,158,196,.15);color:#FF9EC4">
        {{ $a->level ?? '普通' }}
    </span>
</td>
<td class="px-6 py-3">{{ ($a->commission_rate ?? 0.05) * 100 }}%</td>
<td class="px-6 py-3 font-mono" style="color:#B39DDB">¥{{ number_format($a->total_earned ?? 0, 2) }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">¥{{ number_format($a->withdrawable ?? 0, 2) }}</td>
<td class="px-6 py-3">
    @if($a->is_active ?? true)
        <span class="text-green-500">✅ 启用</span>
    @else
        <span class="text-gray-400">停用</span>
    @endif
</td>
</tr>
@empty
<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">暂无代理，点击右上角添加</td></tr>
@endforelse
</tbody>
</table>
@if(method_exists($agents ?? collect(), 'links'))
<div class="px-6 py-4">{{ $agents->links() }}</div>
@endif
</div>
@endsection
