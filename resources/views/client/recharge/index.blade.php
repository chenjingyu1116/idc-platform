@extends('layouts.app')
@section('content')
<div class="text-center mb-10">
<h1 class="text-3xl font-bold mb-2" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">💎 余额充值</h1>
<p class="text-sm" style="color:#9CA3AF">充值后即可购买所有云产品</p>
</div>

<div class="grid md:grid-cols-2 gap-6">
<div class="anime-card p-6">
<h2 class="text-lg font-bold mb-5" style="color:#FF9EC4">✨ 申请充值</h2>
<form method="POST" action="{{ route('client.recharge.store') }}">
@csrf
<div class="mb-5">
<label class="block text-sm mb-2" style="color:#7A7A9A">充值金额（元）</label>
<input type="number" name="amount" min="1" step="0.01" class="w-full" placeholder="请输入金额" required>
</div>
<button type="submit" class="anime-btn w-full">🌸 提交充值申请</button>
</form>
<p class="text-xs mt-4 text-center" style="color:#9CA3AF">
提交后请等待管理员审核，通过后余额自动到账 ✨
</p>
</div>

<div class="anime-card p-6">
<h2 class="text-lg font-bold mb-5" style="color:#FF9EC4">📜 充值记录</h2>
<div class="space-y-3">
@forelse($recharges as $r)
<div class="flex justify-between items-center p-4 rounded-2xl" style="background:rgba(255,245,250,.7);border:1px solid rgba(255,158,196,.2)">
<div>
<div class="font-bold">💴 ¥{{ $r->amount }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">{{ $r->created_at->format('Y-m-d H:i') }}</div>
</div>
<div>
@if($r->status === 'approved')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 已到账</span>
@elseif($r->status === 'rejected')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(248,113,113,.25);color:#DC2626">✗ 已拒绝</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(251,191,36,.25);color:#D97706">⏳ 待审核</span>
@endif
</div>
</div>
@empty
<div class="text-center py-8" style="color:#9CA3AF">
<div class="text-4xl mb-2">🌙</div>
暂无充值记录
</div>
@endforelse
</div>
</div>
</div>
@endsection
