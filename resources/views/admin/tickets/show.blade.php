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

{{-- 原始工单 --}}
<div class="anime-card p-5 mb-4">
    <div class="flex justify-between items-start mb-2">
        <div class="font-semibold">
            👤 {{ optional($ticket->user)->name ?? '客户' }}
        </div>
        <div class="text-xs text-gray-400">
            {{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : '' }}
        </div>
    </div>
    <div class="whitespace-pre-wrap text-sm">{{ $ticket->content }}</div>
</div>

{{-- 回复列表 --}}
@php
    $replies = method_exists($ticket, 'replies') ? $ticket->replies : collect();
@endphp

@foreach($replies as $reply)
<div class="anime-card p-5 mb-4" style="{{ $reply->is_staff ? 'border-color:rgba(255,158,196,.5)' : '' }}">
    <div class="flex justify-between items-start mb-2">
        <div class="font-semibold">
            {{ $reply->is_staff ? '🌸 客服' : '👤 客户' }}
        </div>
        <div class="text-xs text-gray-400">
            {{ $reply->created_at ? $reply->created_at->format('Y-m-d H:i') : '' }}
        </div>
    </div>
    <div class="whitespace-pre-wrap text-sm">{{ $reply->message }}</div>
    @if(!empty($reply->file_path))
    <div class="mt-3">
        <a href="{{ asset('storage/' . $reply->file_path) }}" target="_blank" class="text-xs text-pink-500 hover:underline">📎 下载附件</a>
    </div>
    @endif
</div>
@endforeach

{{-- 回复表单 --}}
@if($ticket->status !== 'closed')
<form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}" enctype="multipart/form-data" class="anime-card p-5 space-y-3">
    @csrf
    <textarea name="message" rows="4" required
              class="w-full px-4 py-3 rounded-2xl border-2"
              style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
              placeholder="输入回复内容..."></textarea>
    <div class="flex items-center justify-between">
        <input type="file" name="file" class="text-xs">
        <button type="submit" class="anime-btn">📤 发送回复</button>
    </div>
</form>

<form method="POST" action="{{ route('admin.tickets.close', $ticket) }}" class="mt-3 text-right">
    @csrf
    <button type="submit" class="text-xs text-gray-400 hover:text-red-500">关闭工单</button>
</form>
@endif

<a href="{{ route('admin.tickets.index') }}" class="block mt-6 text-cyan-500 hover:underline">← 返回工单列表</a>
</div>
@endsection
