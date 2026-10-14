@extends('layouts.app')
@section('content')
<a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-pink-500">← 返回订单列表</a>
<h1 class="text-2xl font-bold mb-6 mt-2">订单详情 #{{ $order->order_no }}</h1>

<div class="grid md:grid-cols-2 gap-6 mb-6">
<div class="anime-card p-6 space-y-2">
<h2 class="font-bold mb-3" style="color:#FF9EC4">订单信息</h2>
<div class="text-sm">下单时间：{{ $order->created_at->format('Y-m-d H:i:s') }}</div>
<div class="text-sm">支付时间：{{ $order->paid_at ? $order->paid_at->format('Y-m-d H:i:s') : '未支付' }}</div>
<div class="text-sm">金额：<span class="font-mono" style="color:#FF9EC4">¥{{ $order->total_amount }}</span></div>
<div class="text-sm">状态：{{ $order->status }}</div>
</div>
<div class="anime-card p-6 space-y-2">
<h2 class="font-bold mb-3" style="color:#FF9EC4">用户信息</h2>
<div class="text-sm">姓名：{{ optional($order->user)->name }}</div>
<div class="text-sm">邮箱：{{ optional($order->user)->email }}</div>
<div class="text-sm">余额：¥{{ optional($order->user)->balance }}</div>
</div>
</div>

<div class="anime-card p-6 mb-6">
<h2 class="font-bold mb-3" style="color:#FF9EC4">修改状态</h2>
<form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex gap-3 flex-wrap">@csrf
<select name="status" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
@foreach(['pending'=>'待支付','paid'=>'已支付','provisioning'=>'开通中','active'=>'已激活','cancelled'=>'已取消','refunded'=>'已退款'] as $k=>$v)
<option value="{{ $k }}" @if($order->status==$k) selected @endif>{{ $v }}</option>
@endforeach
</select>
<button type="submit" class="anime-btn">保存</button>
</form>
</div>

<div class="anime-card p-6">
<h2 class="font-bold mb-3" style="color:#FF9EC4">关联服务</h2>
@forelse($order->services as $s)
<div class="border-b border-pink-50 py-2 flex justify-between">
<div class="text-sm">服务 #{{ $s->id }} - {{ optional($s->product)->name }}</div>
<div class="text-xs">状态：{{ $s->status }} | IP：{{ $s->ip_address ?? '未分配' }}</div>
</div>
@empty
<div class="text-center text-gray-400 py-4">无关联服务</div>
@endforelse
</div>
@endsection
