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
<th class="px-6 py-3 text-left text-xs text-pink-400">代码</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">面值</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">已用/总量</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">已发/持有</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">状态</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">操作</th>
</tr>
</thead>
<tbody>
@forelse($coupons as $c)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-3 font-mono text-sm">{{ $c->code }}</td>
<td class="px-6 py-3">{{ $c->name }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">
    {{ $c->type === 'fixed' ? '¥'.$c->value : $c->value.'%' }}
</td>
<td class="px-6 py-3 text-sm">{{ $c->used }} / {{ $c->total > 0 ? $c->total : '不限' }}</td>
<td class="px-6 py-3 text-sm">{{ $c->userCoupons()->count() ?? 0 }} 人</td>
<td class="px-6 py-3">
    @if($c->is_active)<span class="text-green-500">✅ 启用</span>
    @else<span class="text-gray-400">停用</span>@endif
</td>
<td class="px-6 py-3 space-x-2 text-sm">
    <a href="{{ route('admin.coupons.distribute', $c) }}" class="text-pink-500 hover:underline">发放</a>
    <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}" class="inline"
          onsubmit="return confirm('确认删除？')">
        @csrf @method('DELETE')
        <button class="text-red-500 hover:underline">删除</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">暂无优惠券</td></tr>
@endforelse
</tbody>
</table>
@if($coupons->hasPages())
<div class="px-6 py-4">{{ $coupons->links() }}</div>
@endif
</div>
@endsection
