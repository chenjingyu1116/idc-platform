@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🌸 添加代理</h1>
<form method="POST" action="{{ route('admin.agents.store') }}" class="anime-card rounded-2xl p-6 space-y-4">
@csrf

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">选择用户</label>
<div class="text-xs text-gray-400 mb-1">💡 从已注册用户中选择一位设为代理</div>
<select name="user_id" required class="w-full px-4 py-2 rounded-2xl border-2"
        style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="">-- 请选择用户 --</option>
@foreach($users ?? [] as $u)
    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
@endforeach
</select>
@error('user_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">推荐码</label>
<div class="text-xs text-gray-400 mb-1">💡 留空自动生成（如 REF000001）</div>
<input type="text" name="code" value="{{ old('code') }}"
       class="w-full px-4 py-2 rounded-2xl border-2 font-mono"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="REF000001">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">等级</label>
<select name="level" class="w-full px-4 py-2 rounded-2xl border-2"
        style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="普通">普通代理</option>
<option value="银牌">银牌代理</option>
<option value="金牌">金牌代理</option>
<option value="钻石">钻石代理</option>
</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">佣金比例</label>
<div class="text-xs text-gray-400 mb-1">💡 0.05 表示 5%</div>
<input type="number" name="commission_rate" value="{{ old('commission_rate', 0.05) }}"
       step="0.01" min="0" max="1" required
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
</div>

<div class="flex items-center gap-2">
<input type="checkbox" name="is_active" value="1" checked id="active">
<label for="active" class="text-sm">启用该代理</label>
</div>

<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.agents.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>

</form>
</div>
@endsection
