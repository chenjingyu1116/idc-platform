@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<a href="{{ route('admin.tickets.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回工单列表</a>
<h1 class="text-2xl font-bold mt-4 mb-6" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">{{ $ticket->title }}</h1>

<div class="anime-card p-6 mb-4">
<div class="text-xs mb-4" style="color:#9CA3AF">来自：{{ optional($ticket->user)->name ?? '-' }} · {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
<div class="whitespace-pre-wrap" style="color:#4A4A6A">{{ $ticket->content }}</div>
</div>

@if($ticket->reply)
<div class="anime-card p-6 mb-4" style="background:rgba(255,229,180,.15)">
<div class="text-xs mb-3" style="color:#D97706">🐱 已回复</div>
<div class="whitespace-pre-wrap" style="color:#4A4A6A">{{ $ticket->reply }}</div>
</div>
@endif

@if($ticket->status !== 'closed')
<form method="POST" action="{{ route('admin.tickets.reply',$ticket) }}" class="anime-card p-6">
@csrf
<div class="mb-4">
<label class="block text-sm mb-2" style="color:#7A7A9A">💬 回复内容</label>
<textarea name="reply" rows="6" class="w-full" placeholder="樱花喵的回复..." required></textarea>
</div>
<div class="flex justify-end">
<button type="submit" class="anime-btn">🌸 提交回复</button>
</div>
</form>
@endif
</div>
@endsection
