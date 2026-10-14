@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">👑 会员等级</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">最低消费</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">折扣</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">积分倍率</th>
</tr></thead>
<tbody>
@forelse($levels as $l)
<tr class="border-b border-pink-50">
<td class="px-6 py-4">
<span class="px-3 py-1 rounded-full text-xs" style="background:{{ $l->color ?? '#FF9EC4' }}22;color:{{ $l->color ?? '#FF9EC4' }}">{{ $l->name }}</span>
</td>
<td class="px-6 py-4 font-mono">¥{{ $l->min_spent }}</td>
<td class="px-6 py-4">{{ $l->discount }}%</td>
<td class="px-6 py-4">×{{ $l->points_multiplier }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无等级</td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
