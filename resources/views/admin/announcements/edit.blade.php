@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
<h1 class="text-3xl font-bold mb-6" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🌸 编辑公告</h1>

<form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="anime-card p-8 space-y-5">@csrf @method('PUT')
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🏷️ 标题</label>
<input type="text" name="title" value="{{ $announcement->title }}" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🎨 类型</label>
<select name="type" style="width:100%;padding:12px 18px;border:2px solid #FFD1E8;border-radius:9999px;background:rgba(255,245,250,.7);outline:none;font-family:inherit;color:#4A4A6A">
@foreach(['info'=>'💙 通知','success'=>'💚 成功','warning'=>'💛 警告','danger'=>'❤️ 重要'] as $k => $label)
<option value="{{ $k }}" @if($announcement->type === $k) selected @endif>{{ $label }}</option>
@endforeach
</select>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">📝 内容</label>
<textarea name="content" rows="10" required style="width:100%;padding:14px 18px;border:2px solid #FFD1E8;border-radius:18px;background:rgba(255,245,250,.7);outline:none;font-family:inherit;color:#4A4A6A;resize:vertical">{{ $announcement->content }}</textarea>
</div>
<div class="space-y-2">
<label class="flex items-center gap-2 text-sm" style="color:#7A7A9A">
<input type="checkbox" name="is_pinned" value="1" @if($announcement->is_pinned) checked @endif>
📌 置顶此公告
</label>
<label class="flex items-center gap-2 text-sm" style="color:#7A7A9A">
<input type="checkbox" name="is_active" value="1" @if($announcement->is_active) checked @endif>
✅ 启用此公告
</label>
</div>
<div class="flex justify-end gap-3 pt-2">
<a href="{{ route('admin.announcements.index') }}" class="anime-btn-soft text-sm">取消</a>
<button type="submit" class="anime-btn text-sm" style="padding:10px 32px">💾 保存</button>
</div>
</form>
</div>
@endsection
