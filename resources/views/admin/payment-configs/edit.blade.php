@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">✏️ 编辑支付配置</h1>
@php $cred = json_decode($config->credentials, true) ?: []; @endphp
<form method="POST" action="{{ route('admin.payment-configs.update', $config->id) }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf @method('PUT')
<div><label class="block text-sm mb-1">名称</label><input type="text" name="name" value="{{ $config->name }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm mb-1">API 地址</label><input type="url" name="api_url" value="{{ $config->api_url }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm mb-1">商户 PID（留空不修改）</label><input type="text" name="pid" placeholder="{{ $cred['pid'] ?? '' }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm mb-1">商户 KEY（留空不修改）</label><input type="text" name="key" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @if($config->is_active) checked @endif> 启用</label></div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.payment-configs.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
