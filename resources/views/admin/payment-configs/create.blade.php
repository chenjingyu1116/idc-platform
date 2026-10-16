@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">💳 添加支付配置</h1>
<form method="POST" action="{{ route('admin.payment-configs.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm mb-1">名称</label><input type="text" name="name" value="易支付" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm mb-1">驱动</label>
<select name="driver" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="epay">易支付（Epay）</option>
</select></div>
<div><label class="block text-sm mb-1">API 地址</label>
<div class="text-xs text-gray-400 mb-2">💡 易支付平台地址，如 <code>https://pay.example.com</code></div>
<input type="url" name="api_url" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm mb-1">商户 PID</label><input type="text" name="pid" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm mb-1">商户密钥 KEY</label><input type="text" name="key" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.payment-configs.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
