@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🔗 添加产品映射</h1>

<form method="POST" action="{{ route('admin.product-mappings.store') }}" class="anime-card rounded-2xl p-6 space-y-4">
@csrf

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">本地产品</label>
<div class="text-xs text-gray-400 mb-2">💡 选择你系统里的产品，映射后客户下单会自动调用上游开通</div>
<select name="product_id" required class="w-full px-4 py-2 rounded-2xl border-2"
        style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="">-- 选择产品 --</option>
@foreach($products ?? [] as $p)
<option value="{{ $p->id }}">{{ $p->name }} （¥{{ $p->price }}）</option>
@endforeach
</select>
@error('product_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">上游供应商</label>
<div class="text-xs text-gray-400 mb-2">💡 选择接入的上游（手动 / 宝塔 / Novaix / HTTP）</div>
<select name="provider_id" required class="w-full px-4 py-2 rounded-2xl border-2"
        style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="">-- 选择上游 --</option>
@foreach($providers ?? [] as $p)
<option value="{{ $p->id }}">{{ $p->name }} ({{ $p->driver }})</option>
@endforeach
</select>
@error('provider_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
</div>

<div>
<label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">上游产品 ID</label>
<div class="text-xs text-gray-400 mb-2">💡 上游对应的产品编号（宝塔/魔方/Novaix 里查）。手动模式可填任意占位符如 manual</div>
<input type="text" name="upstream_product_id" value="{{ old('upstream_product_id') }}" required
       class="w-full px-4 py-2 rounded-2xl border-2 font-mono"
       style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"
       placeholder="例如：manual 或 bt_auto 或 82">
@error('upstream_product_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
</div>

<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.product-mappings.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存映射</button>
</div>

</form>
</div>
@endsection
