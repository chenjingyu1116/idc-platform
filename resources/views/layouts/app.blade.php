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
.nav-link{display:inline-flex;align-items:center;gap:4px;padding:6px 10px;border-radius:12px;font-size:13px;font-weight:600;color:#4A4A6A;transition:all .2s;white-space:nowrap}
.nav-link:hover{background:rgba(255,158,196,.15);color:#FF6B9E}
.nav-link-admin{color:#8B5CF6}
.nav-link-admin:hover{background:rgba(179,157,219,.15);color:#7C3AED}
/* 管理下拉 */
.admin-dropdown{position:relative}
.admin-dropdown-menu{position:absolute;top:100%;right:0;margin-top:8px;min-width:220px;background:rgba(255,255,255,.98);backdrop-filter:blur(16px);border:2px solid rgba(179,157,219,.3);border-radius:16px;box-shadow:0 12px 40px rgba(179,157,219,.2);padding:8px;opacity:0;visibility:hidden;transform:translateY(-8px);transition:all .25s;z-index:100}
.admin-dropdown:hover .admin-dropdown-menu{opacity:1;visibility:visible;transform:translateY(0)}
.admin-dropdown-item{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:10px;font-size:13px;color:#4A4A6A;transition:all .15s}
.admin-dropdown-item:hover{background:rgba(179,157,219,.15);color:#7C3AED}
.admin-divider{height:1px;background:rgba(255,158,196,.2);margin:6px 0}
/* 主题深色 */
body[data-theme="dark"]{background:linear-gradient(135deg,#1a1420,#1a1a2e,#201825);color:#E0E0F0}
body[data-theme="dark"] .anime-card{background:rgba(40,30,55,.85)!important;border-color:rgba(255,158,196,.4)!important;color:#E0E0F0}
body[data-theme="dark"] .nav-anime{background:rgba(20,15,30,.92)!important}
body[data-theme="dark"] .nav-link{color:#D0D0E0}
body[data-theme="dark"] .admin-dropdown-menu{background:rgba(30,20,45,.98);border-color:rgba(179,157,219,.5)}
body[data-theme="dark"] .admin-dropdown-item{color:#D0D0E0}
body[data-theme="dark"] input,body[data-theme="dark"] textarea,body[data-theme="dark"] select{background:rgba(30,20,45,.6)!important;color:#E0E0F0!important;border-color:rgba(255,158,196,.4)!important}
/* 移动端 */
@media (max-width: 768px){
  .nav-desktop{display:none!important}
  .nav-mobile-btn{display:flex!important}
  .nav-mobile-menu{display:block!important}
}
.nav-mobile-btn{display:none;cursor:pointer;padding:6px;border-radius:10px;background:rgba(255,158,196,.15)}
.nav-mobile-menu{display:none;width:100%;padding:12px 0;border-top:1px solid rgba(255,158,196,.2);margin-top:8px}
</style>
</head>
<body>

{{-- 樱花飘落 --}}
<div class="petal" style="left:5%;animation-duration:12s">🌸</div>
<div class="petal" style="left:20%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:11s;animation-delay:4s">🌸</div>
<div class="petal" style="left:60%;animation-duration:14s;animation-delay:1s">🌸</div>
<div class="petal" style="left:80%;animation-duration:13s;animation-delay:5s">🌸</div>

<nav class="nav-anime sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 py-3">

{{-- 顶部一行：Logo + 桌面菜单 + 右侧操作 --}}
<div class="flex items-center justify-between gap-3">

{{-- Logo --}}
<a href="{{ route('welcome') }}" class="flex items-center gap-2 flex-shrink-0">
<span class="text-2xl">🌸</span>
<span class="text-lg font-bold hidden sm:inline" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
</a>

{{-- 桌面端菜单 --}}
<div class="nav-desktop hidden md:flex items-center gap-1 flex-1 justify-center flex-wrap">
<a href="{{ route('announcements.index') }}" class="nav-link">📢 公告</a>
<a href="{{ route('orders.index') }}" class="nav-link">🎀 产品</a>
@if(Route::has('cart.index'))
<a href="{{ route('cart.index') }}" class="nav-link">🛒 购物车</a>
@endif
<a href="{{ route('client.services.index') }}" class="nav-link">💗 服务</a>
<a href="{{ route('client.recharge.index') }}" class="nav-link">💎 充值</a>
<a href="{{ route('client.tickets.index') }}" class="nav-link">💌 工单</a>
<a href="{{ route('client.coupons.index') }}" class="nav-link">🎫 券</a>
<a href="{{ route('client.agent.index') }}" class="nav-link">🌸 代理</a>
<a href="{{ route('client.notifications.index') }}" class="nav-link">🔔 通知</a>

@if(auth()->user()?->is_admin)
<div class="admin-dropdown">
<button class="nav-link nav-link-admin" style="cursor:pointer">
👑 管理 <span style="font-size:10px">▼</span>
</button>
<div class="admin-dropdown-menu">
<a href="{{ route('admin.dashboard') }}" class="admin-dropdown-item">👑 管理看板</a>
<div class="admin-divider"></div>
<a href="{{ route('admin.users.index') }}" class="admin-dropdown-item">👥 用户管理</a>
<a href="{{ route('admin.orders.index') }}" class="admin-dropdown-item">📦 订单管理</a>
<a href="{{ route('admin.services.index') }}" class="admin-dropdown-item">⚙️ 资源分配</a>
<div class="admin-divider"></div>
<a href="{{ route('admin.recharges.index') }}" class="admin-dropdown-item">💰 充值审核</a>
<a href="{{ route('admin.finance.index') }}" class="admin-dropdown-item">💴 财务报表</a>
<a href="{{ route('admin.withdrawals.index') }}" class="admin-dropdown-item">💸 提现审核</a>
<a href="{{ route('admin.agents.index') }}" class="admin-dropdown-item">🌸 代理管理</a>
<a href="{{ route('admin.coupons.index') }}" class="admin-dropdown-item">🎫 优惠券</a>
<div class="admin-divider"></div>
<a href="{{ route('admin.tickets.index') }}" class="admin-dropdown-item">💌 工单管理</a>
<a href="{{ route('admin.announcements.index') }}" class="admin-dropdown-item">📢 公告管理</a>
<a href="{{ route('admin.kb.index') }}" class="admin-dropdown-item">📚 知识库</a>
<div class="admin-divider"></div>
<a href="{{ route('admin.providers.index') }}" class="admin-dropdown-item">🔌 上游管理</a>
<a href="{{ route('admin.product-mappings.index') }}" class="admin-dropdown-item">🔗 产品映射</a>
<a href="{{ route('admin.provision-logs.index') }}" class="admin-dropdown-item">📋 开通日志</a>
<div class="admin-divider"></div>
<a href="{{ route('admin.reports.index') }}" class="admin-dropdown-item">📊 报表</a>
<a href="{{ route('admin.monitor.index') }}" class="admin-dropdown-item">📡 监控</a>
<a href="{{ route('admin.audit-logs.index') }}" class="admin-dropdown-item">📜 审计日志</a>
<a href="{{ route('admin.admins.index') }}" class="admin-dropdown-item">👑 管理员</a>
<a href="{{ route('admin.settings.index') }}" class="admin-dropdown-item">⚙️ 系统设置</a>
</div>
</div>
@endif
</div>

{{-- 右侧操作 --}}
<div class="flex items-center gap-2 flex-shrink-0">
<span class="hidden sm:inline-block px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.3);color:#4A6FA5">💴 ¥{{ auth()->user()?->balance ?? 0 }}</span>

<button onclick="__toggleTheme()" title="切换主题" style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border:none;cursor:pointer;font-size:14px">
<span id="theme-icon">🌙</span>
</button>

<form method="POST" action="{{ route('logout') }}" class="inline">@csrf
<button type="submit" class="anime-btn-soft text-xs hidden sm:inline-block">退出</button>
</form>

{{-- 汉堡按钮 --}}
<button class="nav-mobile-btn" onclick="document.getElementById('mobileMenu').classList.toggle('open');this.classList.toggle('active')">
<span style="display:block;width:22px;height:2px;background:#FF9EC4;margin:4px 0;transition:all .3s;border-radius:2px"></span>
<span style="display:block;width:22px;height:2px;background:#FF9EC4;margin:4px 0;transition:all .3s;border-radius:2px"></span>
<span style="display:block;width:22px;height:2px;background:#FF9EC4;margin:4px 0;transition:all .3s;border-radius:2px"></span>
</button>
</div>
</div>

{{-- 移动端菜单 --}}
<div id="mobileMenu" class="nav-mobile-menu">
<div class="grid grid-cols-2 gap-2">
<a href="{{ route('announcements.index') }}" class="nav-link">📢 公告</a>
<a href="{{ route('orders.index') }}" class="nav-link">🎀 产品</a>
@if(Route::has('cart.index'))
<a href="{{ route('cart.index') }}" class="nav-link">🛒 购物车</a>
@endif
<a href="{{ route('client.services.index') }}" class="nav-link">💗 服务</a>
<a href="{{ route('client.recharge.index') }}" class="nav-link">💎 充值</a>
<a href="{{ route('client.tickets.index') }}" class="nav-link">💌 工单</a>
<a href="{{ route('client.coupons.index') }}" class="nav-link">🎫 券</a>
<a href="{{ route('client.agent.index') }}" class="nav-link">🌸 代理</a>
<a href="{{ route('client.notifications.index') }}" class="nav-link">🔔 通知</a>
@if(auth()->user()?->is_admin)
<a href="{{ route('admin.dashboard') }}" class="nav-link nav-link-admin">👑 看板</a>
<a href="{{ route('admin.users.index') }}" class="nav-link nav-link-admin">👥 用户</a>
<a href="{{ route('admin.orders.index') }}" class="nav-link nav-link-admin">📦 订单</a>
<a href="{{ route('admin.services.index') }}" class="nav-link nav-link-admin">⚙️ 资源</a>
<a href="{{ route('admin.recharges.index') }}" class="nav-link nav-link-admin">💰 充值</a>
<a href="{{ route('admin.finance.index') }}" class="nav-link nav-link-admin">💴 财务</a>
<a href="{{ route('admin.withdrawals.index') }}" class="nav-link nav-link-admin">💸 提现</a>
<a href="{{ route('admin.agents.index') }}" class="nav-link nav-link-admin">🌸 代理</a>
<a href="{{ route('admin.coupons.index') }}" class="nav-link nav-link-admin">🎫 券</a>
<a href="{{ route('admin.tickets.index') }}" class="nav-link nav-link-admin">💌 工单</a>
<a href="{{ route('admin.announcements.index') }}" class="nav-link nav-link-admin">📢 公告</a>
<a href="{{ route('admin.kb.index') }}" class="nav-link nav-link-admin">📚 知识库</a>
<a href="{{ route('admin.providers.index') }}" class="nav-link nav-link-admin">🔌 上游</a>
<a href="{{ route('admin.product-mappings.index') }}" class="nav-link nav-link-admin">🔗 映射</a>
<a href="{{ route('admin.provision-logs.index') }}" class="nav-link nav-link-admin">📋 日志</a>
<a href="{{ route('admin.reports.index') }}" class="nav-link nav-link-admin">📊 报表</a>
<a href="{{ route('admin.monitor.index') }}" class="nav-link nav-link-admin">📡 监控</a>
<a href="{{ route('admin.audit-logs.index') }}" class="nav-link nav-link-admin">📜 审计</a>
<a href="{{ route('admin.admins.index') }}" class="nav-link nav-link-admin">👑 管理员</a>
<a href="{{ route('admin.settings.index') }}" class="nav-link nav-link-admin">⚙️ 设置</a>
@endif
</div>
<form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf
<button type="submit" class="anime-btn w-full text-xs">退出登录</button>
</form>
</div>

</div>
</nav>

<style>
#mobileMenu{max-height:0;overflow:hidden;transition:max-height .35s ease}
#mobileMenu.open{max-height:80vh;overflow-y:auto}
.nav-mobile-btn.active span:nth-child(1){transform:translateY(6px) rotate(45deg)}
.nav-mobile-btn.active span:nth-child(2){opacity:0}
.nav-mobile-btn.active span:nth-child(3){transform:translateY(-6px) rotate(-45deg)}
</style>

{{-- 消息提示 --}}
<div class="max-w-7xl mx-auto px-4 mt-4">
@if(session('success'))<div class="anime-card px-5 py-3" style="border-color:rgba(168,216,255,.6)">🌸 {{ session('success') }}</div>@endif
@if(session('error'))<div class="anime-card px-5 py-3" style="border-color:rgba(255,107,107,.6)">⚠️ {{ session('error') }}</div>@endif
</div>

<main class="max-w-7xl mx-auto px-4 py-8 relative z-10">
@yield('content')
</main>

@include('components.site-footer')
@include('components.toast')
@include('components.loading')

{{-- 主题切换 --}}
<script>
(function(){
    var t = localStorage.getItem("theme") || "light";
    document.body.setAttribute("data-theme", t);
    var i = document.getElementById("theme-icon");
    if (i) i.textContent = t === "dark" ? "☀️" : "🌙";
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
</body>
</html>
