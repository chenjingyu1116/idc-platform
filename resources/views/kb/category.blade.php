@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<h1 class="text-2xl font-bold mb-6">{{ $category->name ?? '知识库' }}</h1>
<div class="space-y-3">
@forelse(($articles ?? []) as $a)
<a href="{{ route('kb.show', $a) }}" class="anime-card p-4 block hover:shadow-md transition">
<div class="font-semibold">{{ $a->title }}</div>
<div class="text-xs text-gray-500 mt-1">{{ optional($a->created_at)->format('Y-m-d') }}</div>
</a>
@empty
<div class="anime-card p-8 text-center text-gray-400">此分类下暂无文章</div>
@endforelse
</div>
</div>
@endsection
