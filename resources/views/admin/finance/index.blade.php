@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💰 财务管理</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
<div class="anime-card p-6"><div class="text-sm text-gray-500">累计收入</div><div class="text-3xl font-bold" style="color:#FF9EC4">¥{{ number_format($total ?? 0, 2) }}</div></div>
<div class="anime-card p-6"><div class="text-sm text-gray-500">今日收入</div><div class="text-3xl font-bold" style="color:#A8D8FF">¥{{ number_format($today ?? 0, 2) }}</div></div>
<div class="anime-card p-6"><div class="text-sm text-gray-500">本月收入</div><div class="text-3xl font-bold" style="color:#B39DDB">¥{{ number_format($month ?? 0, 2) }}</div></div>
<div class="anime-card p-6"><div class="text-sm text-gray-500">待结算</div><div class="text-3xl font-bold" style="color:#FFB6D5">¥{{ number_format($pending ?? 0, 2) }}</div></div>
</div>
<div class="anime-card p-6">
<h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">📋 最近交易</h2>
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">用户</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">金额</th>
</tr></thead>
<tbody>
@forelse(($transactions ?? []) as $t)
<tr class="border-b border-pink-50">
<td class="px-6 py-3 text-xs text-gray-500">{{ optional($t->created_at)->format('Y-m-d H:i') }}</td>
<td class="px-6 py-3">{{ optional($t->user)->name ?? '-' }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">¥{{ $t->amount }}</td>
</tr>
@empty<tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">暂无交易</td></tr>@endforelse
</tbody></table>
</div>
@endsection
