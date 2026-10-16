@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-bold">🎫 优惠券管理</h1>
</div>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">代码</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">类型</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">面值</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">已用</th>
</tr></thead>
<tbody>
@forelse($coupons as $c)
<tr class="border-b border-pink-50">
<td class="px-6 py-4 font-mono">{{ $c->code }}</td>
<td class="px-6 py-4">{{ $c->name }}</td>
<td class="px-6 py-4">{{ $c->type === 'fixed' ? '固定金额' : '百分比' }}</td>
<td class="px-6 py-4">{{ $c->type === 'fixed' ? '¥'.$c->value : $c->value.'%' }}</td>
<td class="px-6 py-4">{{ $c->used_count ?? 0 }} / {{ $c->max_uses ?? '∞' }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">暂无优惠券</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $coupons->links() }}</div>
</div>
@endsection
