@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-bold">📦 产品管理</h1>
<a href="{{ route('admin.products.create') }}" class="anime-btn">+ 添加产品</a>
</div>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">价格</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">周期</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">库存</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr></thead>
<tbody>
@forelse($products as $p)
<tr class="border-b border-pink-50">
<td class="px-4 py-4">{{ $p->name }}</td>
<td class="px-4 py-4 font-mono" style="color:#FF9EC4">¥{{ $p->price }}</td>
<td class="px-4 py-4 text-xs">{{ $p->billing_cycle }}</td>
<td class="px-4 py-4">{{ $p->stock == -1 ? '不限' : $p->stock }}</td>
<td class="px-4 py-4">@if($p->is_active)<span class="text-green-500 text-xs">上架</span>@else<span class="text-gray-400 text-xs">下架</span>@endif</td>
<td class="px-4 py-4 space-x-2">
<a href="{{ route('admin.products.edit', $p) }}" class="text-pink-500 hover:underline text-sm">编辑</a>
<form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline" onsubmit="return confirm('确定删除？')">@csrf @method('DELETE')
<button class="text-red-400 hover:underline text-sm">删除</button>
</form>
</td>
</tr>
@empty
<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">暂无产品</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $products->links() }}</div>
</div>
@endsection
