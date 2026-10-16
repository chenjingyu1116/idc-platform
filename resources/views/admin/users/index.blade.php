@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">👥 用户管理</h1>
</div>

{{-- 搜索栏 --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="anime-card rounded-2xl p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="kw" value="{{ request('kw') }}"
           placeholder="昵称 / 邮箱 / 手机"
           class="flex-1 min-w-[200px] px-4 py-2 rounded-2xl border-2"
           style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
    <select name="role" class="px-4 py-2 rounded-2xl border-2"
            style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
        <option value="">全部角色</option>
        <option value="admin" @if(request('role') === 'admin') selected @endif>👑 管理员</option>
        <option value="user" @if(request('role') === 'user') selected @endif>👤 普通用户</option>
    </select>
    <button type="submit" class="anime-btn">🔍 搜索</button>
    @if(request('kw') || request('role'))
    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8">清空</a>
    @endif
</form>

{{-- 结果统计 --}}
<div class="text-sm text-gray-500 mb-3">
    共 {{ $users->total() }} 位用户
    @if(request('kw')) · 搜索「{{ request('kw') }}」@endif
</div>

{{-- 用户列表 --}}
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead>
<tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">ID</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">昵称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">邮箱</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">余额</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">角色</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">注册时间</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">操作</th>
</tr>
</thead>
<tbody>
@forelse($users as $u)
<tr class="border-b border-pink-50 hover:bg-pink-50/30">
<td class="px-6 py-3 font-mono text-xs text-gray-400">#{{ $u->id }}</td>
<td class="px-6 py-3 font-semibold">{{ $u->name }}</td>
<td class="px-6 py-3 text-sm">{{ $u->email }}</td>
<td class="px-6 py-3 font-mono" style="color:#FF9EC4">¥{{ number_format($u->balance, 2) }}</td>
<td class="px-6 py-3">
    @if($u->is_admin)
        <span class="px-3 py-1 rounded-full text-xs" style="background:rgba(179,157,219,.2);color:#B39DDB">👑 管理员</span>
    @else
        <span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.2);color:#4A6FA5">👤 用户</span>
    @endif
</td>
<td class="px-6 py-3 text-xs text-gray-500">{{ $u->created_at->format('Y-m-d H:i') }}</td>
<td class="px-6 py-3 space-x-2 text-sm">
    <a href="{{ route('admin.users.edit', $u) }}" class="text-pink-500 hover:underline">编辑</a>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">
    <div class="text-4xl mb-3">🔍</div>
    <div>没有找到匹配的用户</div>
</td></tr>
@endforelse
</tbody>
</table>

@if($users->hasPages())
<div class="px-6 py-4">{{ $users->links() }}</div>
@endif
</div>
@endsection
