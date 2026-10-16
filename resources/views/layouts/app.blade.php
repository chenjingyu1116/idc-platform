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
@include("components.theme-vars")
<style>
body[data-theme="dark"]{background:linear-gradient(135deg,#1a1420,#1a1a2e,#201825);color:#E0E0F0}
body[data-theme="dark"] .anime-card{background:rgba(40,30,55,.85)!important;border-color:rgba(255,158,196,.4)!important;color:#E0E0F0}
body[data-theme="dark"] .nav-anime{background:rgba(20,15,30,.9)!important}
body[data-theme="dark"] input,body[data-theme="dark"] textarea,body[data-theme="dark"] select{background:rgba(30,20,45,.6)!important;color:#E0E0F0!important;border-color:rgba(255,158,196,.4)!important}
body[data-theme="dark"] table{color:#E0E0F0}
</style>
<script>
(function(){
    var t = localStorage.getItem("theme") || "light";
    document.addEventListener("DOMContentLoaded", function(){
        document.body.setAttribute("data-theme", t);
        var i = document.getElementById("theme-icon");
        if (i) i.textContent = t === "dark" ? "☀️" : "🌙";
    });
})();
function __toggleTheme(){
    var cur = document.body.getAttribute("data-theme") || "light";
    var next = cur === "dark" ? "light" : "dark";
    document.body.setAttribute("data-theme", next);
    localStorage.setItem("theme", next);
    var i = document.getElementById("theme-icon");
    if (i) i.textContent = next === "dark" ? "☀️" : "🌙";
}
</script>
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
<a href="{{ route('admin.audit-logs.index') }}" class="text-purple-500 hover:text-purple-400">📜 日志</a>
<a href="{{ route('admin.withdrawals.index') }}" class="text-purple-500 hover:text-purple-400">💸 提现</a>
<a href="{{ route('admin.finance.index') }}" class="text-purple-500 hover:text-purple-400">💰 财务</a>
<a href="{{ route('admin.admins.index') }}" class="text-purple-500 hover:text-purple-400">👑 管理员</a>
@endif
</div>
</div>
<div class="flex items-center gap-3 text-sm">
@include("components.theme-switcher")
<span class="px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.3);color:#4A6FA5">💴 ¥{{ auth()->user()?->balance ?? 0 }}</span>
<form method="POST" action="{{ route('logout') }}" class="inline">@csrf
<button type="submit" class="anime-btn-soft text-xs">退出</button>
</form>
</div>
<button onclick="__toggleTheme()" title="切换主题" style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border:none;cursor:pointer;font-size:16px">
<span id="theme-icon">🌙</span>
</button>
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

@php
    $__icp = \App\Models\Setting::where("key", "icp")->value("value") ?? "";
    $__icpLink = \App\Models\Setting::where("key", "icp_link")->value("value") ?? "https://beian.miit.gov.cn/";
    $__siteName = \App\Models\Setting::where("key", "site_name")->value("value") ?? "樱花云";
    $__slogan = \App\Models\Setting::where("key", "site_slogan")->value("value") ?? "让 IDC 管理也能如此可爱";
@endphp
@php
    $__siteName  = \App\Models\Setting::where("key", "site_name")->value("value")    ?? "樱花云";
    $__slogan    = \App\Models\Setting::where("key", "site_slogan")->value("value")   ?? "让 IDC 管理也能如此可爱";
    $__footer    = \App\Models\Setting::where("key", "footer_text")->value("value")   ?? "";
    $__icp       = \App\Models\Setting::where("key", "icp")->value("value")           ?? "";
    $__icpLink   = \App\Models\Setting::where("key", "icp_link")->value("value")      ?? "https://beian.miit.gov.cn/";
    $__qq        = \App\Models\Setting::where("key", "contact_qq")->value("value")    ?? "";
    $__wechat    = \App\Models\Setting::where("key", "contact_wechat")->value("value") ?? "";
    $__email     = \App\Models\Setting::where("key", "contact_email")->value("value") ?? "";
@endphp
<footer class="border-t-2 border-pink-100 mt-12 py-8 px-4 text-center text-sm" style="color:#9CA3AF;position:relative;z-index:10">
    <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 mb-4">
        @if($__qq)      <span>💬 QQ: {{ $__qq }}</span>@endif
        @if($__wechat)  <span>💚 微信: {{ $__wechat }}</span>@endif
        @if($__email)   <span>📧 {{ $__email }}</span>@endif
    </div>
    <div>
        🌸 {{ $__siteName }} © {{ date("Y") }} ·
        <a href="{{ route("home") }}" class="hover:text-pink-500">返回官网</a>
        @if($__slogan) · {{ $__slogan }}@endif
    </div>
    @if($__footer)
    <div class="mt-2 text-xs">{{ $__footer }}</div>
    @endif
    @if($__icp)
    <div class="mt-3 text-xs">
        <a href="{{ $__icpLink }}" target="_blank" rel="noopener" class="hover:text-pink-500 transition">🌐 {{ $__icp }}</a>
    </div>
    @endif
</footer>
@include("components.toast")
@include("components.loading")
</body>
</html>
