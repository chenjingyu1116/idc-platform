@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">✏️ 编辑支付方式</h1>
<form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf @method('PUT')
<div><label class="block text-sm text-gray-500 mb-1">名称</label>
<input type="text" name="name" value="{{ $payment->name }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">驱动</label>
<input type="text" value="{{ $payment->driver }}" class="w-full px-4 py-2 rounded-2xl border-2 bg-gray-100" readonly></div>
<div><label class="block text-sm text-gray-500 mb-1">API 地址</label>
<input type="text" name="api_url" value="{{ $payment->api_url }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">商户 PID</label>
<input type="text" name="pid" value="{{ $payment->pid }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">商户密钥（留空不修改）</label>
<input type="text" name="key_secret" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div class="flex items-center gap-2">
<input type="checkbox" name="is_active" value="1" @if($payment->is_active ?? true) checked @endif id="active">
<label for="active" class="text-sm text-gray-500">启用该支付方式</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
