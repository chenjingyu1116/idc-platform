@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🔌 添加上游</h1>
<form method="POST" action="{{ route('admin.providers.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">名称</label>
<input type="text" name="name" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required>
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">驱动类型</label>
<select name="driver" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="manual">manual（手动分配）</option>
<option value="novaix">novaix（Novaix 云平台）</option>
<option value="bt_panel">bt_panel（宝塔面板）</option>
<option value="http">http（通用 API）</option>
<option value="idcsmart">idcsmart</option>
</select>
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">API 地址</label>
<div class="text-xs text-gray-400 mb-2">💡 Novaix 示例：<code>http://1.2.3.4:8080</code>（部署 Novaix 后的地址）</div>
<input type="text" name="api_url" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" placeholder="http://1.2.3.4:8080">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">API Token</label>
<div class="text-xs text-gray-400 mb-2">💡 Novaix 后台 → 设置 → API Token，或使用管理员登录获取的 Token</div>
<input type="text" name="api_key" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">API Secret（Novaix 留空）</label>
<input type="text" name="api_secret" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
</div>

<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.providers.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
