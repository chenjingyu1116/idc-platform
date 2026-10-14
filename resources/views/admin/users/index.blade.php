@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">👥 用户管理</h1>

<form method="GET" class="anime-card rounded-2xl p-4 mb-6 flex gap-3">
<input type="text" name="kw" value="{{ request('kw') }}" placeholder="姓名 / 邮箱" class="px-4 py-2 rounded-2xl border-2 flex-1" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
<button type="submit" class="anime-btn">🔍 搜索</button>
</form>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">ID</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">姓名</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">邮箱</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">余额</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">身份</th>
<th class="px-4 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr></thead>
<tbody>
@forelse($users as $u)
<tr class="border-b border-pink-50">
<td class="px-4 py-4 text-xs">#{{ $u->id }}</td>
<td class="px-4 py-4 text-sm">{{ $u->name }}</td>
<td class="px-4 py-4 text-sm text-gray-500">{{ $u->email }}</td>
<td class="px-4 py-4 font-mono" style="color:#FF9EC4">¥{{ $u->balance }}</td>
<td class="px-4 py-4">@if($u->is_admin)<span class="text-xs" style="color:#B39DDB">👑 管理员</span>@else<span class="text-xs text-gray-400">普通用户</span>@endif</td>
<td class="px-4 py-4 space-x-2">
<a href="{{ route('admin.users.show', $u) }}" class="text-pink-500 hover:underline text-sm">详情</a>
<a href="{{ route('admin.users.edit', $u) }}" class="text-pink-500 hover:underline text-sm">编辑</a>
</td>
</tr>
@empty
<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">暂无用户</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $users->links() }}</div>
</div>
@endsection
