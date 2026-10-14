@extends('layouts.app')
@section('content')
<a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-pink-500">← 返回用户列表</a>
<h1 class="text-2xl font-bold mb-6 mt-2">{{ $user->name }} 的资料</h1>

<div class="grid md:grid-cols-3 gap-4 mb-6">
<div class="anime-card p-6">
<div class="text-xs text-gray-500">余额</div>
<div class="text-3xl font-bold" style="color:#FF9EC4">¥{{ $user->balance }}</div>
</div>
<div class="anime-card p-6">
<div class="text-xs text-gray-500">订单数</div>
<div class="text-3xl font-bold" style="color:#B39DDB">{{ $user->orders->count() }}</div>
</div>
<div class="anime-card p-6">
<div class="text-xs text-gray-500">服务数</div>
<div class="text-3xl font-bold" style="color:#A8D8FF">{{ $user->services->count() }}</div>
</div>
</div>

<div class="anime-card p-6 mb-6">
<h2 class="font-bold mb-3" style="color:#FF9EC4">⚡ 快捷操作</h2>
<div class="flex flex-wrap gap-3">
<form method="POST" action="{{ route('admin.users.adjust-balance', $user) }}" class="flex gap-2 items-center">@csrf
<input type="number" name="amount" step="0.01" placeholder="调整金额(正负)" class="px-3 py-2 rounded-2xl border-2 w-40" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<button type="submit" class="anime-btn-soft text-xs">💰 调整余额</button>
</form>
<form method="POST" action="{{ route('admin.users.reset-password', $user) }}">@csrf
<button type="submit" class="anime-btn-soft text-xs" onclick="return confirm('确定重置密码？')">🔑 重置密码</button>
</form>
</div>
</div>

<div class="anime-card p-6 mb-6">
<h2 class="font-bold mb-3" style="color:#FF9EC4">📦 最近订单</h2>
@forelse($user->orders->take(10) as $o)
<div class="border-b border-pink-50 py-2 flex justify-between text-sm">
<span class="font-mono text-xs">{{ $o->order_no }}</span>
<span class="font-mono">¥{{ $o->total_amount }}</span>
<span class="text-xs">{{ $o->status }}</span>
</div>
@empty
<div class="text-center text-gray-400 py-4">暂无订单</div>
@endforelse
</div>

<div class="anime-card p-6">
<h2 class="font-bold mb-3" style="color:#FF9EC4">💻 服务列表</h2>
@forelse($user->services as $s)
<div class="border-b border-pink-50 py-2 flex justify-between text-sm">
<span>#{{ $s->id }} - {{ $s->ip_address ?? '未分配' }}</span>
<span class="text-xs">{{ $s->status }}</span>
</div>
@empty
<div class="text-center text-gray-400 py-4">暂无服务</div>
@endforelse
</div>
@endsection
