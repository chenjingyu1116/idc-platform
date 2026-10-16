@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🎁 返佣记录</h1>
<a href="{{ route('client.agent.index') }}" class="anime-btn-soft text-sm">← 返回代理中心</a>
</div>

<div class="anime-card overflow-hidden">
<table class="min-w-full table-responsive">
<thead style="background:rgba(255,229,244,.5)">
<tr>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">时间</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">来源用户</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">订单金额</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">佣金比例</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">返佣金额</th>
<th class="px-6 py-4 text-left text-sm font-bold" style="color:#FF9EC4">层级</th>
</tr>
</thead>
<tbody>
@forelse($commissions as $c)
<tr class="border-t border-pink-100">
<td class="px-6 py-4 text-xs" style="color:#9CA3AF">{{ $c->created_at->format('Y-m-d H:i') }}</td>
<td class="px-6 py-4">{{ optional($c->fromUser)->name ?? '-' }}</td>
<td class="px-6 py-4 font-mono">¥{{ $c->order_amount }}</td>
<td class="px-6 py-4 font-mono text-xs" style="color:#B39DDB">{{ $c->rate * 100 }}%</td>
<td class="px-6 py-4 font-bold" style="color:#4A9E6B">+¥{{ $c->amount }}</td>
<td class="px-6 py-4">
<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:rgba(168,216,255,.3);color:#4A6FA5">{{ $c->level }} 级</span>
</td>
</tr>
@empty
<tr><td colspan="6" class="px-6 py-12 text-center">
<div class="text-5xl mb-3">🎁</div>
<div style="color:#9CA3AF">暂无返佣记录</div>
</td></tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $commissions->links() }}</div>
</div>
@endsection
