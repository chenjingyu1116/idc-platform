@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">✏️ 编辑公告</h1>
<form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf @method('PUT')
<div><label class="block text-sm text-gray-500 mb-1">标题</label>
<input type="text" name="title" value="{{ $announcement->title }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">内容</label>
<textarea name="content" rows="8" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required>{{ $announcement->content }}</textarea></div>
<div class="flex gap-6">
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_pinned" value="1" @if($announcement->is_pinned) checked @endif>置顶</label>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @if($announcement->is_active) checked @endif>显示</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
