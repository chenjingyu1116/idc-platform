@extends('layouts.app')

@section('content')
<div class="text-center mb-10">
<h1 class="text-4xl font-bold mb-2" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">📢 樱花云公告</h1>
<p class="text-sm" style="color:#9CA3AF">最新动态 · 服务通知 🌸</p>
</div>

@if($announcements->isEmpty())
<div class="anime-card p-12 text-center">
<div class="text-6xl mb-4">🌙</div>
<div style="color:#9CA3AF">暂无公告</div>
</div>
@else
<div class="space-y-5">
@foreach($announcements as $a)
@php
$__typeColors = [
  'info' => ['rgba(168,216,255,.3)','#4A6FA5','💙'],
  'warning' => ['rgba(255,229,180,.5)','#C68A00','💛'],
  'success' => ['rgba(168,255,200,.4)','#4A9E6B','💚'],
  'danger' => ['rgba(255,200,200,.4)','#C66','❤️'],
];
$__tc = $__typeColors[$a->type] ?? $__typeColors['info'];
@endphp
<a href="{{ route('announcements.show', $a) }}" class="block anime-card p-6">
<div class="flex justify-between items-start mb-3">
<div class="flex items-center gap-3 flex-wrap">
@if($a->is_pinned)
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(255,158,196,.3);color:#FF6B9E">📌 置顶</span>
@endif
<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:{{ $__tc[0] }};color:{{ $__tc[1] }}">{{ $__tc[2] }} {{ $a->type }}</span>
</div>
<div class="text-xs" style="color:#9CA3AF">{{ $a->published_at ? $a->published_at->format('Y-m-d') : '' }}</div>
</div>
<h3 class="font-bold text-lg mb-2">{{ $a->title }}</h3>
<div class="text-sm line-clamp-2" style="color:#7A7A9A">{{ Str::limit(strip_tags($a->content), 120) }}</div>
<div class="mt-3 text-xs font-semibold" style="color:#B39DDB">阅读全文 →</div>
</a>
@endforeach
</div>
<div class="mt-8">{{ $announcements->links() }}</div>
@endif
@endsection
