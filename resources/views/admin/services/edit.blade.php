@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('admin.services.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回资源列表</a>
<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">🌸 分配资源</h1>

<div class="anime-card p-5 mb-6" style="background:rgba(168,216,255,.1)">
<div class="text-sm">
<strong>产品：</strong>{{ optional($service->product)->name ?? '-' }} ·
<strong>客户：</strong>{{ optional($service->user)->name ?? '-' }} ·
<strong>订单：</strong>{{ optional($service->order)->order_no ?? '-' }}
</div>
</div>

<form action="{{ route('admin.services.update',$service) }}" method="POST" class="anime-card p-8 space-y-5">
@csrf @method('PUT')
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🌐 IP 地址</label>
<input type="text" name="ip_address" value="{{ $service->ip_address }}" placeholder="例如：192.168.1.100" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">👤 用户名</label>
<input type="text" name="username" value="{{ $service->username }}" placeholder="例如：root" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🔑 密码</label>
<input type="text" name="password" placeholder="请输入分配密码" class="w-full" required>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.services.index') }}" class="anime-btn-soft">取消</a>
<button type="submit" class="anime-btn">💗 保存并激活</button>
</div>
</form>
</div>
@endsection
