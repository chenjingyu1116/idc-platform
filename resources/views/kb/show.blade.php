@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:text-pink-500">← 返回</a>
<article class="anime-card rounded-2xl p-8 mt-4">
<h1 class="text-2xl font-bold mb-4">{{ $article->title }}</h1>
<div class="text-xs text-gray-400 mb-6">{{ optional($article->created_at)->format('Y-m-d H:i') }}</div>
<div class="prose max-w-none whitespace-pre-wrap">{!! nl2br(e($article->content)) !!}</div>
</article>
</div>
@endsection
