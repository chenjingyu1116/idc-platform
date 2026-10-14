@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('admin.providers.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回上游列表</a>
<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">🌸 添加上游</h1>

<form method="POST" action="{{ route('admin.providers.store') }}" class="anime-card p-8 space-y-5">
@csrf
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🏷️ 名称</label>
<input type="text" name="name" placeholder="例如：Novaix 主控" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🔧 驱动类型</label>
<select name="driver" class="w-full">
<option value="manual">✋ manual（手动）</option>
<option value="http" selected>🌐 http（通用 API）</option>
<option value="novaix">☁️ novaix</option>
<option value="idcsmart">🎛️ idcsmart</option>
</select>
<p class="text-xs mt-2" style="color:#9CA3AF">选 http 后，系统会自动调用你配置的 API 完成开通</p>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🌐 API 地址</label>
<input type="text" name="api_url" placeholder="https://api.example.com" class="w-full">
<p class="text-xs mt-2" style="color:#9CA3AF">上游接口的根地址，不带路径</p>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🔑 API Key</label>
<input type="text" name="api_key" placeholder="上游提供的 API Key" class="w-full">
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🔒 API Secret</label>
<input type="text" name="api_secret" placeholder="上游提供的 API Secret" class="w-full">
</div>
<div class="anime-card p-4 text-xs" style="background:rgba(168,216,255,.15)">
📌 默认端点：<code>POST /api/v1/provision</code>、<code>POST /api/v1/suspend</code>、<code>POST /api/v1/unsuspend</code>、<code>POST /api/v1/terminate</code>、<code>GET /api/v1/products</code>、<code>GET /api/v1/ping</code>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.providers.index') }}" class="anime-btn-soft">取消</a>
<button type="submit" class="anime-btn">✨ 保存</button>
</div>
</form>
</div>
@endsection
