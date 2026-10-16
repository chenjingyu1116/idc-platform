@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🔗 产品映射</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">本地产品</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">上游</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">上游产品 ID</th>
</tr></thead>
<tbody>
@forelse($mappings as $m)
<tr class="border-b border-pink-50">
<td class="px-6 py-4">{{ optional($m->product)->name ?? '-' }}</td>
<td class="px-6 py-4">{{ optional($m->provider)->name ?? '-' }}</td>
<td class="px-6 py-4 font-mono">{{ $m->upstream_product_id }}</td>
</tr>
@empty
<tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">暂无映射</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $mappings->links() }}</div>
</div>
@endsection
