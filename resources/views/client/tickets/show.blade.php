@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">💌 {{ $ticket->title }}</h1>
    <span class="px-3 py-1 rounded-full text-xs
        @if($ticket->status === 'closed') bg-gray-200 text-gray-600
        @elseif($ticket->status === 'processing') bg-blue-100 text-blue-700
        @else bg-green-100 text-green-700 @endif">
        {{ $ticket->status === 'closed' ? '已关闭' : ($ticket->status === 'processing' ? '处理中' : '待处理') }}
    </span>
</div>

<div class="space-y-4 mb-6">
    <div class="flex gap-3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0" style="background:linear-gradient(135deg,#A8D8FF,#7AB8E8)">👤</div>
        <div class="flex-1">
            <div class="anime-card p-4 rounded-2xl">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-semibold">{{ optional($ticket->user)->name ?? '我' }}</div>
                    <div class="text-xs text-gray-400">{{ optional($ticket->created_at)->format('Y-m-d H:i') }}</div>
                </div>
                <div class="whitespace-pre-wrap text-sm">{{ $ticket->content }}</div>
            </div>
        </div>
    </div>

    @foreach(($ticket->replies ?? collect()) as $reply)
    <div class="flex gap-3 {{ $reply->is_staff ? '' : 'flex-row-reverse' }}">
        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0"
             style="background:{{ $reply->is_staff ? 'linear-gradient(135deg,#FF9EC4,#B39DDB)' : 'linear-gradient(135deg,#A8D8FF,#7AB8E8)' }}">
            {{ $reply->is_staff ? '🌸' : '👤' }}
        </div>
        <div class="flex-1">
            <div class="anime-card p-4 rounded-2xl" style="{{ $reply->is_staff ? 'border-color:rgba(255,158,196,.5)' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-semibold">{{ $reply->is_staff ? '客服' : '我' }}</div>
                    <div class="text-xs text-gray-400">{{ optional($reply->created_at)->format('Y-m-d H:i') }}</div>
                </div>
                <div class="whitespace-pre-wrap text-sm">{{ $reply->message }}</div>
                @if($reply->file_path)
                <div class="mt-3"><a href="{{ asset("storage/" . $reply->file_path) }}" target="_blank" class="text-xs text-pink-500 hover:underline">📎 下载附件</a></div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($ticket->status !== 'closed')
<form method="POST" action="{{ route('client.tickets.reply', $ticket) }}" enctype="multipart/form-data" class="anime-card p-5 space-y-3">
    @csrf
    <textarea name="message" rows="4" required
              class="w-full px-4 py-3 rounded-2xl border-2"
              style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
              placeholder="补充说明..."></textarea>
    <div class="flex items-center justify-between">
        <input type="file" name="file" class="text-xs">
        <button type="submit" class="anime-btn">📤 发送</button>
    </div>
</form>
@endif

<a href="{{ route('client.tickets.index') }}" class="block mt-6 text-cyan-500 hover:underline">← 返回工单列表</a>
</div>
@endsection
