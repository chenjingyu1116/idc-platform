@extends('layouts.app')
@section('content')

<h1 class="text-2xl font-bold mb-6">🔍 搜索："{{ $q ?: '全部' }}"</h1>

@if(empty($q))
<div class="anime-card p-8 text-center text-gray-400">
    <div class="text-4xl mb-3">🌸</div>
    <div>请输入关键词进行搜索</div>
</div>
@else

{{-- 产品 --}}
@if($products->count() > 0)
<h2 class="text-xl font-bold mb-3 mt-6" style="color:#FF9EC4">🎀 产品（{{ $products->count() }}）</h2>
<div class="grid md:grid-cols-3 gap-4 mb-8">
    @foreach($products as $p)
    <a href="/product/{{ $p->id }}" class="anime-card p-5 block hover:shadow-lg transition">
        <div class="font-bold text-lg mb-2">{{ $p->name }}</div>
        <div class="text-sm text-gray-500 mb-3">{{ Str::limit($p->description ?? '', 60) }}</div>
        <div class="text-2xl font-bold" style="color:#B39DDB">¥{{ $p->price }}<span class="text-sm text-gray-400">/月</span></div>
    </a>
    @endforeach
</div>
@endif

{{-- 知识库文章 --}}
@if($articles->count() > 0)
<h2 class="text-xl font-bold mb-3 mt-6" style="color:#A8D8FF">📚 知识库（{{ $articles->count() }}）</h2>
<div class="space-y-3 mb-8">
    @foreach($articles as $a)
    <a href="/kb/article/{{ $a->id }}" class="anime-card p-4 block hover:shadow-md transition">
        <div class="font-semibold">{{ $a->title }}</div>
        <div class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($a->content ?? ''), 100) }}</div>
    </a>
    @endforeach
</div>
@endif

{{-- 公告 --}}
@if($announcements->count() > 0)
<h2 class="text-xl font-bold mb-3 mt-6" style="color:#B39DDB">📢 公告（{{ $announcements->count() }}）</h2>
<div class="space-y-3 mb-8">
    @foreach($announcements as $a)
    <a href="/announcements/{{ $a->id }}" class="anime-card p-4 block hover:shadow-md transition">
        <div class="font-semibold">{{ $a->title }}</div>
        <div class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($a->content ?? ''), 100) }}</div>
    </a>
    @endforeach
</div>
@endif

{{-- 无结果 --}}
@if($products->count() + $articles->count() + $announcements->count() === 0)
<div class="anime-card p-12 text-center text-gray-400">
    <div class="text-5xl mb-4">🔍</div>
    <div class="text-lg">没有找到与「{{ $q }}」相关的结果</div>
    <div class="text-sm mt-2">换个关键词试试吧 🌸</div>
</div>
@endif

@endif

@endsection
