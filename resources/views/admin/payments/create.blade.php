@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">💳 添加支付方式</h1>
<form method="POST" action="{{ route('admin.payments.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm text-gray-500 mb-1">名称</label>
<input type="text" name="name" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">驱动</label>
<select name="driver" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="epay">易支付</option>
<option value="alipay">支付宝</option>
<option value="wechat">微信</option>
<option value="balance">余额支付</option>
</select></div>
<div><label class="block text-sm text-gray-500 mb-1">API 地址</label>
<input type="text" name="api_url" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">商户 PID</label>
<input type="text" name="pid" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">商户密钥</label>
<input type="text" name="key_secret" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
