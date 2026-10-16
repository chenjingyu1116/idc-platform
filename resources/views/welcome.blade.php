<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>樱花云 · 二次元专属云平台</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&family=Noto+Sans+SC:wght@300;400;600&display=swap" rel="stylesheet">
<style>
:root{
    --sakura:#FF9EC4; --sakura-2:#FFB6D5; --sky:#A8D8FF;
    --purple:#B39DDB; --cream:#FFE5B4; --text:#4A4A6A;
}
*{box-sizing:border-box}
body{
    margin:0; min-height:100vh; overflow-x:hidden;
    font-family:'Quicksand','Noto Sans SC',sans-serif;
    color:var(--text);
    background:linear-gradient(135deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%);
    position:relative;
}
body::before{
    content:''; position:fixed; inset:0;
    background-image:
        radial-gradient(2px 2px at 15% 25%, rgba(255,209,232,.9) 50%, transparent),
        radial-gradient(2px 2px at 55% 65%, rgba(255,229,180,.9) 50%, transparent),
        radial-gradient(2px 2px at 85% 15%, rgba(212,197,255,.9) 50%, transparent),
        radial-gradient(2px 2px at 25% 75%, rgba(255,209,232,.9) 50%, transparent),
        radial-gradient(2px 2px at 92% 55%, rgba(255,229,180,.9) 50%, transparent),
        radial-gradient(2px 2px at 5% 50%, rgba(212,197,255,.9) 50%, transparent);
    background-size:400px 400px;
    animation:sparkle 8s ease-in-out infinite;
    pointer-events:none; z-index:0; opacity:.7;
}
@keyframes sparkle{0%,100%{opacity:.4}50%{opacity:.9}}

.petal{
    position:fixed; top:-20px; pointer-events:none; z-index:1;
    font-size:20px; color:#FFB6D5; opacity:.8;
    animation:fall linear infinite;
    filter:drop-shadow(0 0 4px rgba(255,158,196,.6));
}
@keyframes fall{
    0%{transform:translateY(-20px) rotate(0);opacity:0}
    10%{opacity:.8}
    100%{transform:translateY(105vh) rotate(720deg);opacity:0}
}

.anime-card{
    background:rgba(255,255,255,.88); backdrop-filter:blur(14px);
    border:2px solid rgba(255,158,196,.3);
    border-radius:22px; box-shadow:0 8px 32px rgba(255,158,196,.15);
    transition:all .35s cubic-bezier(.4,0,.2,1);
    position:relative; overflow:hidden;
}
.anime-card:hover{
    border-color:rgba(255,158,196,.7);
    box-shadow:0 12px 40px rgba(255,158,196,.3);
    transform:translateY(-4px);
}
.anime-btn{
    display:inline-block;
    background:linear-gradient(135deg,#FF9EC4 0%,#FFB6D5 50%,#A8D8FF 100%);
    background-size:200% 200%;
    color:#fff; border-radius:9999px;
    padding:14px 36px; font-weight:600;
    box-shadow:0 6px 20px rgba(255,158,196,.4);
    border:none; cursor:pointer; transition:all .3s;
    animation:gradientShift 3s ease infinite;
    text-decoration:none;
}
.anime-btn:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(255,158,196,.7)}
@keyframes gradientShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}

.anime-btn-soft{
    display:inline-block;
    background:rgba(255,255,255,.9); color:#FF9EC4;
    border:2px solid #FF9EC4; border-radius:9999px;
    padding:12px 34px; font-weight:600;
    transition:all .3s; text-decoration:none;
}
.anime-btn-soft:hover{background:#FF9EC4;color:#fff;transform:translateY(-2px)}

.nav-anime{
    background:rgba(255,255,255,.85); backdrop-filter:blur(18px);
    border-bottom:2px solid rgba(255,158,196,.25);
    box-shadow:0 4px 20px rgba(255,158,196,.08);
    position:sticky; top:0; z-index:50;
}

.floaty{animation:float 4s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)}}

