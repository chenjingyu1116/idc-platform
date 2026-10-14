@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('client.tickets.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回工单列表</a>

<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">✨ 提交工单</h1>

<form method="POST" action="{{ route('client.tickets.store') }}" class="anime-card p-8 space-y-5">
@csrf
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">📝 标题</label>
<input type="text" name="title" class="w-full" placeholder="简要描述你的问题" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">💬 详细内容</label>
<textarea name="content" rows="8" class="w-full" placeholder="请详细描述你的问题，樱花喵会尽快回复你~" required></textarea>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('client.tickets.index') }}" class="anime-btn-soft">取消</a>
<button type="submit" class="anime-btn">🌸 提交工单</button>
</div>
</form>
</div>
@endsection
