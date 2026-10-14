@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-2" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🌸 我的代理中心</h1>
<p class="text-sm mb-8" style="color:#9CA3AF">邀请好友，赚取返佣 🎁</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
<div class="anime-card p-6 text-center">
<div class="text-4xl mb-2">👑</div>
<div class="text-xs" style="color:#7A7A9A">当前等级</div>
<div class="text-lg font-bold mt-1" style="color:#FF9EC4">{{ $user->agentLevelName() }}</div>
</div>
<div class="anime-card p-6 text-center">
<div class="text-4xl mb-2">👥</div>
<div class="text-xs" style="color:#7A7A9A">我的下级</div>
<div class="text-3xl font-bold" style="color:#B39DDB">{{ $referralCount }}</div>
</div>
<div class="anime-card p-6 text-center">
<div class="text-4xl mb-2">🎁</div>
<div class="text-xs" style="color:#7A7A9A">累计返佣</div>
<div class="text-3xl font-bold" style="color:#FF9EC4">¥{{ $totalCommission }}</div>
</div>
<div class="anime-card p-6 text-center">
<div class="text-4xl mb-2">💰</div>
<div class="text-xs" style="color:#7A7A9A">可提现</div>
<div class="text-3xl font-bold" style="color:#4A9E6B">¥{{ $withdrawable }}</div>
</div>
</div>

<div class="anime-card p-6 mb-6" x-data="{copied:false}">
<div class="text-sm font-bold mb-3" style="color:#B39DDB">🔗 我的专属推荐链接</div>
<div class="flex gap-2 items-center flex-wrap">
<input type="text" readonly value="{{ url('/register?ref=' . $user->referral_code) }}" id="refUrl" style="flex:1;min-width:260px;padding:10px 16px;border:2px solid #FFD1E8;border-radius:9999px;background:rgba(255,245,250,.7);outline:none;font-size:12px;color:#4A4A6A">
<button type="button" class="anime-btn text-sm" style="padding:8px 20px" @click="navigator.clipboard.writeText(document.getElementById('refUrl').value); copied=true; setTimeout(()=>copied=false,1500)">
<span x-show="!copied">📋 复制</span>
<span x-show="copied" x-cloak>✅ 已复制</span>
</button>
</div>
<div class="text-xs mt-3" style="color:#9CA3AF">我的推荐码：<span class="font-mono font-bold" style="color:#FF9EC4">{{ $user->referral_code }}</span> · 佣金比例：<span class="font-bold" style="color:#B39DDB">{{ $user->commission_rate * 100 }}%</span></div>
</div>

<div class="grid md:grid-cols-2 gap-6">
<div class="anime-card p-6">
<div class="flex justify-between items-center mb-4">
<h2 class="font-bold" style="color:#B39DDB">🎁 最近返佣</h2>
<a href="{{ route('client.agent.commissions') }}" class="text-xs font-semibold" style="color:#FF9EC4">全部 →</a>
</div>
<div class="space-y-3">
@forelse($recentCommissions as $c)
<div class="flex justify-between items-center p-3 rounded-2xl" style="background:rgba(255,245,250,.7)">
<div>
<div class="text-sm font-semibold">{{ optional($c->fromUser)->name ?? '-' }} 下单</div>
<div class="text-xs" style="color:#9CA3AF">{{ $c->created_at->format('Y-m-d H:i') }} · 订单 ¥{{ $c->order_amount }}</div>
</div>
<div class="text-right">
<div class="font-bold" style="color:#4A9E6B">+¥{{ $c->amount }}</div>
<div class="text-xs" style="color:#9CA3AF">{{ $c->level }} 级</div>
</div>
</div>
@empty
<div class="text-center py-6" style="color:#9CA3AF">暂无返佣记录</div>
@endforelse
</div>
</div>

<div class="anime-card p-6">
<div class="flex justify-between items-center mb-4">
<h2 class="font-bold" style="color:#B39DDB">👥 最近下级</h2>
<a href="{{ route('client.agent.referrals') }}" class="text-xs font-semibold" style="color:#FF9EC4">全部 →</a>
</div>
<div class="space-y-3">
@forelse($recentReferrals as $r)
<div class="flex justify-between items-center p-3 rounded-2xl" style="background:rgba(255,245,250,.7)">
<div>
<div class="text-sm font-semibold">{{ $r->name }}</div>
<div class="text-xs" style="color:#9CA3AF">{{ $r->email }}</div>
</div>
<div class="text-xs" style="color:#9CA3AF">📅 {{ $r->created_at->format('Y-m-d') }}</div>
</div>
@empty
<div class="text-center py-6" style="color:#9CA3AF">还没有下级，快去邀请好友吧～</div>
@endforelse
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
