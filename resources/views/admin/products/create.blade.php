@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<h1 class="text-2xl font-bold mb-6">📦 添加产品</h1>
<form method="POST" action="{{ route('admin.products.store') }}" class="anime-card rounded-2xl p-6 space-y-4">@csrf
<div><label class="block text-sm text-gray-500 mb-1">产品名称</label>
<input type="text" name="name" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">描述</label>
<textarea name="description" rows="2" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></textarea></div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-sm text-gray-500 mb-1">价格</label>
<input type="number" name="price" step="0.01" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none" required></div>
<div><label class="block text-sm text-gray-500 mb-1">计费周期</label>
<select name="billing_cycle" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<option value="monthly">月付</option>
<option value="quarterly">季付</option>
<option value="yearly">年付</option>
</select></div>
</div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-sm text-gray-500 mb-1">CPU</label>
<input type="text" name="cpu" value="1核" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">内存</label>
<input type="text" name="memory" value="1G" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
</div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-sm text-gray-500 mb-1">硬盘</label>
<input type="text" name="disk" value="20G" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div><label class="block text-sm text-gray-500 mb-1">带宽</label>
<input type="text" name="bandwidth" value="20M" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
</div>
<div><label class="block text-sm text-gray-500 mb-1">库存（-1 为不限）</label>
<input type="number" name="stock" value="-1" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none"></div>
<div class="flex items-center gap-2">
<input type="checkbox" name="is_active" value="1" checked id="ac">
<label for="ac" class="text-sm text-gray-500">立即上架</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
<button type="submit" class="anime-btn">💾 保存</button>
</div>
</form>
</div>
@endsection
