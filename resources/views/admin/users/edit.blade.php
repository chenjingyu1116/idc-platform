@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
<a href="{{ route('admin.users.index') }}" class="text-sm hover:text-pink-500" style="color:#9CA3AF">← 返回用户列表</a>
<h1 class="text-3xl font-bold mt-4 mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">🌸 编辑用户</h1>

<form method="POST" action="{{ route('admin.users.update',$user) }}" class="anime-card p-8 space-y-5">
@csrf @method('PUT')
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">昵称</label>
<input type="text" name="name" value="{{ $user->name }}" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">邮箱</label>
<input type="email" name="email" value="{{ $user->email }}" class="w-full" required>
</div>
<div>
<label class="block text-sm mb-2" style="color:#7A7A9A">💴 余额</label>
<input type="number" name="balance" value="{{ $user->balance }}" step="0.01" class="w-full" required>
</div>
<div class="flex items-center gap-2">
<input type="checkbox" name="is_admin" value="1" id="is_admin" @if($user->is_admin) checked @endif>
<label for="is_admin" class="text-sm" style="color:#7A7A9A">👑 设为管理员</label>
</div>
<div class="flex justify-end gap-3 pt-4">
<a href="{{ route('admin.users.index') }}" class="anime-btn-soft">取消</a>
<button type="submit" class="anime-btn">✨ 保存</button>
</div>
</form>
</div>
@endsection
