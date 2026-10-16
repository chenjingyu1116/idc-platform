@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🔗 产品映射</h1>
    <a href="{{ route('admin.product-mappings.create') }}" class="anime-btn text-sm">+ 添加映射</a>
</div>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">本地产品</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">上游供应商</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">上游产品 ID</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">创建时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">操作</th>
</tr>
</thead>
<tbody>
@forelse($mappings ?? collect() as $m)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-3">{{ optional($m->product)->name ?? '-' }}</td>
<td class="px-6 py-3">
    {{ optional($m->provider)->name ?? '-' }}
    <span class="text-xs text-gray-400">({{ optional($m->provider)->driver ?? '-' }})</span>
</td>
<td class="px-6 py-3 font-mono text-sm">{{ $m->upstream_product_id }}</td>
<td class="px-6 py-3 text-xs text-gray-500">{{ optional($m->created_at)->format('Y-m-d H:i') }}</td>
<td class="px-6 py-3">
    <form method="POST" action="{{ route('admin.product-mappings.destroy', $m) }}" class="inline"
          onsubmit="return confirm('确认删除该映射？')">
        @csrf @method('DELETE')
        <button class="text-red-500 hover:underline text-sm">删除</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">
    <div class="text-4xl mb-3">🔗</div>
    <div>暂无映射</div>
    <div class="text-xs mt-2">点击右上角「+ 添加映射」把本地产品关联到上游</div>
</td></tr>
@endforelse
</tbody>
</table>
@if(method_exists($mappings ?? collect(), 'links'))
<div class="px-6 py-4">{{ $mappings->links() }}</div>
@endif
</div>
@endsection
