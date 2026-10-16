<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>樱花云 · 二次元专属云平台</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;background:linear-gradient(180deg,#FFF5FA 0%,#F0F5FF 40%,#FFF0F5 100%);color:#4A4A6A;overflow-x:hidden}
.anime-card{background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border:2px solid rgba(255,158,196,.3);border-radius:24px;transition:all .3s}
.anime-card:hover{border-color:rgba(255,158,196,.6);box-shadow:0 20px 50px rgba(255,158,196,.25);transform:translateY(-6px)}
.anime-btn{background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border-radius:9999px;padding:14px 36px;font-weight:600;box-shadow:0 6px 20px rgba(255,158,196,.4);border:none;cursor:pointer;transition:all .3s}
.anime-btn:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(255,158,196,.6)}
.anime-btn-soft{background:rgba(255,255,255,.9);color:#FF9EC4;border:2px solid #FF9EC4;border-radius:9999px;padding:12px 34px;font-weight:600;transition:all .3s}
.anime-btn-soft:hover{background:#FF9EC4;color:#fff}
.petal{position:fixed;top:-10px;color:#FFB6D5;font-size:20px;pointer-events:none;animation:fall linear infinite;z-index:1}
@keyframes fall{0%{transform:translateY(-10px) rotate(0);opacity:0}10%{opacity:.8}100%{transform:translateY(105vh) rotate(360deg);opacity:0}}
.floaty{animation:float 4s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
</style>
@include("components.theme-vars")
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div class="petal" style="left:5%;animation-duration:14s">🌸</div>
<div class="petal" style="left:20%;animation-duration:12s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:16s;animation-delay:1s">🌸</div>
<div class="petal" style="left:60%;animation-duration:13s;animation-delay:3s">🌸</div>
<div class="petal" style="left:80%;animation-duration:15s;animation-delay:4s">🌸</div>
<div class="petal" style="left:95%;animation-duration:11s;animation-delay:5s">🌸</div>

<nav class="sticky top-0 z-50" style="background:rgba(255,255,255,.85);backdrop-filter:blur(16px);border-bottom:2px solid rgba(255,158,196,.2)">
<div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
<a href="/" class="flex items-center gap-2"><span class="text-2xl">🌸</span><span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span></a>
<div class="hidden md:flex items-center gap-6 text-sm font-semibold">
<a href="{{ route('orders.index') }}" class="hover:text-pink-500 transition">🎀 产品</a>
<a href="{{ auth()->check() ? route('client.tickets.index') : route('login') }}" class="hover:text-pink-500 transition">💌 工单</a>
<a href="{{ route('kb.index') }}" class="hover:text-pink-500 transition">📖 帮助</a>
</div>
<div class="flex items-center gap-3 text-sm">
@auth
<a href="{{ route('orders.index') }}" class="anime-btn-soft text-xs">控制台</a>
<form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button type="submit" class="anime-btn text-xs" style="padding:8px 20px">退出</button></form>
@else
<a href="{{ route('login') }}" class="anime-btn-soft text-xs">💗 登录</a>
<a href="{{ route('register') }}" class="anime-btn text-xs" style="padding:8px 20px">✨ 注册</a>
@endauth
</div>
</div>
</nav>

<section class="relative overflow-hidden py-20">
<div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center relative z-10">
<div>
<div class="inline-block px-4 py-1 rounded-full mb-6 text-sm font-semibold" style="background:rgba(255,158,196,.15);color:#FF6B9E">✨ 二次元专属云平台</div>
<h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6" style="font-family:'ZCOOL KuaiLe'">
<span style="color:#FF9EC4">樱花云</span><br>
<span style="color:#B39DDB">萌系 VPS 空间</span>
</h1>
<p class="text-lg mb-8" style="color:#7A7A9A">五元起 · 免备案 · 二次元专属主题 · 7×24 萌妹客服 🎀</p>
<div class="flex flex-wrap gap-4">
<a href="{{ route('register') }}" class="anime-btn">🌸 立即体验 →</a>
<a href="#products" class="anime-btn-soft">了解更多</a>
</div>
</div>
<div class="relative floaty">
<div class="anime-card p-12 text-center">
<div class="text-8xl mb-6">🐱</div>
<div class="text-3xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花喵</div>
<div class="text-sm mt-3" style="color:#7A7A9A">为你守护每一台服务器 🌸</div>
<div class="flex justify-center gap-3 mt-6 text-3xl">
<span>⭐</span><span>💎</span><span>🌸</span><span>✨</span>
</div>
</div>
</div>
</div>
</section>

<section class="py-12 border-t-2 border-pink-100" style="background:rgba(255,255,255,.5)">
<div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
<div class="text-center"><div class="text-4xl mb-2">🌸</div><div class="font-bold">樱花机房</div><div class="text-xs mt-1" style="color:#9CA3AF">多地冗余备份</div></div>
<div class="text-center"><div class="text-4xl mb-2">⚡</div><div class="font-bold">极速响应</div><div class="text-xs mt-1" style="color:#9CA3AF">CN2 直连</div></div>
<div class="text-center"><div class="text-4xl mb-2">💎</div><div class="font-bold">超值价格</div><div class="text-xs mt-1" style="color:#9CA3AF">5 元起购</div></div>
<div class="text-center"><div class="text-4xl mb-2">🎀</div><div class="font-bold">萌妹客服</div><div class="text-xs mt-1" style="color:#9CA3AF">7×24 在线</div></div>
</div>
</section>

<section id="products" class="py-20">
<div class="max-w-7xl mx-auto px-4">
<div class="text-center mb-12">
<h2 class="text-4xl font-bold mb-3" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">我们的云产品</h2>
<p class="text-sm" style="color:#9CA3AF">每一台都用心呵护 🌸</p>
</div>
<div class="grid md:grid-cols-3 gap-6">
<div class="anime-card p-8 text-center">
<div class="text-5xl mb-4">🖥️</div>
<h3 class="text-xl font-bold mb-2" style="color:#FF9EC4">香港虚拟主机</h3>
<p class="text-sm" style="color:#7A7A9A">免备案 · CN2 直连 · 5 元起</p>
<div class="text-2xl font-bold mt-4" style="color:#B39DDB">¥5<span class="text-sm">/月起</span></div>
</div>
<div class="anime-card p-8 text-center">
<div class="text-5xl mb-4">☁️</div>
<h3 class="text-xl font-bold mb-2" style="color:#FF9EC4">云服务器 VPS</h3>
<p class="text-sm" style="color:#7A7A9A">1核1G 起 · 按需升级</p>
<div class="text-2xl font-bold mt-4" style="color:#B39DDB">¥15<span class="text-sm">/月起</span></div>
</div>
<div class="anime-card p-8 text-center">
<div class="text-5xl mb-4">🚀</div>
<h3 class="text-xl font-bold mb-2" style="color:#FF9EC4">美国大带宽</h3>
<p class="text-sm" style="color:#7A7A9A">100M 大带宽 · 高防可选</p>
<div class="text-2xl font-bold mt-4" style="color:#B39DDB">¥25<span class="text-sm">/月起</span></div>
</div>
</div>
</div>
</section>

<section class="py-16" style="background:linear-gradient(135deg,#FF9EC4 0%,#B39DDB 100%)">
<div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-white">
<div>
<div class="text-2xl font-bold" style="font-family:'ZCOOL KuaiLe'">🌸 现在就加入樱花云</div>
<div class="text-sm opacity-90 mt-2">二次元专属，萌系体验</div>
</div>
<div class="flex gap-4">
<a href="{{ route('register') }}" class="px-6 py-3 rounded-full font-semibold" style="background:#fff;color:#FF9EC4">✨ 注册会员</a>
<a href="{{ route('login') }}" class="px-6 py-3 rounded-full font-semibold" style="border:2px solid #fff;color:#fff">💗 登录用户</a>
</div>
</div>
</section>


@include("components.site-footer")
@include("components.theme-switcher")
@include("components.ux")
</body>
</html>
