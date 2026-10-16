@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🎫 添加优惠券</h1>
<form method="POST" action="{{ route('admin.coupons.store') }}" class="anime-card rounded-2xl p-6 space-y-4">
@csrf

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">优惠码</label>
<div class="text-xs text-gray-400 mb-1">💡 用户下单时输入此码享受优惠（建议大写字母+数字）</div>
<input type="text" name="code" value="{{ old('code') }}" required
       class="w-full px-4 py-2 rounded-2xl border-2 font-mono"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="SAKURA2026">
@error('code')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">名称</label>
<input type="text" name="name" value="{{ old('name') }}" required
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="新年特惠券">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">类型</label>
<select name="type" class="w-full px-4 py-2 rounded-2xl border-2"
        style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="fixed">固定金额（如 ¥20）</option>
<option value="percent">百分比折扣（如 10%）</option>
</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">面值</label>
<div class="text-xs text-gray-400 mb-1">💡 固定金额填元数（如 20），百分比填数字（如 10 表示 10%）</div>
<input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0" required
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">最低使用金额（可选）</label>
<input type="number" name="min_amount" value="{{ old('min_amount', 0) }}" step="0.01" min="0"
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="0 表示无限制">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">总数量（可选）</label>
<input type="number" name="total" value="{{ old('total') }}" min="1"
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="留空表示不限量">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">过期时间（可选）</label>
<input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
       class="w-full px-4 py-2 rounded-2xl border-2"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
</div>

<div class="flex items-center gap-2">
<input type="checkbox" name="is_active" value="1" checked id="active">
<label for="active" class="text-sm">立即启用</label>
</div>

<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>

</form>
</div>
@endsection
