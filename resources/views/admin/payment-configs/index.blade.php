@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">💳 支付配置</h1>

<div class="anime-card rounded-2xl overflow-hidden">
<table class="min-w-full">
<thead><tr class="border-b-2 border-pink-100">
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">名称</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">驱动</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">API 地址</th>
<th class="px-6 py-3 text-left text-xs text-pink-400 uppercase">状态</th>
</tr></thead>
<tbody>
@forelse(($configs ?? []) as $c)
<tr class="border-b border-pink-50">
<td class="px-6 py-3">{{ $c->name }}</td>
<td class="px-6 py-3 font-mono text-sm">{{ $c->driver }}</td>
<td class="px-6 py-3 text-xs text-gray-500">{{ $c->api_url ?? '-' }}</td>
<td class="px-6 py-3">
@if($c->is_active ?? true)
<span class="text-green-500">启用</span>
@else
<span class="text-gray-400">停用</span>
@endif
</td>
</tr>
@empty
<tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">暂无支付配置，请通过 Seeder 或数据库添加</td></tr>
@endforelse
</tbody>
</table>
</div>

<div class="anime-card p-6 mt-6">
<h2 class="text-lg font-bold mb-3" style="color:#FF9EC4">📖 配置说明</h2>
<ul class="space-y-2 text-sm text-gray-600">
<li>🌸 支持驱动：<code>epay</code>（易支付）、<code>alipay</code>（支付宝）、<code>wechat</code>（微信）、<code>balance</code>（余额支付）</li>
<li>💎 在 <code>payment_configs</code> 表中配置 API 地址、商户 ID、密钥</li>
<li>⚠️ 上线前务必填写真实凭证，否则无法收款</li>
</ul>
</div>
@endsection
