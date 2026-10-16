<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>樱花云 · 二次元专属云平台</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root{--sakura:#FF9EC4;--sky:#A8D8FF;--purple:#B39DDB;--text:#4A4A6A}
*{box-sizing:border-box}
body{font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;background:linear-gradient(180deg,#FFF5FA 0%,#F0F5FF 40%,#FFF0F5 100%);color:var(--text);overflow-x:hidden;margin:0;min-height:100vh}

/* 樱花飘落 */
.petal{position:fixed;top:-10px;color:#FFB6D5;font-size:20px;pointer-events:none;animation:fall linear infinite;z-index:1}
@keyframes fall{0%{transform:translateY(-10px) rotate(0);opacity:0}10%{opacity:.8}100%{transform:translateY(105vh) rotate(360deg);opacity:0}}

/* 卡片 */
.anime-card{background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border:2px solid rgba(255,158,196,.3);border-radius:24px;transition:all .3s ease}
.anime-card:hover{border-color:rgba(255,158,196,.6);box-shadow:0 20px 50px rgba(255,158,196,.25);transform:translateY(-6px)}

/* 按钮 */
.anime-btn{background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;border-radius:9999px;padding:14px 36px;font-weight:600;box-shadow:0 6px 20px rgba(255,158,196,.4);border:none;cursor:pointer;transition:all .3s;text-decoration:none;display:inline-block}
.anime-btn:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(255,158,196,.6)}
.anime-btn-soft{background:rgba(255,255,255,.9);color:#FF9EC4;border:2px solid #FF9EC4;border-radius:9999px;padding:12px 34px;font-weight:600;transition:all .3s;text-decoration:none;display:inline-block}
.anime-btn-soft:hover{background:#FF9EC4;color:#fff}

/* 浮动动画 */
.floaty{animation:float 4s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}

/* Hero 区 */
.hero-wrap{position:relative;overflow:hidden;padding:60px 24px}
.hero-wrap #particles-canvas{position:absolute;inset:0;z-index:0;opacity:.7}
.hero-content{position:relative;z-index:2}
.glow-orb{position:absolute;border-radius:50%;filter:blur(60px);opacity:.5;pointer-events:none;z-index:1}
.glow-orb.a{width:300px;height:300px;background:#FF9EC4;top:-80px;left:-80px;animation:float 6s ease-in-out infinite}
.glow-orb.b{width:250px;height:250px;background:#A8D8FF;bottom:-60px;right:10%;animation:float 8s ease-in-out infinite reverse}
.glow-orb.c{width:200px;height:200px;background:#B39DDB;top:30%;right:-60px;animation:float 7s ease-in-out infinite}

.stat-number{font-size:2.5rem;font-weight:800;font-family:'ZCOOL KuaiLe',sans-serif}

/* 导航 */
.nav-anime{background:rgba(255,255,255,.9);backdrop-filter:blur(16px);border-bottom:2px solid rgba(255,158,196,.2);position:sticky;top:0;z-index:50}

/* 浮动客服 */
.floating-btns{position:fixed;right:16px;bottom:80px;display:flex;flex-direction:column;gap:10px;z-index:40}

@media (max-width:768px){
    .hero-wrap{padding:40px 16px}
    .stat-number{font-size:1.8rem}
}
</style>
</head>
<body>

{{-- 樱花飘落 --}}
<div class="petal" style="left:5%;animation-duration:14s">🌸</div>
<div class="petal" style="left:20%;animation-duration:12s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:16s;animation-delay:1s">🌸</div>
<div class="petal" style="left:60%;animation-duration:13s;animation-delay:3s">🌸</div>
<div class="petal" style="left:80%;animation-duration:15s;animation-delay:4s">🌸</div>
<div class="petal" style="left:95%;animation-duration:11s;animation-delay:5s">🌸</div>

{{-- 导航 --}}
<nav class="nav-anime">
<div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
    <a href="/" class="flex items-center gap-2">
        <span class="text-2xl">🌸</span>
        <span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
    </a>
    <div class="hidden md:flex items-center gap-6 text-sm font-semibold">
        <a href="#products" class="hover:text-pink-500 transition">🎀 产品</a>
        <a href="/announcements" class="hover:text-pink-500 transition">📢 公告</a>
        <a href="/kb" class="hover:text-pink-500 transition">📖 帮助</a>
    </div>
    <div class="flex items-center gap-3 text-sm">
        @auth
            <a href="{{ route('orders.index') }}" class="anime-btn-soft text-xs" style="padding:8px 20px">控制台</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                <button type="submit" class="anime-btn text-xs" style="padding:8px 20px">退出</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="anime-btn-soft text-xs" style="padding:8px 20px">💗 登录</a>
            <a href="{{ route('register') }}" class="anime-btn text-xs" style="padding:8px 20px">✨ 注册</a>
        @endauth
    </div>
</div>
</nav>

{{-- Hero --}}
<section class="hero-wrap" style="background:linear-gradient(135deg, rgba(255,245,250,.9), rgba(240,245,255,.9))">
    <canvas id="particles-canvas"></canvas>
    <div class="glow-orb a"></div>
    <div class="glow-orb b"></div>
    <div class="glow-orb c"></div>

    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center hero-content">
        {{-- 左侧文字 --}}
        <div>
            <div class="inline-block px-4 py-1 rounded-full mb-6 text-sm font-semibold" style="background:rgba(255,158,196,.15);color:#FF6B9E">
                ✨ 二次元专属云平台
            </div>
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6" style="font-family:'ZCOOL KuaiLe'">
                <span style="color:#FF9EC4">樱花云</span><br>
                <span style="color:#B39DDB">萌系 VPS 空间</span>
            </h1>
            <p class="text-lg mb-8" style="color:#7A7A9A">五元起 · 免备案 · 二次元专属主题 · 7×24 萌妹客服 🎀</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ auth()->check() ? route('orders.index') : route('register') }}" class="anime-btn">🌸 立即体验 →</a>
                <a href="#products" class="anime-btn-soft">了解更多</a>
            </div>

            {{-- 数据统计 --}}
            <div class="grid grid-cols-3 gap-6 mt-10">
                <div class="text-center">
                    <div class="stat-number" style="color:#FF9EC4"><span class="data-count" data-count="12000">0</span><span class="text-lg">+</span></div>
                    <div class="text-xs text-gray-500 mt-1">🌸 云客户</div>
                </div>
                <div class="text-center">
                    <div class="stat-number" style="color:#A8D8FF"><span class="data-count" data-count="99.9">0</span><span class="text-lg">%</span></div>
                    <div class="text-xs text-gray-500 mt-1">⚡ 在线率</div>
                </div>
                <div class="text-center">
                    <div class="stat-number" style="color:#B39DDB"><span class="data-count" data-count="50">0</span><span class="text-lg">+</span></div>
                    <div class="text-xs text-gray-500 mt-1">💎 全球节点</div>
                </div>
            </div>
        </div>

        {{-- 右侧二次元插画 --}}
        <div class="floaty" style="display:flex;align-items:center;justify-content:center;min-height:400px">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:380px;height:auto;filter:drop-shadow(0 20px 40px rgba(255,158,196,.3))">
                <circle cx="200" cy="200" r="160" fill="none" stroke="rgba(255,158,196,.3)" stroke-width="2"/>
                <circle cx="200" cy="200" r="130" fill="none" stroke="rgba(168,216,255,.3)" stroke-width="1.5" stroke-dasharray="6 6"/>

                <ellipse cx="80" cy="100" rx="14" ry="10" fill="#FFB6D5" transform="rotate(-30 80 100)"/>
                <ellipse cx="330" cy="140" rx="12" ry="8" fill="#FFD1E8" transform="rotate(20 330 140)"/>
                <ellipse cx="300" cy="320" rx="10" ry="7" fill="#FFB6D5" transform="rotate(-45 300 320)"/>

                <rect x="140" y="160" width="120" height="40" rx="8" fill="#A8D8FF" stroke="#7AB8E8" stroke-width="2"/>
                <circle cx="160" cy="180" r="4" fill="#fff"/>
                <line x1="180" y1="180" x2="240" y2="180" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                <rect x="140" y="210" width="120" height="40" rx="8" fill="#FF9EC4" stroke="#FF6B9E" stroke-width="2"/>
                <circle cx="160" cy="230" r="4" fill="#fff"/>
                <line x1="180" y1="230" x2="240" y2="230" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                <rect x="140" y="260" width="120" height="40" rx="8" fill="#B39DDB" stroke="#9B86C8" stroke-width="2"/>
                <circle cx="160" cy="280" r="4" fill="#fff"/>
                <line x1="180" y1="280" x2="240" y2="280" stroke="#fff" stroke-width="2" stroke-linecap="round"/>

                <g transform="translate(200, 80)">
                    <ellipse cx="0" cy="0" rx="40" ry="20" fill="rgba(255,255,255,.9)"/>
                    <ellipse cx="-20" cy="5" rx="20" ry="15" fill="rgba(255,255,255,.9)"/>
                    <ellipse cx="20" cy="5" rx="25" ry="18" fill="rgba(255,255,255,.9)"/>
                </g>
            </svg>
        </div>
    </div>
</section>

{{-- 四大特色 --}}
<section class="py-12 border-t-2 border-pink-100" style="background:rgba(255,255,255,.5)">
<div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
    <div class="text-center"><div class="text-4xl mb-2">🌸</div><div class="font-bold">樱花机房</div><div class="text-xs mt-1" style="color:#9CA3AF">多地冗余备份</div></div>
    <div class="text-center"><div class="text-4xl mb-2">⚡</div><div class="font-bold">极速响应</div><div class="text-xs mt-1" style="color:#9CA3AF">CN2 直连</div></div>
    <div class="text-center"><div class="text-4xl mb-2">💎</div><div class="font-bold">超值价格</div><div class="text-xs mt-1" style="color:#9CA3AF">5 元起购</div></div>
    <div class="text-center"><div class="text-4xl mb-2">🎀</div><div class="font-bold">萌妹客服</div><div class="text-xs mt-1" style="color:#9CA3AF">7×24 在线</div></div>
</div>
</section>

{{-- 产品 --}}
<section id="products" class="py-20">
<div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-3" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">我们的云产品</h2>
        <p class="text-sm" style="color:#9CA3AF">每一台都用心呵护 🌸</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        @php
            $homeProducts = \App\Models\Product::where('is_active', true)->take(3)->get();
        @endphp
        @forelse($homeProducts as $product)
        <div class="anime-card p-8 text-center">
            <div class="text-5xl mb-4">🖥️</div>
            <h3 class="text-xl font-bold mb-2" style="color:#FF9EC4">{{ $product->name }}</h3>
            <p class="text-sm mb-4" style="color:#7A7A9A">{{ $product->description ?? '优质云服务' }}</p>
            <div class="text-3xl font-bold mb-6" style="color:#B39DDB">
                ¥{{ $product->price }}<span class="text-sm">/月</span>
            </div>
            <a href="/product/{{ $product->id }}" class="anime-btn text-sm" style="padding:10px 28px">查看详情</a>
        </div>
        @empty
        <div class="col-span-3 anime-card p-12 text-center text-gray-400">
            <div class="text-5xl mb-4">📦</div>
            <div>暂无上架产品</div>
        </div>
        @endforelse
    </div>
    <div class="text-center mt-10">
        <a href="{{ route('orders.index') }}" class="anime-btn-soft">查看全部产品 →</a>
    </div>
</div>
</section>

{{-- CTA --}}
<section class="py-16" style="background:linear-gradient(135deg,#FF9EC4 0%,#B39DDB 100%)">
<div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-white">
    <div>
        <div class="text-2xl font-bold" style="font-family:'ZCOOL KuaiLe'">🌸 现在就加入樱花云</div>
        <div class="text-sm opacity-90 mt-2">二次元专属，萌系体验</div>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('register') }}" class="px-6 py-3 rounded-full font-semibold" style="background:#fff;color:#FF9EC4;text-decoration:none">✨ 注册会员</a>
        <a href="{{ route('login') }}" class="px-6 py-3 rounded-full font-semibold" style="border:2px solid #fff;color:#fff;text-decoration:none">💗 登录用户</a>
    </div>
</div>
</section>

{{-- 浮动客服按钮 --}}
<div class="floating-btns">
    <a href="#" title="客服" style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#FF9EC4,#B39DDB);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;text-decoration:none;box-shadow:0 8px 24px rgba(255,158,196,.4)">💬</a>
    <a href="#" title="帮助" style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#A8D8FF,#7AB8E8);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;text-decoration:none;box-shadow:0 8px 24px rgba(168,216,255,.4)">❓</a>
    <a href="#" title="回到顶部" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;" style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#B39DDB,#9B86C8);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;text-decoration:none;box-shadow:0 8px 24px rgba(179,157,219,.4)">↑</a>
</div>

{{-- footer --}}
@include('components.site-footer')

{{-- 粒子背景 + 数据滚动动画 --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 粒子背景
    var canvas = document.getElementById('particles-canvas');
    if (canvas) {
        var ctx = canvas.getContext('2d');
        function resize() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        }
        resize();
        window.addEventListener('resize', resize);
        var particles = [];
        for (var i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - .5) * .6,
                vy: (Math.random() - .5) * .6,
                r: Math.random() * 2 + 1
            });
        }
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(255,158,196,.6)';
            particles.forEach(function(p) {
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > canvas.width)  p.vx *= -1;
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
                    if (d < 120) {
                        ctx.strokeStyle = 'rgba(255,158,196,' + (1 - d / 120) * .3 + ')';
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
    }

    // 数据数字滚动
    document.querySelectorAll('.data-count').forEach(function(el) {
        var target = parseFloat(el.getAttribute('data-count'));
        var isFloat = target % 1 !== 0;
        var duration = 1500;
        var start = performance.now();
        function update(now) {
            var progress = Math.min((now - start) / duration, 1);
            var current = target * progress;
            el.textContent = isFloat ? current.toFixed(1) : Math.floor(current);
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    });
});
</script>
</body>
</html>
