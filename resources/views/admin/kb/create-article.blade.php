@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">📝 新建知识库文章</h1>
<form method="POST" action="{{ route('admin.kb.storeArticle') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm text-gray-500 mb-1">所属分类</label>
<select name="kb_category_id" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
@foreach(($categories ?? []) as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm text-gray-500 mb-1">标题</label>
<input type="text" name="title" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">内容</label>
<textarea name="content" rows="10" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></textarea></div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.kb.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
