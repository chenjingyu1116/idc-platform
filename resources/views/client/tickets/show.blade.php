@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('client.tickets.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回工单列表</a>

<h1 class="text-2xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">{{ $ticket->title }}</h1>

<div class="anime-card p-6 mb-4">
<div class="text-xs mb-4" style="color:#9CA3AF">{{ $ticket->created_at->format('Y-m-d H:i') }} · 
@if($ticket->status === 'closed')
<span style="color:#6B7280">已关闭</span>
@else
<span style="color:#16A34A">处理中</span>
@endif
</div>
<div class="whitespace-pre-wrap" style="color:#4A4A6A">{{ $ticket->content }}</div>
</div>

@if($ticket->reply)
<div class="anime-card p-6" style="background:rgba(255,229,180,.15)">
<div class="flex items-center gap-2 mb-3">
<span class="text-2xl">🐱</span>
<span class="font-bold text-sm" style="color:#FF9EC4">樱花喵的回复</span>
</div>
<div class="whitespace-pre-wrap" style="color:#4A4A6A">{{ $ticket->reply }}</div>
</div>
@endif
</div>
@endsection
