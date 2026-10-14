@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💸 提现申请</h1>
<div class="grid md:grid-cols-2 gap-6">
<div class="anime-card rounded-lg p-6">
<h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">申请提现</h2>
<form method="POST" action="{{ url('/client/withdrawal') }}">@csrf
<div class="mb-4">
<label class="block text-sm text-gray-500 mb-1">提现金额（元）</label>
<input type="number" name="amount" min="10" step="0.01" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required>
</div>
<div class="mb-4">
<label class="block text-sm text-gray-500 mb-1">收款账号</label>
<input type="text" name="account" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" placeholder="支付宝/微信账号" required>
</div>
<button type="submit" class="anime-btn w-full">提交申请</button>
</form>
</div>
<div class="anime-card rounded-lg p-6">
<h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">提现记录</h2>
<div class="space-y-3">
@forelse($withdrawals as $w)
<div class="flex justify-between items-center p-3 rounded-2xl" style="background:rgba(255,245,250,.5)">
<div>
<div class="font-bold">¥{{ $w->amount }}</div>
<div class="text-xs text-gray-500">{{ $w->created_at->format('Y-m-d H:i') }}</div>
</div>
@if($w->status === 'approved')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(76,175,80,.15);color:#4CAF50">已到账</span>
@elseif($w->status === 'rejected')
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(244,67,54,.15);color:#F44336">已拒绝</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(255,193,7,.15);color:#FF9800">待审核</span>
@endif
</div>
@empty
<div class="text-center text-gray-400 py-4">暂无记录</div>
@endforelse
</div>
</div>
</div>
@endsection