.glow-orb{
    position:absolute; border-radius:50%;
    filter:blur(70px); opacity:.45; pointer-events:none; z-index:0;
}
.glow-a{width:340px;height:340px;background:#FF9EC4;top:-100px;left:-100px;animation:float 7s ease-in-out infinite}
.glow-b{width:280px;height:280px;background:#A8D8FF;bottom:-80px;right:5%;animation:float 9s ease-in-out infinite reverse}
.glow-c{width:220px;height:220px;background:#B39DDB;top:40%;right:-80px;animation:float 8s ease-in-out infinite}

.hero-wrap{position:relative; overflow:hidden; padding:80px 0}
.hero-wrap #particles-canvas{position:absolute;inset:0;z-index:0;opacity:.7}
.hero-wrap .hero-content{position:relative;z-index:2}

.stat-num{
    font-family:'ZCOOL KuaiLe',sans-serif; font-weight:800;
    background:linear-gradient(135deg,#FF9EC4,#B39DDB);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}

.section-title{
    font-family:'ZCOOL KuaiLe',sans-serif;
    background:linear-gradient(90deg,#FF9EC4,#B39DDB,#A8D8FF);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}

@keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
.fade-up{animation:fadeUp .7s ease-out both}

@media (max-width:768px){
    .hero-wrap{padding:40px 0}
    .glow-orb{display:none}
}

/* 鼠标跟随星星 */
.cursor-star {
    position: fixed; pointer-events: none; z-index: 9998;
    font-size: 14px; color: #FF9EC4; user-select: none;
    animation: starFade .8s ease-out forwards;
}
@keyframes starFade {
    0% { transform: translateY(0) scale(1); opacity: 1; }
    100% { transform: translateY(-40px) scale(.3); opacity: 0; }
}

/* 滚动淡入 */
.reveal { opacity: 0; transform: translateY(40px); transition: all .8s cubic-bezier(.4,0,.2,1); }
.reveal.in { opacity: 1; transform: translateY(0); }

/* 数字滚动 */
.count-up { display: inline-block; }

/* 评价卡 */
.review-card {
    background: rgba(255,255,255,.88);
    backdrop-filter: blur(14px);
    border: 2px solid rgba(255,158,196,.3);
    border-radius: 22px;
    padding: 24px;
    transition: all .3s;
}
.review-card:hover {
    border-color: rgba(255,158,196,.7);
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(255,158,196,.3);
}
.avatar {
    width: 48px; height: 48px; border-radius: 50%;
    background: linear-gradient(135deg,#FF9EC4,#B39DDB);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}

/* FAQ 折叠 */
.faq-item {
    background: rgba(255,255,255,.9);
    border: 2px solid rgba(255,158,196,.25);
    border-radius: 16px;
    margin-bottom: 12px;
    overflow: hidden;
    transition: all .3s;
}
.faq-item:hover { border-color: rgba(255,158,196,.5); }
.faq-q {
    padding: 18px 24px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #4A4A6A;
}
.faq-a {
    max-height: 0;
    padding: 0 24px;
    overflow: hidden;
    transition: all .4s;
    color: #7A7A9A;
    font-size: 14px;
    line-height: 1.7;
}
.faq-item.open .faq-a { max-height: 300px; padding: 0 24px 18px; }
.faq-item.open .faq-icon { transform: rotate(45deg); }
.faq-icon { transition: transform .3s; color: #FF9EC4; font-size: 20px; font-weight: 300; }

/* 会员等级徽章 */
.level-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    background: linear-gradient(135deg, rgba(255,158,196,.2), rgba(179,157,219,.2));
    color: #FF6B9E;
}

/* ═══ 可读性优化 ═══ */

/* 1. Hero 文字增强对比度 */
.hero-title, h1[style*="ZCOOL"], h1 {
    text-shadow: 0 4px 20px rgba(255,255,255,.9), 0 2px 8px rgba(255,158,196,.4) !important;
}
.hero-subtitle, p[style*="7A7A9A"] {
    text-shadow: 0 2px 12px rgba(255,255,255,.95) !important;
    font-weight: 600 !important;
}

/* 2. Hero 区域加轻微毛玻璃底 */
.hero-wrap, section:has(canvas#particles-canvas) {
    backdrop-filter: blur(2px);
}

/* 3. 数据统计卡片化 */
.stat-number {
    display: inline-block;
    padding: 8px 16px;
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 2px solid rgba(255,158,196,.35);
    box-shadow: 0 8px 24px rgba(255,158,196,.2);
    text-shadow: 0 2px 8px rgba(255,255,255,.5) !important;
    margin-bottom: 6px;
}

/* 4. 主按钮强化 */
.anime-btn, a.anime-btn {
    box-shadow: 0 8px 24px rgba(255,158,196,.5), 0 4px 12px rgba(179,157,219,.3) !important;
    position: relative;
    overflow: hidden;
}
.anime-btn:hover, a.anime-btn:hover {
    box-shadow: 0 12px 32px rgba(255,158,196,.7), 0 6px 16px rgba(179,157,219,.4) !important;
    transform: translateY(-3px) scale(1.02) !important;
}
.anime-btn-soft {
    background: rgba(255,255,255,.9) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 6px 20px rgba(255,158,196,.25) !important;
}

/* 5. 弹幕更清晰 */
.danmaku-item {
    font-weight: 700 !important;
    opacity: .85;
}

/* 6. 卡片 hover 微动 */
.anime-card {
    transition: all .35s cubic-bezier(.4,0,.2,1) !important;
}
.anime-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(255,158,196,.3) !important;
}

/* 7. 产品卡片价格更突出 */
.anime-card .text-3xl, .anime-card [class*="text-3xl"] {
    text-shadow: 0 2px 10px rgba(255,158,196,.3);
}

/* 8. 四个理由卡片图标放大 */
.anime-card .text-4xl, .anime-card .text-3xl {
    filter: drop-shadow(0 4px 12px rgba(255,158,196,.3));
}

/* 9. 按钮点击波纹 */
.anime-btn:active {
    transform: scale(.97) !important;
}

/* 10. 页面加载淡入 */
@keyframes pageFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}
main, .main-content {
    animation: pageFadeIn .6s ease-out;
}

/* ═══ HERO 遮罩 ═══ */
/* 给 Hero 文字区加毛玻璃底，保证可读 */
.hero-content > div:first-child {
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 40px 36px !important;
    box-shadow: 0 20px 60px rgba(255, 158, 196, 0.25),
                inset 0 1px 0 rgba(255,255,255,.8);
    border: 2px solid rgba(255, 158, 196, 0.3);
}

/* Hero 大标题加白色描边 */
.hero-content h1 {
    text-shadow:
        0 2px 0 rgba(255,255,255,1),
        0 4px 20px rgba(255,158,196,.5),
        0 8px 32px rgba(179,157,219,.3) !important;
}

/* 副标题加粗 + 阴影 */
.hero-content h1 + p {
    font-weight: 700 !important;
    color: #5A4A6A !important;
    text-shadow: 0 1px 4px rgba(255,255,255,.9) !important;
}

/* 数据统计卡片：更清晰 */
.hero-content .stat-number {
    background: linear-gradient(135deg, rgba(255,255,255,.95), rgba(255,245,250,.9)) !important;
    border: 2px solid rgba(255,158,196,.5) !important;
    box-shadow: 0 8px 20px rgba(255,158,196,.35) !important;
}

/* Hero 背景图稍暗一点，让文字区更突出 */
.hero-wrap::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(255,245,250,.5) 0%, transparent 60%);
    pointer-events: none;
    z-index: 1;
}

/* 响应式：手机端去掉毛玻璃（省性能） */
@media (max-width: 768px) {
    .hero-content > div:first-child {
        background: rgba(255,255,255,.9);
        backdrop-filter: none;
        padding: 24px 20px !important;
    }
}

/* ═══ FINAL 优化 ═══ */

/* 1. 数据统计：更醒目 */
.hero-content .stat-number {
    font-size: 2.8rem !important;
    font-weight: 900 !important;
    text-shadow: 0 3px 12px rgba(255,158,196,.5), 0 0 30px rgba(255,255,255,.8) !important;
    display: block !important;
    padding: 12px 20px !important;
    background: linear-gradient(135deg, rgba(255,255,255,.98), rgba(255,240,248,.95)) !important;
    border-radius: 18px !important;
    border: 2px solid rgba(255,158,196,.6) !important;
    box-shadow: 0 10px 28px rgba(255,158,196,.35), inset 0 1px 0 rgba(255,255,255,1) !important;
}
.hero-content .stat-number + div {
    font-weight: 600 !important;
    color: #7A5A7A !important;
    margin-top: 4px !important;
    font-size: 13px !important;
}

/* 2. "了解更多" 按钮：边框加深 */
.hero-content .anime-btn-soft {
    border: 2px solid rgba(255,158,196,.8) !important;
    color: #FF6B9E !important;
    font-weight: 600 !important;
    background: rgba(255,255,255,.95) !important;
}
.hero-content .anime-btn-soft:hover {
    background: #FF9EC4 !important;
    color: #fff !important;
}

/* 3. 滚动淡入动画 */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity .8s ease-out, transform .8s ease-out;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* 4. 弹幕更清晰可见 */
.danmaku-item {
    font-weight: 700 !important;
    font-size: 16px !important;
    opacity: .95 !important;
    z-index: 5 !important;
    text-shadow: 0 2px 10px rgba(0,0,0,.15), 0 0 12px rgba(255,255,255,.9) !important;
}

/* 5. 产品卡片：价格更突出 */
.product-card .price, .anime-card h3 + div {
    font-weight: 900 !important;
}

/* 6. 卡片进入视口逐个出现 */
@keyframes cardIn {
    from { opacity: 0; transform: translateY(40px) scale(.95); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.anime-card { animation: cardIn .6s ease-out backwards; }
.anime-card:nth-child(1) { animation-delay: .1s; }
.anime-card:nth-child(2) { animation-delay: .2s; }
.anime-card:nth-child(3) { animation-delay: .3s; }
.anime-card:nth-child(4) { animation-delay: .4s; }

/* ═══ 页脚优化 ═══ */
/* 页脚加毛玻璃底，隔绝背景图干扰 */
footer {
    background: rgba(255, 255, 255, 0.92) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-top: 2px solid rgba(255, 158, 196, 0.3) !important;
    position: relative;
    z-index: 10;
    box-shadow: 0 -8px 32px rgba(255, 158, 196, 0.15);
}

footer a, footer span, footer div {
    text-shadow: 0 1px 2px rgba(255,255,255,.8);
    color: #5A4A6A !important;
}

/* 暗色模式 */
body[data-theme="dark"] footer {
    background: rgba(20, 15, 30, 0.92) !important;
    border-top-color: rgba(255, 158, 196, 0.4) !important;
}
body[data-theme="dark"] footer a,
body[data-theme="dark"] footer span,
body[data-theme="dark"] footer div {
    color: #B0B0C8 !important;
    text-shadow: none;
}

/* 页脚里的小图标和备案信息稍微放大 */
footer .text-xs, footer [class*="text-xs"] {
    font-size: 13px !important;
    font-weight: 500;
}

/* 页脚区域有内边距，不贴底 */
footer {
    padding-top: 24px !important;
    padding-bottom: 24px !important;
}

/* ═══ 顺便优化：CTA 横幅前的过渡 ═══ */
/* 让 CTA 蓝色横幅和背景衔接更自然 */
section:has(.anime-btn) + footer {
    margin-top: 0 !important;
}
</style>
</head>
<body>
@include("components.background-slider")
@include("components.danmaku")

{{-- 樱花飘落 --}}
@for($i = 0; $i < 10; $i++)
<div class="petal" style="left:{{ ($i * 10 + 3) % 100 }}%;animation-duration:{{ 10 + ($i % 5) * 2 }}s;animation-delay:{{ $i * 1.1 }}s">{{ $i % 3 == 0 ? '🌸' : ($i % 3 == 1 ? '🌸' : '🌸') }}</div>
@endfor

{{-- 导航栏 --}}
<nav class="nav-anime">
<div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="/" class="flex items-center gap-2">
        <span class="text-3xl">🌸</span>
        <span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
    </a>
    <div class="hidden md:flex items-center gap-6 text-sm font-semibold">
        <a href="#products" class="hover:text-pink-500 transition">🎀 产品</a>
        <a href="/announcements" class="hover:text-pink-500 transition">📢 公告</a>
        <a href="/kb" class="hover:text-pink-500 transition">📖 帮助</a>
    </div>
    <div class="flex items-center gap-3">
        @auth
            <a href="{{ route('orders.index') }}" class="anime-btn-soft text-xs" style="padding:8px 20px">控制台</a>
        @else
            <a href="{{ route('login') }}" class="anime-btn-soft text-xs" style="padding:8px 20px">💗 登录</a>
            <a href="{{ route('register') }}" class="anime-btn text-xs" style="padding:8px 20px">✨ 注册</a>
        @endauth
    </div>
</div>
</nav>

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="hero-wrap">
    <canvas id="particles-canvas"></canvas>
    <div class="glow-orb glow-a"></div>
    <div class="glow-orb glow-b"></div>
    <div class="glow-orb glow-c"></div>

    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center hero-content">
        <div class="fade-up">
            <div class="inline-block px-4 py-1 rounded-full mb-6 text-sm font-semibold" style="background:rgba(255,158,196,.15);color:#FF6B9E">
                ✨ 二次元专属云平台 · 樱花飘落
            </div>
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6" style="font-family:'ZCOOL KuaiLe'">
                <span style="color:#FF9EC4">樱花云</span><br>
                <span style="color:#B39DDB">萌系 VPS 空间</span>
            </h1>
            <p class="text-lg mb-8" style="color:#7A7A9A">五元起 · 免备案 · 二次元专属主题 · 7×24 萌妹客服 🎀</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="anime-btn">🌸 立即体验 →</a>
                <a href="#products" class="anime-btn-soft">了解更多</a>
            </div>

            <div class="grid grid-cols-3 gap-6 mt-12">
                <div class="text-center">
                    <div class="text-4xl font-bold stat-num">12000<span class="text-lg">+</span></div>
                    <div class="text-xs mt-1" style="color:#9CA3AF">🌸 云客户</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold stat-num">99.9<span class="text-lg">%</span></div>
                    <div class="text-xs mt-1" style="color:#9CA3AF">⚡ 在线率</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold stat-num">50<span class="text-lg">+</span></div>
                    <div class="text-xs mt-1" style="color:#9CA3AF">💎 全球节点</div>
                </div>
            </div>
        </div>

        {{-- 二次元插画（SVG）--}}
        <div class="floaty fade-up" style="animation-delay:.2s">
            <div class="relative w-full aspect-square max-w-md mx-auto">
                {{-- 光晕底盘 --}}
                <div class="absolute inset-8 rounded-full" style="background:radial-gradient(circle, rgba(255,158,196,.4) 0%, transparent 70%)"></div>

                <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="relative z-10">
                    {{-- 背景圆环 --}}
                    <circle cx="200" cy="200" r="170" fill="none" stroke="rgba(255,158,196,.25)" stroke-width="2"/>
                    <circle cx="200" cy="200" r="140" fill="none" stroke="rgba(168,216,255,.3)" stroke-width="1.5" stroke-dasharray="8 8"/>

                    {{-- 花瓣装饰 --}}
                    <ellipse cx="60" cy="80" rx="16" ry="11" fill="#FFB6D5" transform="rotate(-30 60 80)" opacity=".8"/>
                    <ellipse cx="340" cy="120" rx="14" ry="9" fill="#FFD1E8" transform="rotate(20 340 120)" opacity=".8"/>
                    <ellipse cx="330" cy="330" rx="12" ry="8" fill="#FFB6D5" transform="rotate(-45 330 330)" opacity=".8"/>

                    {{-- 三层服务器 --}}
                    <rect x="140" y="160" width="120" height="42" rx="10" fill="#A8D8FF" stroke="#7AB8E8" stroke-width="2"/>
                    <circle cx="162" cy="181" r="4" fill="#fff"/>
                    <line x1="182" y1="181" x2="240" y2="181" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                    <rect x="140" y="212" width="120" height="42" rx="10" fill="#FF9EC4" stroke="#FF6B9E" stroke-width="2"/>
                    <circle cx="162" cy="233" r="4" fill="#fff"/>
                    <line x1="182" y1="233" x2="240" y2="233" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                    <rect x="140" y="264" width="120" height="42" rx="10" fill="#B39DDB" stroke="#9B86C8" stroke-width="2"/>
                    <circle cx="162" cy="285" r="4" fill="#fff"/>
                    <line x1="182" y1="285" x2="240" y2="285" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                    {{-- 云朵 --}}
                    <g transform="translate(200, 90)" opacity=".9">
                        <ellipse cx="0" cy="0" rx="45" ry="22" fill="rgba(255,255,255,.95)"/>
                        <ellipse cx="-25" cy="6" rx="22" ry="16" fill="rgba(255,255,255,.95)"/>
                        <ellipse cx="25" cy="6" rx="28" ry="19" fill="rgba(255,255,255,.95)"/>
                    </g>

                    {{-- 粉色爱心 --}}
                    <path d="M100,120 C100,110 110,110 110,120 C110,110 120,110 120,120 C120,130 110,140 110,140 C110,140 100,130 100,120 Z" fill="#FF9EC4" opacity=".9"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ 四个理由 ═══════════════ --}}
<section class="py-16" style="background:rgba(255,255,255,.5)">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold section-title mb-3">四个理由选择我们</h2>
            <p class="text-sm" style="color:#9CA3AF">为什么大家都选择樱花云 🌸</p>
        </div>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="anime-card p-6 text-center reveal">
                <div class="text-5xl mb-4">⚡</div>
                <h3 class="font-bold text-lg mb-2" style="color:#FF9EC4">极速 CN2 直连</h3>
                <p class="text-sm" style="color:#7A7A9A">香港节点，低延迟，中国大陆直连体验</p>
            </div>
            <div class="anime-card p-6 text-center reveal">
                <div class="text-5xl mb-4">🛡️</div>
                <h3 class="font-bold text-lg mb-2" style="color:#A8D8FF">DDOS 高防保护</h3>
                <p class="text-sm" style="color:#7A7A9A">所有节点均配备 DDOS 高防，保障业务稳定</p>
            </div>
            <div class="anime-card p-6 text-center reveal">
                <div class="text-5xl mb-4">💎</div>
                <h3 class="font-bold text-lg mb-2" style="color:#B39DDB">60 秒极速开通</h3>
                <p class="text-sm" style="color:#7A7A9A">付款后 60 秒自动开通，无需等待人工审核</p>
            </div>
            <div class="anime-card p-6 text-center reveal">
                <div class="text-5xl mb-4">🎀</div>
                <h3 class="font-bold text-lg mb-2" style="color:#FFB6D5">萌妹 7×24 客服</h3>
                <p class="text-sm" style="color:#7A7A9A">7×24 在线客服，工单 2 小时内回复</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ 产品 ═══════════════ --}}
<section id="products" class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold section-title mb-3">我们的云产品</h2>
            <p class="text-sm" style="color:#9CA3AF">每一台都用心呵护 🌸</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach(\App\Models\Product::where('is_active', true)->take(6)->get() as $product)
            <div class="anime-card p-6 reveal">
                <div class="text-center mb-4">
                    <div class="text-5xl mb-2">🌸</div>
                </div>
                <h3 class="text-xl font-bold mb-2 text-center" style="color:#FF9EC4">{{ $product->name }}</h3>
                <p class="text-sm text-center mb-4" style="color:#7A7A9A">{{ $product->description ?? '优质云服务' }}</p>
                <div class="text-center mb-6">
                    <span class="text-3xl font-bold" style="color:#B39DDB">¥{{ $product->price }}</span>
                    <span class="text-sm" style="color:#9CA3AF">/ 月</span>
                </div>
                <div class="space-y-1 text-xs mb-6" style="color:#7A7A9A">
                    <div class="flex justify-between"><span>CPU</span><span>{{ $product->config['cpu'] ?? '1核' }}</span></div>
                    <div class="flex justify-between"><span>内存</span><span>{{ $product->config['memory'] ?? '1G' }}</span></div>
                    <div class="flex justify-between"><span>硬盘</span><span>{{ $product->config['disk'] ?? '20G' }}</span></div>
                    <div class="flex justify-between"><span>带宽</span><span>{{ $product->config['bandwidth'] ?? '20M' }}</span></div>
                </div>
                <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="anime-btn w-full text-center text-sm" style="padding:10px 20px">立即购买 →</a>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="anime-btn-soft">查看全部产品 →</a>
        </div>
    </div>
</section>

{{-- ═══════════════ 三步开始 ═══════════════ --}}
<section class="py-16" style="background:rgba(255,255,255,.5)">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold section-title mb-3">三步开始你的云之旅</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="anime-card p-8 text-center reveal">
                <div class="text-6xl font-bold mb-4" style="color:#FF9EC4;font-family:'ZCOOL KuaiLe'">01</div>
                <h3 class="font-bold text-lg mb-2">注册账号</h3>
                <p class="text-sm" style="color:#7A7A9A">1 分钟完成注册，无需繁琐流程</p>
            </div>
            <div class="anime-card p-8 text-center reveal">
                <div class="text-6xl font-bold mb-4" style="color:#A8D8FF;font-family:'ZCOOL KuaiLe'">02</div>
                <h3 class="font-bold text-lg mb-2">选购产品</h3>
                <p class="text-sm" style="color:#7A7A9A">选择适合的套餐，加入购物车结算</p>
            </div>
            <div class="anime-card p-8 text-center reveal">
                <div class="text-6xl font-bold mb-4" style="color:#B39DDB;font-family:'ZCOOL KuaiLe'">03</div>
                <h3 class="font-bold text-lg mb-2">自动开通</h3>
                <p class="text-sm" style="color:#7A7A9A">付款后 60 秒自动开通，无需等待</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ 客户评价 ═══════════════ --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <h2 class="text-4xl font-bold section-title mb-3">他们这样说</h2>
            <p class="text-sm" style="color:#9CA3AF">来自 12000+ 用户的真实评价 🌸</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="review-card reveal">
                <div class="flex items-center gap-3 mb-4">
                    <div class="avatar">🐱</div>
                    <div>
                        <div class="font-semibold">小猫爱吃鱼</div>
                        <div class="text-xs" style="color:#9CA3AF">VIP 会员 · 2 年用户</div>
                    </div>
                </div>
                <div class="text-yellow-400 mb-3 text-sm">★★★★★</div>
                <p class="text-sm" style="color:#7A7A9A">从朋友那边知道的，樱花云的 CN2 速度真的快，客服小姐姐也很贴心，值得推荐！</p>
            </div>
            <div class="review-card reveal" style="animation-delay:.15s">
                <div class="flex items-center gap-3 mb-4">
                    <div class="avatar">🌸</div>
                    <div>
                        <div class="font-semibold">樱花飞舞</div>
                        <div class="text-xs" style="color:#9CA3AF">金牌代理 · 1 年用户</div>
                    </div>
                </div>
                <div class="text-yellow-400 mb-3 text-sm">★★★★★</div>
                <p class="text-sm" style="color:#7A7A9A">开通只要 60 秒，价格还比大厂便宜一倍。二次元主题深得我心，稳定性和性价比都很高。</p>
            </div>
            <div class="review-card reveal" style="animation-delay:.3s">
                <div class="flex items-center gap-3 mb-4">
                    <div class="avatar">⭐</div>
                    <div>
                        <div class="font-semibold">星空下的猫</div>
                        <div class="text-xs" style="color:#9CA3AF">钻石会员 · 3 年用户</div>
                    </div>
                </div>
                <div class="text-yellow-400 mb-3 text-sm">★★★★★</div>
                <p class="text-sm" style="color:#7A7A9A">用过好几家的香港节点，还是樱花云稳定。工单响应很快，遇到问题 2 小时就解决了。</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ FAQ ═══════════════ --}}
{{-- FAQ --}}
<section class="py-20" style="background:linear-gradient(135deg, rgba(255,245,250,.6), rgba(240,245,255,.6))">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-3" style="color:#B39DDB;font-family:'ZCOOL KuaiLe'">常见问题</h2>
        <p class="text-center text-sm text-gray-500 mb-10">有任何疑问？先看看这里 🌸</p>

        <div class="space-y-4">
            @foreach([
                ['❓', '如何购买云产品？', '注册账号后，在产品页选择配置，点击「立即购买」或「加入购物车」，支付成功后系统会自动开通。'],
                ['⚡', '多久能开通？', '大部分产品实时开通，一般 1-3 分钟内完成。如遇高峰时段或特殊配置，可能需要 10-30 分钟。'],
                ['💴', '支持哪些付款方式？', '目前支持余额支付、支付宝、微信支付。充值余额后可享受更多优惠。'],
                ['↩️', '可以退款吗？', '购买后 24 小时内如未开通可申请全额退款。已开通服务按剩余时长比例退款。'],
                ['🔒', '数据安全吗？', '我们采用企业级加密存储，所有客户数据与服务器凭据均加密保存。'],
                ['🎀', '怎么联系客服？', '7×24 在线客服。登录后可在控制台提交工单，或通过页脚的 QQ / 微信联系我们。平均响应时间 < 2 小时。'],
            ] as $i => $faq)
            <details class="faq-card group" style="background:rgba(255,255,255,.7);border:2px solid rgba(255,158,196,.25);border-radius:16px;transition:all .3s">
                <summary class="flex items-center justify-between px-6 py-4 cursor-pointer list-none">
                    <span class="font-semibold" style="color:#4A4A6A">
                        <span class="mr-2">{{ $faq[0] }}</span>{{ $faq[1] }}
                    </span>
                    <span class="faq-toggle text-2xl transition-transform duration-300" style="color:#FF9EC4;font-weight:300">+</span>
                </summary>
                <div class="px-6 pb-4 text-sm" style="color:#7A7A9A">{{ $faq[2] }}</div>
            </details>
            @endforeach
        </div>
    </div>
</section>

<style>
.faq-card[open] { border-color:rgba(255,158,196,.6)!important; box-shadow:0 8px 24px rgba(255,158,196,.15); }
.faq-card[open] .faq-toggle { transform:rotate(45deg); }
.faq-card summary::-webkit-details-marker { display:none; }
.faq-card summary { list-style:none; }
</style>
{{-- ═══════════════ CTA ═══════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg, #FF9EC4 0%, #B39DDB 100%)">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-white">
        <div>
            <div class="text-4xl font-bold mb-2" style="font-family:'ZCOOL KuaiLe'">🌸 准备好开始了吗？</div>
            <div class="text-sm opacity-90">3 分钟注册 · 60 秒开通 · 五元起售 · 随时可退</div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('register') }}" class="px-8 py-3 rounded-full font-semibold" style="background:#fff;color:#FF9EC4">✨ 注册会员</a>
            <a href="{{ route('login') }}" class="px-8 py-3 rounded-full font-semibold" style="border:2px solid #fff;color:#fff">💗 登录用户</a>
        </div>
    </div>
</section>

{{-- ═══════════════ 底部 ICP + 联系方式 ═══════════════ --}}
@include('components.site-footer')

{{-- ═══════════════ 粒子背景脚本 ═══════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('particles-canvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');

    function resize() {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    var particles = [];
    for (var i = 0; i < 60; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            vx: (Math.random() - .5) * .7,
            vy: (Math.random() - .5) * .7,
            r: Math.random() * 2.5 + 1
        });
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'rgba(255,158,196,.6)';
        particles.forEach(function(p) {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.vy *= -1;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fill();
        });

        for (var i = 0; i < particles.length; i++) {
            for (var j = i + 1; j < particles.length; j++) {
                var dx = particles[i].x - particles[j].x;
                var dy = particles[i].y - particles[j].y;
                var d = Math.sqrt(dx * dx + dy * dy);
                if (d < 130) {
                    ctx.strokeStyle = 'rgba(255,158,196,' + (1 - d / 130) * .35 + ')';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(draw);
    }
    draw();
});
</script>


<!-- 二次元交互增强 -->
<script>
(function() {
    // 1. 鼠标跟随星星
    var lastMove = 0;
    document.addEventListener("mousemove", function(e) {
        var now = Date.now();
        if (now - lastMove < 100) return;
        lastMove = now;
        var star = document.createElement("div");
        star.className = "cursor-star";
        star.textContent = Math.random() > .5 ? "⭐" : "🌸";
        star.style.left = e.clientX + "px";
        star.style.top = e.clientY + "px";
        document.body.appendChild(star);
        setTimeout(function() { star.remove(); }, 800);
    });

    // 2. 滚动淡入
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("in");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll(".reveal").forEach(function(el) {
        observer.observe(el);
    });

    // 3. 数字滚动
    var numObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (!entry.isIntersecting) return;
            var el = entry.target;
            var target = parseFloat(el.dataset.target || el.textContent);
            if (isNaN(target)) return;
            var current = 0;
            var step = target / 60;
            var timer = setInterval(function() {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(current);
            }, 20);
            numObserver.unobserve(el);
        });
    }, { threshold: 0.5 });
    document.querySelectorAll(".stat-num").forEach(function(el) {
        var txt = el.textContent.replace(/[^0-9.]/g, "");
        if (txt) el.dataset.target = parseFloat(txt);
    });
})();
</script>

