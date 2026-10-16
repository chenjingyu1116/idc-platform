@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">
<h1 class="text-2xl font-bold mb-6">📊 产品对比</h1>

{{-- 选择产品 --}}
<form method="GET" action="{{ route('products.compare') }}" class="anime-card p-5 mb-6">
    <div class="text-sm text-gray-500 mb-3">选择要对比的产品（最多 4 个）</div>
    <div class="flex flex-wrap gap-2 mb-3">
        @foreach($allProducts as $p)
        <label class="cursor-pointer">
            <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="peer hidden"
                   {{ $products->contains('id', $p->id) ? 'checked' : '' }}>
            <span class="inline-block px-4 py-2 rounded-full text-sm border-2 transition
                peer-checked:bg-pink-100 peer-checked:border-pink-400"
                  style="border-color:#FFD1E8">
                {{ $p->name }}
            </span>
        </label>
        @endforeach
    </div>
    <button type="submit" class="anime-btn text-sm">对比这些产品</button>
</form>

@if($products->count() > 0)
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
    <th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">规格</th>
    @foreach($products as $p)
    <th class="px-4 py-3 text-center">
        <div class="font-semibold">{{ $p->name }}</div>
        <div class="text-xs text-gray-400 mt-1">¥{{ $p->price }}/月</div>
    </th>
    @endforeach
</tr>
</thead>
<tbody>
@php
$rows = [
    'CPU' => 'cpu', '内存' => 'memory', '硬盘' => 'disk', '带宽' => 'bandwidth',
];
@endphp
@foreach($rows as $label => $key)
<tr class="border-b border-pink-50">
    <td class="px-4 py-3 text-sm text-gray-500">{{ $label }}</td>
    @foreach($products as $p)
    <td class="px-4 py-3 text-center font-semibold">{{ $p->config[$key] ?? '-' }}</td>
    @endforeach
</tr>
@endforeach
<tr class="border-b border-pink-50">
    <td class="px-4 py-3 text-sm text-gray-500">价格</td>
    @foreach($products as $p)
    <td class="px-4 py-3 text-center font-bold" style="color:#FF9EC4">¥{{ $p->price }}</td>
    @endforeach
</tr>
<tr>
    <td class="px-4 py-3"></td>
    @foreach($products as $p)
    <td class="px-4 py-3 text-center">
        <a href="{{ route('product.show', $p) }}" class="anime-btn-soft text-xs">查看详情</a>
    </td>
    @endforeach
</tr>
</tbody>
</table>
</div>
@else
<div class="anime-card p-12 text-center text-gray-400">
    <div class="text-4xl mb-3">📊</div>
    <div>请在上方选择至少 2 个产品进行对比</div>
</div>
@endif

</div>
@endsection
