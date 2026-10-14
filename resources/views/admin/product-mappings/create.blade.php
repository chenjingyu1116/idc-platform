@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">🔗 新建产品映射</h1>
<form method="POST" action="{{ route('admin.product-mappings.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm text-gray-500 mb-1">本地产品</label>
<select name="product_id" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
@foreach(($products ?? []) as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm text-gray-500 mb-1">上游供应商</label>
<select name="provider_id" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
@foreach(($providers ?? []) as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm text-gray-500 mb-1">上游产品 ID</label>
<input type="text" name="upstream_product_id" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.product-mappings.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
