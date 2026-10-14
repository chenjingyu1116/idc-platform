@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🔑 API Token 管理</h1>
<div class="anime-card rounded-lg overflow-hidden">
<table class="min-w-full divide-y divide-pink-100">
<thead class="bg-pink-50">
<tr>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">用户</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">名称</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">Token</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">最后使用</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">创建时间</th>
</tr>
</thead>
<tbody class="divide-y divide-pink-100">
@forelse($tokens as $t)
<tr>
<td class="px-6 py-4">{{ optional($t->user)->name ?? '-' }}</td>
<td class="px-6 py-4">{{ $t->name }}</td>
<td class="px-6 py-4 font-mono text-xs text-gray-500">{{ substr($t->token,0,16) }}...</td>
<td class="px-6 py-4 text-sm text-gray-500">{{ $t->last_used_at?->format('Y-m-d H:i') ?? '-' }}</td>
<td class="px-6 py-4 text-sm text-gray-500">{{ $t->created_at->format('Y-m-d H:i') }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">暂无 Token</td></tr>
@endforelse
</tbody></table>
<div class="px-6 py-4">{{ $tokens->links() }}</div>
</div>
@endsection
