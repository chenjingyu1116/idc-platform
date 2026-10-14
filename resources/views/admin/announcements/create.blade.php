@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
<h1 class="text-3xl font-bold mb-6" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">✨ 发布公告</h1>

<form method="POST" action="{{ route('admin.announcements.store') }}" class="anime-card p-8 space-y-5">@csrf
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🏷️ 标题</label>
<input type="text" name="title" placeholder="请输入公告标题" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🎨 类型</label>
<select name="type" style="width:100%;padding:12px 18px;border:2px solid #FFD1E8;border-radius:9999px;background:rgba(255,245,250,.7);outline:none;font-family:inherit;color:#4A4A6A">
<option value="info">💙 通知（info）</option>
<option value="success">💚 成功（success）</option>
<option value="warning">💛 警告（warning）</option>
<option value="danger">❤️ 重要（danger）</option>
</select>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">📝 内容</label>
<textarea name="content" rows="10" placeholder="支持纯文本，建议简洁明了" required style="width:100%;padding:14px 18px;border:2px solid #FFD1E8;border-radius:18px;background:rgba(255,245,250,.7);outline:none;font-family:inherit;color:#4A4A6A;resize:vertical"></textarea>
</div>
<div>
<label class="flex items-center gap-2 text-sm" style="color:#7A7A9A">
<input type="checkbox" name="is_pinned" value="1">
📌 置顶此公告
</label>
</div>
<div class="flex justify-end gap-3 pt-2">
<a href="{{ route('admin.announcements.index') }}" class="anime-btn-soft text-sm">取消</a>
<button type="submit" class="anime-btn text-sm" style="padding:10px 32px">🌸 发布</button>
</div>
</form>
</div>
@endsection