<script>
// 滚动淡入效果
(function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('section, .anime-card').forEach(function(el) {
        el.classList.add('reveal');
        observer.observe(el);
    });
})();

// 数字滚动动画
(function() {
    function animateNumber(el) {
        var text = el.textContent;
        var match = text.match(/^([\d.]+)/);
        if (!match) return;
        var target = parseFloat(match[1]);
        var suffix = text.replace(match[1], '');
        var start = 0;
        var duration = 1500;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var current = Math.floor(start + (target - start) * progress);
            el.textContent = current + suffix;
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = text;
        }
        requestAnimationFrame(step);
    }

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                entry.target.dataset.animated = '1';
                animateNumber(entry.target);
            }
        });
    });

    setTimeout(function() {
        document.querySelectorAll('.stat-number').forEach(function(el) {
            observer.observe(el);
        });
    }, 500);
})();
</script>

<style>
/* ═══ FAQ 折叠 ═══ */
.faq-item {
    cursor: pointer;
    transition: all .3s ease;
}
.faq-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(255,158,196,.25);
}
.faq-item .faq-icon {
    transition: transform .3s ease;
    font-weight: bold;
    font-size: 20px;
    color: #FF9EC4;
}
.faq-item.open .faq-icon {
    transform: rotate(45deg);
}
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height .4s ease, padding .3s ease, opacity .3s ease;
    opacity: 0;
    padding: 0 24px;
    color: #5A4A6A;
    font-size: 14px;
    line-height: 1.7;
}
.faq-item.open .faq-answer {
    max-height: 300px;
    padding: 16px 24px 24px;
    opacity: 1;
}
</style>

