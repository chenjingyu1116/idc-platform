@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mb-6 text-center" style="color:#FF9EC4">📚 帮助中心</h1>
<div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
@forelse(($categories ?? []) as $cat)
<a href="{{ route('kb.category', $cat) }}" class="anime-card p-6 block hover:shadow-lg transition">
<div class="text-2xl mb-2">📁</div>
<div class="font-bold text-lg">{{ $cat->name }}</div>
<div class="text-sm text-gray-500 mt-1">{{ $cat->description ?? '点击查看详情' }}</div>
</a>
@empty
<div class="col-span-2 anime-card p-8 text-center text-gray-400">暂无内容</div>
@endforelse
</div>
@endsection
