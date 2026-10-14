@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">📢 公告管理</h1>
<a href="{{ route('admin.announcements.create') }}" class="anime-btn text-sm" style="padding:10px 24px">✨ 发布公告</a>
</div>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,229,244,.5)">
<tr>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">标题</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">类型</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">置顶</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">状态</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">时间</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($announcements as $a)
<tr class="border-t border-pink-100">
<td class="px-6 py-4 font-semibold">{{ $a->title }}</td>
<td class="px-6 py-4">
@php
$__typeColors = [
  'info' => ['rgba(168,216,255,.3)','#4A6FA5'],
  'warning' => ['rgba(255,229,180,.5)','#C68A00'],
  'success' => ['rgba(168,255,200,.4)','#4A9E6B'],
  'danger' => ['rgba(255,200,200,.4)','#C66'],
];
$__tc = $__typeColors[$a->type] ?? $__typeColors['info'];
@endphp
<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:{{ $__tc[0] }};color:{{ $__tc[1] }}">{{ $a->type }}</span>
</td>
<td class="px-6 py-4">{!! $a->is_pinned ? '📌 是' : '<span style="color:#9CA3AF">否</span>' !!}</td>
<td class="px-6 py-4">
@if($a->is_active)
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,255,200,.4);color:#4A9E6B">✅ 生效</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(200,200,220,.3);color:#888">隐藏</span>
@endif
</td>
<td class="px-6 py-4 text-xs" style="color:#9CA3AF">{{ $a->published_at ? $a->published_at->format('Y-m-d H:i') : '-' }}</td>
<td class="px-6 py-4 space-x-2">
<a href="{{ route('admin.announcements.edit', $a) }}" class="text-xs font-semibold" style="color:#B39DDB">编辑</a>
<form method="POST" action="{{ route('admin.announcements.destroy', $a) }}" class="inline" onsubmit="return confirm('确认删除？')">@csrf @method('DELETE')<button type="submit" class="text-xs font-semibold" style="color:#C66">删除</button></form>
</td>
</tr>
@empty
<tr><td colspan="6" class="px-6 py-12 text-center">
<div class="text-5xl mb-3">📢</div>
<div style="color:#9CA3AF">暂无公告，点击右上角发布第一条吧～</div>
</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $announcements->links() }}</div>
</div>
@endsection
