@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🔄 续费管理</h1>
<div class="anime-card rounded-lg overflow-hidden">
<table class="min-w-full divide-y divide-pink-100">
<thead class="bg-pink-50">
<tr>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">产品</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">到期时间</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">价格</th>
<th class="px-6 py-3 text-left text-xs font-medium" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody class="divide-y divide-pink-100">
@forelse($services as $s)
<tr>
<td class="px-6 py-4">{{ optional($s->product)->name ?? '-' }}</td>
<td class="px-6 py-4 text-sm text-gray-500">{{ $s->expires_at?->format('Y-m-d') ?? '未设置' }}</td>
<td class="px-6 py-4">¥{{ optional($s->product)->price ?? '-' }}</td>
<td class="px-6 py-4">
<form method="POST" action="{{ url('/client/services/'.$s->id.'/renew') }}" class="inline">@csrf
<button class="anime-btn text-xs" style="padding:6px 16px">立即续费</button>
</form>
</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无可续费服务</td></tr>
@endforelse
</tbody></table>
</div>
@endsection
