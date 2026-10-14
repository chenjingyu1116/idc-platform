<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', '樱花云') }} · 二次元 IDC</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root{--sakura:#FF9EC4;--sky:#A8D8FF;--cream:#FFE5B4;--purple:#B39DDB;--text:#4A4A6A}
body{font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;background:linear-gradient(135deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%);color:var(--text);min-height:100vh;position:relative}
.anime-card{background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border:2px solid rgba(255,158,196,.3);border-radius:20px;box-shadow:0 8px 32px rgba(255,158,196,.15);transition:all .3s ease}
.anime-card:hover{border-color:rgba(255,158,196,.6);box-shadow:0 12px 40px rgba(255,158,196,.25)}
.anime-btn{background:linear-gradient(135deg,#FF9EC4 0%,#FFB6D5 50%,#A8D8FF 100%);color:#fff;border-radius:9999px;padding:8px 24px;font-weight:600;box-shadow:0 4px 15px rgba(255,158,196,.4);border:none;cursor:pointer;transition:all .3s}
.anime-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(255,158,196,.6)}
.anime-btn-soft{background:rgba(255,255,255,.9);color:var(--sakura);border:2px solid var(--sakura);border-radius:9999px;padding:6px 20px;font-weight:600;transition:all .3s}
.anime-btn-soft:hover{background:var(--sakura);color:#fff}
.petal{position:fixed;top:-10px;color:#FFB6D5;font-size:16px;pointer-events:none;animation:fall linear infinite;z-index:1;opacity:.7}
@keyframes fall{0%{transform:translateY(-10px) rotate(0);opacity:0}10%{opacity:.7}100%{transform:translateY(105vh) rotate(360deg);opacity:0}}
.nav-anime{background:rgba(255,255,255,.9);backdrop-filter:blur(16px);border-bottom:2px solid rgba(255,158,196,.25)}
</style>
</head>
<body>
<div class="petal" style="left:5%;animation-duration:12s">🌸</div>
<div class="petal" style="left:20%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:11s;animation-delay:4s">🌸</div>
<div class="petal" style="left:60%;animation-duration:14s;animation-delay:1s">🌸</div>
<div class="petal" style="left:80%;animation-duration:13s;animation-delay:5s">🌸</div>

<nav class="nav-anime sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center flex-wrap gap-2">
<div class="flex items-center gap-6 flex-wrap">
<a href="{{ route('home') }}" class="flex items-center gap-2">
<span class="text-2xl">🌸</span>
<span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
</a>
<div class="hidden md:flex items-center gap-4 text-xs font-semibold flex-wrap">
<a href="{{ route('announcements.index') }}" class="hover:text-pink-500">📢 公告</a>
<a href="{{ route('orders.index') }}" class="hover:text-pink-500">🎀 产品</a>
<a href="{{ route('client.services.index') }}" class="hover:text-pink-500">💗 服务</a>
<a href="{{ route('client.recharge.index') }}" class="hover:text-pink-500">💎 充值</a>
<a href="{{ route('client.tickets.index') }}" class="hover:text-pink-500">💌 工单</a>
<a href="{{ route('client.coupons.index') }}" class="hover:text-pink-500">🎫 优惠券</a>
<a href="{{ route('client.agent.index') }}" class="hover:text-pink-500">🌸 代理</a>
@if(auth()->user()?->is_admin)
<span class="text-gray-300">|</span>
<a href="{{ route('admin.dashboard') }}" class="text-purple-500 hover:text-purple-400">👑 看板</a>
<a href="{{ route('admin.services.index') }}" class="text-purple-500 hover:text-purple-400">⚙️ 资源</a>
<a href="{{ route('admin.recharges.index') }}" class="text-purple-500 hover:text-purple-400">💰 充值</a>
<a href="{{ route('admin.providers.index') }}" class="text-purple-500 hover:text-purple-400">🔌 上游</a>
<a href="{{ route('admin.reports.index') }}" class="text-purple-500 hover:text-purple-400">📊 报表</a>
<a href="{{ route('admin.monitor.index') }}" class="text-purple-500 hover:text-purple-400">📡 监控</a>
<a href="{{ route('admin.settings.index') }}" class="text-purple-500 hover:text-purple-400">⚙️ 设置</a>
<a href="{{ route('admin.announcements.index') }}" class="text-purple-500 hover:text-purple-400">📢 公告</a>
<a href="{{ route('admin.coupons.index') }}" class="text-purple-500 hover:text-purple-400">🎫 券</a>
<a href="{{ route('admin.agents.index') }}" class="text-purple-500 hover:text-purple-400">🌸 代理</a>
<a href="{{ route('admin.users.index') }}" class="text-purple-500 hover:text-purple-400">👥 用户</a>
<a href="{{ route('admin.tickets.index') }}" class="text-purple-500 hover:text-purple-400">💌 工单</a>
@endif
</div>
</div>
<div class="flex items-center gap-3 text-sm">
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.3);color:#4A6FA5">💴 ¥{{ auth()->user()?->balance ?? 0 }}</span>
<form method="POST" action="{{ route('logout') }}" class="inline">@csrf
<button type="submit" class="anime-btn-soft text-xs">退出</button>
</form>
</div>
</div>
</nav>

@if(session('success'))
<div class="max-w-7xl mx-auto px-4 mt-4">
<div class="anime-card px-5 py-3" style="border-color:rgba(168,216,255,.6)">🌸 {{ session('success') }}</div>
</div>
@endif
@if(session('error'))
<div class="max-w-7xl mx-auto px-4 mt-4">
<div class="anime-card px-5 py-3" style="border-color:rgba(255,107,107,.6)">⚠️ {{ session('error') }}</div>
</div>
@endif

<main class="max-w-7xl mx-auto px-4 py-8 relative z-10">
@yield('content')
</main>

<footer class="border-t-2 border-pink-100 mt-12 py-8 text-center text-sm" style="color:#9CA3AF;position:relative;z-index:10">
🌸 樱花云 © 2026 · <a href="{{ route('home') }}" class="hover:text-pink-500">返回官网</a> · 二次元专属云平台
</footer>
</body>
</html>
