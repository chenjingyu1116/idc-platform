@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🔔 通知中心</h1>

@php
    $items = $notifications ?? collect();
@endphp

<div class="anime-card rounded-2xl overflow-hidden">
@forelse($items as $n)
<div class="p-5 border-b border-pink-50 hover:bg-pink-50/30 transition flex gap-4">
    <div class="text-2xl">
        @if(($n->type ?? 'info') === 'success') 🌸
        @elseif(($n->type ?? 'info') === 'warning') ⚠️
        @elseif(($n->type ?? 'info') === 'error') ❌
        @else 💎
        @endif
    </div>
    <div class="flex-1">
        <div class="flex justify-between items-start">
            <div class="font-semibold">{{ $n->title ?? '通知' }}</div>
            <div class="text-xs text-gray-400">{{ optional($n->created_at)->diffForHumans() }}</div>
        </div>
        <div class="text-sm text-gray-500 mt-1">{{ $n->content ?? '' }}</div>
    </div>
</div>
@empty
<div class="p-12 text-center text-gray-400">
<div class="text-4xl mb-3">📭</div>
<div>暂无通知</div>
</div>
@endforelse
</div>

@if(method_exists($items, 'links') && $items->hasPages())
<div class="mt-4">{{ $items->links() }}</div>
@endif
@endsection
