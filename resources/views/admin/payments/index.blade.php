@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-bold">💳 支付配置</h1>
<a href="{{ route('admin.payments.create') }}" class="anime-btn">+ 添加支付</a>
</div>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">驱动</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr></thead>
<tbody>
@forelse($payments as $p)
<tr class="border-b border-pink-50">
<td class="px-6 py-4">{{ $p->name }}</td>
<td class="px-6 py-4 font-mono text-sm">{{ $p->driver }}</td>
<td class="px-6 py-4">@if($p->is_active ?? true)<span class="text-green-500">启用</span>@else<span class="text-gray-400">停用</span>@endif</td>
<td class="px-6 py-4">
<a href="{{ route('admin.payments.edit', $p) }}" class="text-pink-500 hover:underline">编辑</a>
</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无支付方式</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $payments->links() }}</div>
</div>
@endsection
