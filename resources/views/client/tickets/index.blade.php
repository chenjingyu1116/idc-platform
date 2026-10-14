@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">💌 我的工单</h1>
<a href="{{ route('client.tickets.create') }}" class="anime-btn text-sm" style="padding:10px 24px">+ 提交工单</a>
</div>

@forelse($tickets as $t)
<div class="anime-card p-6 mb-4">
<div class="flex justify-between items-center gap-4">
<div class="flex items-center gap-3">
<div class="text-2xl">📝</div>
<div>
<div class="font-bold">{{ $t->title }}</div>
<div class="text-xs mt-1" style="color:#9CA3AF">{{ $t->created_at->format('Y-m-d H:i') }}</div>
</div>
</div>
<div class="flex items-center gap-3">
@if($t->status === 'closed')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(156,163,175,.25);color:#6B7280">已关闭</span>
@else
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">✓ 处理中</span>
@endif
<a href="{{ route('client.tickets.show',$t) }}" class="anime-btn-soft text-xs">查看详情 →</a>
</div>
</div>
</div>
@empty
<div class="anime-card p-12 text-center">
<div class="text-6xl mb-4">💌</div>
<div class="text-lg font-bold mb-2" style="color:#FF9EC4">还没有工单</div>
<p class="text-sm mb-6" style="color:#9CA3AF">有任何问题都可以提交工单联系樱花喵</p>
<a href="{{ route('client.tickets.create') }}" class="anime-btn">✨ 提交工单</a>
</div>
@endforelse
@endsection
