@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">📢 发布公告</h1>
<form method="POST" action="{{ route('admin.announcements.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm text-gray-500 mb-1">标题</label>
<input type="text" name="title" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">内容</label>
<textarea name="content" rows="8" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></textarea></div>
<div><label class="block text-sm text-gray-500 mb-1">类型</label>
<select name="type" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="info">一般信息</option>
<option value="warning">警告</option>
<option value="success">成功</option>
</select></div>
<div class="flex gap-6">
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_pinned" value="1">置顶</label>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked>立即显示</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 发布</button>
</div>
</form>
</div>
@endsection
