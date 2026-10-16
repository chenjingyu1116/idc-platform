@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🎫 优惠券管理</h1>
    <a href="{{ route('admin.coupons.create') }}" class="anime-btn text-sm">+ 添加优惠券</a>
</div>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">代码</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">类型</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">面值</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">已用/总数</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr>
</thead>
<tbody>
@forelse($coupons ?? collect() as $c)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-3 font-mono text-sm">{{ $c->code }}</td>
<td class="px-6 py-3">{{ $c->name }}</td>
<td class="px-6 py-3">{{ $c->type === 'fixed' ? '固定金额' : '百分比' }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">
    {{ $c->type === 'fixed' ? '¥'.$c->value : $c->value.'%' }}
</td>
<td class="px-6 py-3 text-sm">
    {{ $c->used ?? 0 }} / {{ $c->total ?? '∞' }}
</td>
<td class="px-6 py-3">
    @if($c->is_active ?? true)
        <span class="text-green-500">✅ 启用</span>
    @else
        <span class="text-gray-400">停用</span>
    @endif
</td>
<td class="px-6 py-3">
    <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}" class="inline"
          onsubmit="return confirm('确认删除该优惠券？')">
        @csrf @method('DELETE')
        <button class="text-red-500 hover:underline text-sm">删除</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">暂无优惠券，点击右上角添加</td></tr>
@endforelse
</tbody>
</table>
@if(method_exists($coupons ?? collect(), 'links'))
<div class="px-6 py-4">{{ $coupons->links() }}</div>
@endif
</div>
@endsection
