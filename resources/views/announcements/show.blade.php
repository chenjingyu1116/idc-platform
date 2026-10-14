@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
<a href="{{ route('announcements.index') }}" class="text-sm font-semibold" style="color:#B39DDB">← 返回公告列表</a>

<article class="anime-card p-8 mt-6">
<div class="flex items-center gap-3 mb-4 flex-wrap">
@if($announcement->is_pinned)
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(255,158,196,.3);color:#FF6B9E">📌 置顶</span>
@endif
@php
$__typeColors = [
  'info' => ['rgba(168,216,255,.3)','#4A6FA5','💙'],
  'warning' => ['rgba(255,229,180,.5)','#C68A00','💛'],
  'success' => ['rgba(168,255,200,.4)','#4A9E6B','💚'],
  'danger' => ['rgba(255,200,200,.4)','#C66','❤️'],
];
$__tc = $__typeColors[$announcement->type] ?? $__typeColors['info'];
@endphp
<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:{{ $__tc[0] }};color:{{ $__tc[1] }}">{{ $__tc[2] }} {{ $announcement->type }}</span>
<div class="text-xs" style="color:#9CA3AF">📅 {{ $announcement->published_at ? $announcement->published_at->format('Y-m-d H:i') : '' }}</div>
</div>

<h1 class="text-3xl font-bold mb-6" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">{{ $announcement->title }}</h1>

<div class="prose max-w-none leading-relaxed whitespace-pre-wrap" style="color:#4A4A6A">{{ $announcement->content }}</div>
</article>

<div class="mt-6">
<a href="{{ route('announcements.index') }}" class="anime-btn-soft text-sm">← 返回公告列表</a>
</div>
</div>
@endsection
