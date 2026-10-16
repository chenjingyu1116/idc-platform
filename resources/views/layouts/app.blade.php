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
body{font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;background:linear-gradient(135deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%);color:var(--text);min-height:100vh;position:relative;margin:0}
.anime-card{background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border:2px solid rgba(255,158,196,.3);border-radius:20px;box-shadow:0 8px 32px rgba(255,158,196,.15);transition:all .3s ease}
.anime-card:hover{border-color:rgba(255,158,196,.6);box-shadow:0 12px 40px rgba(255,158,196,.25)}
.anime-btn{background:linear-gradient(135deg,#FF9EC4 0%,#FFB6D5 50%,#A8D8FF 100%);color:#fff;border-radius:9999px;padding:8px 24px;font-weight:600;box-shadow:0 4px 15px rgba(255,158,196,.4);border:none;cursor:pointer;transition:all .3s}
.anime-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(255,158,196,.6)}
.anime-btn-soft{background:rgba(255,255,255,.9);color:var(--sakura);border:2px solid var(--sakura);border-radius:9999px;padding:6px 20px;font-weight:600;transition:all .3s}
.anime-btn-soft:hover{background:var(--sakura);color:#fff}
.petal{position:fixed;top:-10px;color:#FFB6D5;font-size:16px;pointer-events:none;animation:fall linear infinite;z-index:1;opacity:.7}
@keyframes fall{0%{transform:translateY(-10px) rotate(0);opacity:0}10%{opacity:.7}100%{transform:translateY(105vh) rotate(360deg);opacity:0}}
.nav-anime{background:rgba(255,255,255,.9);backdrop-filter:blur(16px);border-bottom:2px solid rgba(255,158,196,.25)}

/* ============ B11-B 移动端优化 ============ */

/* 移动端菜单：滑入动画 */
#mobile-menu{max-height:0;overflow:hidden;transition:max-height .35s ease}
#mobile-menu.open{max-height:80vh;overflow-y:auto}

/* 汉堡按钮动画 */
#hamburger span{display:block;width:24px;height:2px;background:#FF9EC4;margin:5px 0;transition:all .3s;border-radius:2px}
#hamburger.active span:nth-child(1){transform:translateY(7px) rotate(45deg)}
#hamburger.active span:nth-child(2){opacity:0}
#hamburger.active span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}

/* 小屏：表格转卡片 */
@media (max-width: 768px) {
    .table-responsive { display: block; width: 100%; }
    .table-responsive thead { display: none; }
    .table-responsive tbody tr {
        display: block;
        background: rgba(255,255,255,.85);
        border: 2px solid rgba(255,158,196,.25);
        border-radius: 16px;
        margin-bottom: 12px;
        padding: 12px 16px;
    }
    .table-responsive tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed rgba(255,158,196,.15);
        font-size: 13px;
    }
    .table-responsive tbody td:last-child { border-bottom: none; }
    .table-responsive tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #FF9EC4;
        margin-right: 12px;
        flex-shrink: 0;
    }
    /* 隐藏掉表格里的 emoji 装饰 */
    .table-responsive tbody td:empty { display: none; }

    /* 移动端标题缩小 */
    h1 { font-size: 1.5rem !important; }

    /* 卡片间距 */
    .anime-card { border-radius: 16px; }

    /* 隐藏桌面专用元素 */
    .desktop-only { display: none !important; }

    /* 移动端按钮加大触摸区域 */
    .anime-btn, .anime-btn-soft { min-height: 40px; padding: 10px 20px; }
}

/* 平板适配 */
@media (min-width: 769px) and (max-width: 1024px) {
    .table-responsive tbody td { font-size: 13px; }
}

/* 深色模式 */
body[data-theme="dark"]{background:linear-gradient(135deg,#1a1420,#1a1a2e,#201825);color:#E0E0F0}
body[data-theme="dark"] .anime-card{background:rgba(40,30,55,.85)!important;border-color:rgba(255,158,196,.4)!important;color:#E0E0F0}
body[data-theme="dark"] .nav-anime{background:rgba(20,15,30,.9)!important}
body[data-theme="dark"] input,body[data-theme="dark"] textarea,body[data-theme="dark"] select{background:rgba(30,20,45,.6)!important;color:#E0E0F0!important;border-color:rgba(255,158,196,.4)!important}
body[data-theme="dark"] table{color:#E0E0F0}
body[data-theme="dark"] .table-responsive tbody tr{background:rgba(40,30,55,.85)!important;border-color:rgba(255,158,196,.4)!important}

/* 平滑滚动 */
html { scroll-behavior: smooth; }
</style>
</head>
<body>
<div class="petal" style="left:5%;animation-duration:12s">🌸</div>
<div class="petal" style="left:20%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:11s;animation-delay:4s">🌸</div>
<div class="petal" style="left:60%;animation-duration:14s;animation-delay:1s">🌸</div>
<div class="petal" style="left:80%;animation-duration:13s;animation-delay:5s">🌸</div>

<nav class="nav-anime sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 py-3">
<div class="flex justify-between items-center">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <span class="text-2xl">🌸</span>
        <span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
    </a>

    {{-- 桌面导航 --}}
    <div class="hidden md:flex items-center gap-4 text-xs font-semibold flex-wrap">
        <a href="{{ route('announcements.index') }}" class="hover:text-pink-500">📢 公告</a>
        <a href="{{ route('orders.index') }}" class="hover:text-pink-500">🎀 产品</a>
<a href="{{ route('cart.index') }}" class="hover:text-pink-500">🛒 购物车</a>
        <a href="{{ route('client.services.index') }}" class="hover:text-pink-500">💗 服务</a>
        <a href="{{ route('client.recharge.index') }}" class="hover:text-pink-500">💎 充值</a>
        <a href="{{ route('client.tickets.index') }}" class="hover:text-pink-500">💌 工单</a>
        @if(auth()->user()?->is_admin)
        <span class="text-gray-300">|</span>
        <a href="{{ route('admin.dashboard') }}" class="text-purple-500 hover:text-purple-400">👑 看板</a>
        <a href="{{ route('admin.services.index') }}" class="text-purple-500 hover:text-purple-400">⚙️ 资源</a>
        <a href="{{ route('admin.recharges.index') }}" class="text-purple-500 hover:text-purple-400">💰 充值</a>
        <a href="{{ route('admin.providers.index') }}" class="text-purple-500 hover:text-purple-400">🔌 上游</a>
        <a href="{{ route('admin.reports.index') }}" class="text-purple-500 hover:text-purple-400">📊 报表</a>
        <a href="{{ route('admin.monitor.index') }}" class="text-purple-500 hover:text-purple-400">📡 监控</a>
        <a href="{{ route('admin.settings.index') }}" class="text-purple-500 hover:text-purple-400">⚙️ 设置</a>
        @endif
    </div>

    {{-- 右侧操作 --}}
    <div class="flex items-center gap-2">
        <span class="hidden md:inline px-3 py-1 rounded-full text-xs" style="background:rgba(168,216,255,.3);color:#4A6FA5">💴 ¥{{ auth()->user()?->balance ?? 0 }}</span>

        {{-- 主题切换 --}}
        <button onclick="__toggleTheme()" title="切换主题" class="hidden md:flex items-center justify-center" style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border:none;cursor:pointer;font-size:16px">
            <span id="theme-icon">🌙</span>
        </button>

        {{-- 桌面退出 --}}
        <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">@csrf
            <button type="submit" class="anime-btn-soft text-xs">退出</button>
        </form>

        {{-- 汉堡按钮（移动端） --}}
        <button id="hamburger" class="md:hidden flex flex-col justify-center items-center" onclick="__toggleMenu()" style="width:40px;height:40px;background:transparent;border:none;cursor:pointer">
            <span></span><span></span><span></span>
        </button>
    </div>
</div>

{{-- 移动端折叠菜单 --}}
<div id="mobile-menu" class="md:hidden">
    <div class="pt-4 pb-2 space-y-1 text-sm">
        <a href="{{ route('announcements.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">📢 公告</a>
        <a href="{{ route('orders.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">🎀 产品列表</a>
        <a href="{{ route('client.services.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">💗 我的服务</a>
        <a href="{{ route('client.recharge.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">💎 充值</a>
        <a href="{{ route('client.tickets.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">💌 工单</a>
        <a href="{{ route('client.coupons.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">🎫 优惠券</a>
        <a href="{{ route('client.agent.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">🌸 代理中心</a>
        <a href="{{ route('client.notifications.index') }}" class="block px-4 py-3 rounded-xl hover:bg-pink-50">🔔 通知</a>

        @if(auth()->user()?->is_admin)
        <div class="pt-2 mt-2 border-t-2 border-pink-100">
            <div class="px-4 py-2 text-xs text-purple-500 font-bold">👑 管理后台</div>
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">📊 看板</a>
            <a href="{{ route('admin.services.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">⚙️ 资源管理</a>
            <a href="{{ route('admin.recharges.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">💰 充值审核</a>
            <a href="{{ route('admin.providers.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">🔌 上游管理</a>
            <a href="{{ route('admin.tickets.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">💌 工单管理</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">👥 用户管理</a>
            <a href="{{ route('admin.reports.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">📈 报表</a>
            <a href="{{ route('admin.monitor.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">📡 监控</a>
            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-3 rounded-xl hover:bg-purple-50">⚙️ 系统设置</a>
        </div>
        @endif

        <div class="pt-3 mt-2 border-t-2 border-pink-100 flex items-center justify-between px-4 py-3">
            <span class="text-xs" style="color:#4A6FA5">💴 ¥{{ auth()->user()?->balance ?? 0 }}</span>
            <div class="flex items-center gap-2">
                <button onclick="__toggleTheme()" style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border:none">
                    <span id="theme-icon-mobile">🌙</span>
                </button>
                <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                    <button type="submit" class="anime-btn-soft text-xs">退出</button>
                </form>
            </div>
        </div>
    </div>
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

<main class="max-w-7xl mx-auto px-4 py-6 md:py-8 relative z-10">
@yield('content')
</main>

@include('components.site-footer')

@include('components.toast')
@include('components.loading')

<script>
function __toggleMenu(){
    var m = document.getElementById('mobile-menu');
    var h = document.getElementById('hamburger');
    m.classList.toggle('open');
    h.classList.toggle('active');
}

function __toggleTheme(){
    var cur = document.body.getAttribute('data-theme') || 'light';
    var next = cur === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    var i1 = document.getElementById('theme-icon');
    var i2 = document.getElementById('theme-icon-mobile');
    if (i1) i1.textContent = next === 'dark' ? '☀️' : '🌙';
    if (i2) i2.textContent = next === 'dark' ? '☀️' : '🌙';
}

(function(){
    var t = localStorage.getItem('theme') || 'light';
    document.addEventListener('DOMContentLoaded', function(){
        document.body.setAttribute('data-theme', t);
        var i1 = document.getElementById('theme-icon');
        var i2 = document.getElementById('theme-icon-mobile');
        if (i1) i1.textContent = t === 'dark' ? '☀️' : '🌙';
        if (i2) i2.textContent = t === 'dark' ? '☀️' : '🌙';
    });
})();

// 移动端：点击菜单里的链接后自动收起
document.addEventListener('DOMContentLoaded', function(){
    var menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.querySelectorAll('a').forEach(function(a){
            a.addEventListener('click', function(){
                menu.classList.remove('open');
                document.getElementById('hamburger').classList.remove('active');
            });
        });
    }
});
</script>
@include("components.ux")
</body>
</html>
