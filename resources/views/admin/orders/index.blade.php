@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🧾 订单管理</h1>

<form method="GET" class="anime-card rounded-2xl p-4 mb-6 flex flex-wrap gap-3 items-center">
<input type="text" name="kw" value="{{ request('kw') }}" placeholder="订单号 / 用户名 / 邮箱" class="px-4 py-2 rounded-2xl border-2 flex-1 min-w-[200px]" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<select name="status" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="">全部状态</option>
@foreach(['pending'=>'待支付','paid'=>'已支付','provisioning'=>'开通中','active'=>'已激活','cancelled'=>'已取消','refunded'=>'已退款'] as $k=>$v)
<option value="{{ $k }}" @if(request('status')==$k) selected @endif>{{ $v }}</option>
@endforeach
</select>
<button type="submit" class="anime-btn">🔍 搜索</button>
</form>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">订单号</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">用户</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">产品</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">金额</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr></thead>
<tbody>
@forelse($orders as $o)
<tr class="border-b border-pink-50">
<td class="px-4 py-4 font-mono text-xs">{{ $o->order_no }}</td>
<td class="px-4 py-4 text-sm">{{ optional($o->user)->name ?? '-' }}</td>
<td class="px-4 py-4 text-sm">{{ optional($o->product)->name ?? '-' }}</td>
<td class="px-4 py-4 font-mono">¥{{ $o->total_amount }}</td>
<td class="px-4 py-4">
<span class="px-2 py-1 rounded-full text-xs" style="background:rgba(255,158,196,.2)">{{ $o->status }}</span>
</td>
<td class="px-4 py-4">
<a href="{{ route('admin.orders.show', $o) }}" class="text-pink-500 hover:underline text-sm">详情</a>
</td>
</tr>
@empty
<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">暂无订单</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $orders->links() }}</div>
</div>
@endsection
