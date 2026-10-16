@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">👑 管理员账号</h1>
<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full table-responsive">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400">ID</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">昵称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">邮箱</th>
<th class="px-6 py-3 text-left text-xs text-pink-400">余额</th>
</tr></thead>
<tbody>
@forelse($admins as $a)
<tr class="border-b border-pink-50">
<td class="px-6 py-3 text-xs">#{{ $a->id }}</td>
<td class="px-6 py-3">{{ $a->name }}</td>
<td class="px-6 py-3">{{ $a->email }}</td>
<td class="px-6 py-3 font-mono">¥{{ $a->balance }}</td>
</tr>
@empty<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无管理员</td></tr>@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $admins->links() }}</div>
</div>
@endsection
