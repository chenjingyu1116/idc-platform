@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-bold">📚 知识库管理</h1>
<div class="space-x-2">
<a href="{{ route('admin.kb.createCategory') }}" class="anime-btn-soft text-xs">+ 分类</a>
<a href="{{ route('admin.kb.createArticle') }}" class="anime-btn text-xs" style="padding:8px 20px">+ 文章</a>
</div>
</div>
<div class="anime-card rounded-2xl p-6">
<h2 class="font-bold mb-4" style="color:#FF9EC4">分类列表</h2>
@forelse(($categories ?? []) as $cat)
<div class="py-2 border-b border-pink-50">
<span class="font-semibold">{{ $cat->name }}</span>
<span class="text-xs text-gray-400 ml-2">{{ $cat->articles_count ?? 0 }} 篇</span>
</div>
@empty
<div class="text-center text-gray-400 py-4">暂无分类</div>
@endforelse
</div>
@endsection
