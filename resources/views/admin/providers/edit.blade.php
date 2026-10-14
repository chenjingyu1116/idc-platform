@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('admin.providers.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回上游列表</a>
<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">🌸 编辑上游</h1>

<form method="POST" action="{{ route('admin.providers.update',$provider) }}" class="anime-card p-8 space-y-5">
@csrf @method('PUT')
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🏷️ 名称</label>
<input type="text" name="name" value="{{ $provider->name }}" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🔧 驱动类型</label>
<select name="driver" class="w-full">
@foreach(['manual','http','novaix','idcsmart'] as $d)
<option value="{{ $d }}" @if($provider->driver===$d) selected @endif>{{ $d }}</option>
@endforeach
</select>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">🌐 API 地址</label>
<input type="text" name="api_url" value="{{ $provider->api_url }}" class="w-full">
</div>
<div class="flex items-center gap-2">
<input type="checkbox" name="is_active" value="1" id="is_active" @if($provider->is_active) checked @endif>
<label for="is_active" class="text-sm" style="color:#7A7A9A">启用该上游</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.providers.index') }}" class="anime-btn-soft">取消</a>
<button type="submit" class="anime-btn">✨ 保存</button>
</div>
</form>
</div>
@endsection
