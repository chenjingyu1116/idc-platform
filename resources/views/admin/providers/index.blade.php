@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">🔌 上游管理</h1>
<a href="{{ route('admin.providers.create') }}" class="anime-btn text-sm" style="padding:10px 24px">+ 添加上游</a>
</div>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,158,196,.1)">
<tr>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">名称</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">驱动</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">API 地址</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">状态</th>
<th class="px-5 py-3 text-left text-xs font-bold" style="color:#FF9EC4">操作</th>
</tr>
</thead>
<tbody>
@forelse($providers as $p)
<tr style="border-top:1px solid rgba(255,158,196,.15)">
<td class="px-5 py-3 font-bold">{{ $p->name }}</td>
<td class="px-5 py-3">
@if($p->driver === 'http')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(179,157,219,.25);color:#7C3AED">🌐 http</span>
@elseif($p->driver === 'manual')
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(156,163,175,.25);color:#6B7280">✋ manual</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.25);color:#2563EB">{{ $p->driver }}</span>
@endif
</td>
<td class="px-5 py-3 text-xs font-mono" style="color:#7A7A9A">{{ $p->api_url ?? '-' }}</td>
<td class="px-5 py-3">
@if($p->is_active)
<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(134,239,172,.25);color:#16A34A">启用</span>
@else
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(156,163,175,.25);color:#6B7280">停用</span>
@endif
</td>
<td class="px-5 py-3 flex gap-2">
@if($p->driver === 'http' && $p->api_url)
<button type="button" onclick="testProvider({{ $p->id }})" class="anime-btn-soft text-xs">🔍 测试连接</button>
@endif
<a href="{{ route('admin.providers.edit',$p) }}" class="anime-btn-soft text-xs">编辑</a>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-10 text-center" style="color:#9CA3AF">🌙 暂无上游，点击右上角添加</td></tr>
@endforelse
</tbody>
</table>
<div class="px-5 py-4">{{ $providers->links() }}</div>
</div>

{{-- 测试结果弹窗 --}}
<div id="testResult" class="fixed inset-0 hidden items-center justify-center z-50" style="background:rgba(0,0,0,.4)">
<div class="anime-card p-6 max-w-md mx-4" style="background:#fff">
<div class="flex justify-between items-center mb-4">
<h3 class="font-bold" style="color:#FF9EC4">🔍 测试结果</h3>
<button onclick="document.getElementById('testResult').classList.add('hidden')" class="text-gray-400 text-xl">&times;</button>
</div>
<pre id="testResultContent" class="text-xs font-mono whitespace-pre-wrap max-h-64 overflow-y-auto" style="color:#4A4A6A"></pre>
</div>
</div>

<script>
function testProvider(id) {
    const box = document.getElementById('testResult');
    const content = document.getElementById('testResultContent');
    box.classList.remove('hidden');
    box.classList.add('flex');
    content.textContent = '⏳ 正在测试...';
    fetch('/admin/providers/' + id + '/test', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        content.textContent = '状态码: ' + data.status + '\n\n' + data.body;
    })
    .catch(e => { content.textContent = '❌ 请求失败: ' + e; });
}
</script>
@endsection