<script>
(function() {
    // 找所有 FAQ 项：包含 "？" 的卡片，且不是整页
    function initFAQ() {
        var allCards = document.querySelectorAll('.anime-card, [class*="card"]');
        var faqCards = [];

        allCards.forEach(function(card) {
            var text = (card.textContent || '').trim();
            if (text.length > 300) return;
            if (!/[？?]/.test(text)) return;
            // 排除按钮/链接
            if (card.querySelector('button[type=submit], .anime-btn')) return;
            faqCards.push(card);
        });

        faqCards.forEach(function(card) {
            if (card.classList.contains('faq-item')) return;
            card.classList.add('faq-item');

            // 找 + 号元素，标记为 icon
            var plus = null;
            card.querySelectorAll('div, span').forEach(function(el) {
                if (el.children.length === 0 && /^[+＋]/.test(el.textContent.trim())) {
                    plus = el;
                }
            });
            if (plus) plus.classList.add('faq-icon');

            // 找或创建答案容器
            var answer = card.querySelector('.faq-answer');
            if (!answer) {
                answer = document.createElement('div');
                answer.className = 'faq-answer';
                answer.innerHTML = '💡 客服正在完善中，请联系在线客服获取更多帮助。';
                card.appendChild(answer);
            }

            // 点击切换
            card.addEventListener('click', function(e) {
                // 防止按钮/链接触发
                if (e.target.closest('a, button[type=submit]')) return;
                card.classList.toggle('open');
            });
        });

        console.log('FAQ 初始化：' + faqCards.length + ' 项');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFAQ);
    } else {
        initFAQ();
    }
})();
</script>
</body>
</html>
