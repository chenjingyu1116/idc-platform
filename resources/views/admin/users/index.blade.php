@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-3">
    <h1 class="text-2xl font-bold">👥 用户管理</h1>
    <a href="{{ route('admin.users.export') }}" class="anime-btn-soft text-sm">📥 导出 CSV</a>
</div>

<form method="GET" class="anime-card p-4 mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-xs text-gray-500 mb-1">关键词</label>
        <input type="text" name="kw" value="{{ request('kw') }}" placeholder="昵称 / 邮箱 / 手机" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">角色</label>
        <select name="role" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
            <option value="">全部</option>
            <option value="admin" @if(request('role')==='admin') selected @endif>管理员</option>
            <option value="user" @if(request('role')==='user') selected @endif>普通用户</option>
        </select>
    </div>
    <button type="submit" class="anime-btn">🔍 搜索</button>
    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">重置</a>
</form>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-4 py-3 text-left text-xs text-pink-400">ID</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">昵称</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">邮箱</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">余额</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">角色</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">注册</th>
<th class="px-4 py-3 text-left text-xs text-pink-400">操作</th>
</tr></thead>
<tbody>
@forelse($users as $u)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-4 py-3 text-xs">#{{ $u->id }}</td>
<td class="px-4 py-3">{{ $u->name }}</td>
<td class="px-4 py-3 text-sm text-gray-600">{{ $u->email }}</td>
<td class="px-4 py-3 font-mono" style="color:#FF9EC4">¥{{ $u->balance }}</td>
<td class="px-4 py-3">
@if($u->is_admin)
<span class="px-2 py-0.5 rounded-full text-xs" style="background:rgba(179,157,219,.25);color:#7C4DFF">管理员</span>
@else
<span class="px-2 py-0.5 rounded-full text-xs" style="background:rgba(168,216,255,.25);color:#1A5C9E">用户</span>
@endif
</td>
<td class="px-4 py-3 text-xs text-gray-500">{{ optional($u->created_at)->format('Y-m-d') }}</td>
<td class="px-4 py-3">
<a href="{{ route('admin.users.edit', $u) }}" class="text-pink-500 hover:underline text-sm">编辑</a>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">没有符合条件的用户</td></tr>
@endforelse
</tbody>
</table>
<div class="px-4 py-3">{{ $users->links() }}</div>
</div>
@endsection
