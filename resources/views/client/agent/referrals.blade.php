@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">👥 我的下级</h1>
<a href="{{ route('client.agent.index') }}" class="anime-btn-soft text-sm">← 返回代理中心</a>
</div>

<div class="anime-card overflow-hidden">
<table class="min-w-full">
<thead style="background:rgba(255,229,244,.5)">
<tr>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">用户名</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">邮箱</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">等级</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">注册时间</th>
</tr>
</thead>
<tbody>
@forelse($referrals as $r)
<tr class="border-t border-pink-100">
<td class="px-6 py-4 font-semibold">{{ $r->name }}</td>
<td class="px-6 py-4 text-sm" style="color:#7A7A9A">{{ $r->email }}</td>
<td class="px-6 py-4 text-xs">{{ $r->agentLevelName() }}</td>
<td class="px-6 py-4 text-xs" style="color:#9CA3AF">{{ $r->created_at->format('Y-m-d H:i') }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-12 text-center">
<div class="text-5xl mb-3">👥</div>
<div style="color:#9CA3AF">还没有下级，去邀请好友吧～</div>
</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $referrals->links() }}</div>
</div>
@endsection
