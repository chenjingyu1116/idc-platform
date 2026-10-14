@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">👥 用户管理</h1>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,158,196,.1)">
<tr>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">ID</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">昵称</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">邮箱</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">余额</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">角色</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($users as $u)
<tr style="border-top:1px solid rgba(255,158,196,.15)">
<td class="px-5 py-3 text-sm font-mono">{{ $u->id }}</td>
<td class="px-5 py-3 text-sm font-bold">{{ $u->name }}</td>
<td class="px-5 py-3 text-sm" style="color:#7A7A9A">{{ $u->email }}</td>
<td class="px-5 py-3 font-bold" style="color:#FF9EC4">¥{{ $u->balance }}</td>
<td class="px-5 py-3">
@if($u->is_admin)
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(179,157,219,.25);color:#7C3AED">👑 管理员</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.25);color:#2563EB">用户</span>
@endif
</td>
<td class="px-5 py-3"><a href="{{ route('admin.users.edit',$u) }}" class="anime-btn-soft text-xs">编辑</a></td>
</tr>
@empty
<tr><td colspan="6" class="px-5 py-10 text-center" style="color:#9CA3AF">🌙 暂无用户</td></tr>
@endforelse
</tbody>
</table>
<div class="px-5 py-4">{{ $users->links() }}</div>
</div>
@endsection
