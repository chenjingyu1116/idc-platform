<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>樱花云 · 二次元专属云平台</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root { --sakura:#FF9EC4; --sky:#A8D8FF; --purple:#B39DDB; --text:#4A4A6A; }
body { font-family:'Quicksand','ZCOOL KuaiLe',sans-serif; color:var(--text); margin:0; overflow-x:hidden; }
.anime-card { background:rgba(255,255,255,.85); backdrop-filter:blur(12px); border:2px solid rgba(255,158,196,.3); border-radius:24px; transition:all .3s; }
.anime-card:hover { border-color:rgba(255,158,196,.6); box-shadow:0 20px 50px rgba(255,158,196,.25); transform:translateY(-6px); }
.anime-btn { background:linear-gradient(135deg,#FF9EC4,#B39DDB); color:#fff; border-radius:9999px; padding:14px 36px; font-weight:600; box-shadow:0 6px 20px rgba(255,158,196,.4); border:none; cursor:pointer; transition:all .3s; display:inline-block; text-decoration:none; }
.anime-btn:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(255,158,196,.6); }
.anime-btn-soft { background:rgba(255,255,255,.9); color:#FF9EC4; border:2px solid #FF9EC4; border-radius:9999px; padding:12px 34px; font-weight:600; transition:all .3s; display:inline-block; text-decoration:none; }
.anime-btn-soft:hover { background:#FF9EC4; color:#fff; }
.petal { position:fixed; top:-10px; color:#FFB6D5; font-size:20px; pointer-events:none; animation:fall linear infinite; z-index:1; }
@keyframes fall { 0% { transform:translateY(-10px) rotate(0); opacity:0; } 10% { opacity:.8; } 100% { transform:translateY(105vh) rotate(360deg); opacity:0; } }
.floaty { animation:float 4s ease-in-out infinite; }
@keyframes float { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-12px); } }

/* Hero */
.hero-wrap { position:relative; overflow:hidden; border-radius:0; padding:80px 20px; background:linear-gradient(135deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%); }
.hero-wrap #particles-canvas { position:absolute; inset:0; z-index:1; opacity:.7; }
.hero-wrap .hero-content { position:relative; z-index:3; }
.glow-orb { position:absolute; border-radius:50%; filter:blur(70px); opacity:.45; pointer-events:none; z-index:2; }
.glow-orb.a { width:320px; height:320px; background:#FF9EC4; top:-80px; left:-80px; animation:float 6s ease-in-out infinite; }
.glow-orb.b { width:280px; height:280px; background:#A8D8FF; bottom:-80px; right:8%; animation:float 8s ease-in-out infinite reverse; }
.glow-orb.c { width:220px; height:220px; background:#B39DDB; top:25%; right:-60px; animation:float 7s ease-in-out infinite; }
.hero-illustration { position:relative; z-index:3; display:flex; align-items:center; justify-content:center; min-height:420px; }
.hero-illustration svg { width:100%; max-width:400px; height:auto; filter:drop-shadow(0 20px 40px rgba(255,158,196,.35)); }
.stat-number { font-size:2.5rem; font-weight:800; font-family:'ZCOOL KuaiLe',sans-serif; line-height:1; }
@media (max-width: 768px) {
    .hero-wrap { padding:50px 16px; }
    .stat-number { font-size:1.8rem; }
    .hero-illustration { min-height:300px; }
}

/* 滚动淡入 */
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease, transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
</style>
</head>
<body style="background:linear-gradient(180deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%)">

{{-- 樱花飘落 --}}
<div class="petal" style="left:5%;animation-duration:14s">🌸</div>
<div class="petal" style="left:20%;animation-duration:12s;animation-delay:2s">🌸</div>
<div class="petal" style="left:40%;animation-duration:16s;animation-delay:1s">🌸</div>
<div class="petal" style="left:60%;animation-duration:13s;animation-delay:3s">🌸</div>
<div class="petal" style="left:80%;animation-duration:15s;animation-delay:4s">🌸</div>
<div class="petal" style="left:95%;animation-duration:11s;animation-delay:5s">🌸</div>

{{-- 导航栏 --}}
<nav class="sticky top-0 z-50" style="background:rgba(255,255,255,.85);backdrop-filter:blur(16px);border-bottom:2px solid rgba(255,158,196,.2)">
<div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
    <a href="/" class="flex items-center gap-2">
        <span class="text-2xl">🌸</span>
        <span class="text-xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</span>
    </a>
    <div class="hidden md:flex items-center gap-6 text-sm font-semibold">
        <a href="#products" class="hover:text-pink-500 transition">🎀 产品</a>
        <a href="/announcements" class="hover:text-pink-500 transition">📢 公告</a>
        <a href="/kb" class="hover:text-pink-500 transition">📚 帮助</a>
    </div>
    <div class="flex items-center gap-3 text-sm">
        @auth
            <a href="/products" class="anime-btn-soft text-xs">控制台</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                <button type="submit" class="anime-btn text-xs" style="padding:8px 20px">退出</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="anime-btn-soft text-xs">💗 登录</a>
            <a href="{{ route('register') }}" class="anime-btn text-xs" style="padding:8px 20px">✨ 注册</a>
        @endauth
    </div>
</div>
</nav>

{{-- Hero --}}
<section class="hero-wrap">
    <canvas id="particles-canvas"></canvas>
    <div class="glow-orb a"></div>
    <div class="glow-orb b"></div>
    <div class="glow-orb c"></div>

    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center hero-content">
        {{-- 左：文字 --}}
        <div>
            <div class="inline-block px-4 py-1 rounded-full mb-6 text-sm font-semibold" style="background:rgba(255,158,196,.15);color:#FF6B9E">
                ✨ 二次元专属云平台
            </div>
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6" style="font-family:'ZCOOL KuaiLe'">
                <span style="color:#FF9EC4">樱花云</span><br>
                <span style="color:#B39DDB">萌系 VPS 空间</span>
            </h1>
            <p class="text-lg mb-8" style="color:#7A7A9A">五元起 · 免备案 · 二次元专属主题 · 7×24 萌妹客服 🎀</p>
            <div class="flex flex-wrap gap-4 mb-10">
                <a href="/register" class="anime-btn">🌸 立即体验 →</a>
                <a href="#products" class="anime-btn-soft">了解更多</a>
            </div>

            {{-- 数据统计 --}}
            <div class="grid grid-cols-3 gap-4 max-w-md">
                <div class="text-center">
                    <div class="stat-number" style="color:#FF9EC4" data-count="12000">0</div>
                    <div class="text-xs text-gray-500 mt-1">🌸 云客户</div>
                </div>
                <div class="text-center">
                    <div class="stat-number" style="color:#A8D8FF">99.9<span class="text-lg">%</span></div>
                    <div class="text-xs text-gray-500 mt-1">⚡ 在线率</div>
                </div>
                <div class="text-center">
                    <div class="stat-number" style="color:#B39DDB">50<span class="text-lg">+</span></div>
                    <div class="text-xs text-gray-500 mt-1">💎 全球节点</div>
                </div>
            </div>
        </div>

        {{-- 右：二次元插画 --}}
        <div class="hero-illustration floaty">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <!-- 背景圆环 -->
                <circle cx="200" cy="200" r="160" fill="none" stroke="rgba(255,158,196,.3)" stroke-width="2"/>
                <circle cx="200" cy="200" r="130" fill="none" stroke="rgba(168,216,255,.4)" stroke-width="1.5" stroke-dasharray="6 6"/>

                <!-- 光晕 -->
                <circle cx="200" cy="200" r="100" fill="url(#grad1)" opacity=".3"/>

                <!-- 云朵 -->
                <g transform="translate(190, 75)" opacity=".95">
                    <ellipse cx="0" cy="0" rx="42" ry="22" fill="#fff"/>
                    <ellipse cx="-22" cy="6" rx="22" ry="16" fill="#fff"/>
                    <ellipse cx="22" cy="6" rx="26" ry="18" fill="#fff"/>
                </g>

                <!-- 服务器堆叠（从上到下）-->
                <!-- 第一层：粉色 -->
                <rect x="130" y="140" width="140" height="45" rx="10" fill="#FF9EC4" stroke="#FF6B9E" stroke-width="2.5"/>
                <circle cx="155" cy="162" r="5" fill="#fff"/>
                <circle cx="175" cy="162" r="5" fill="#fff"/>
                <line x1="195" y1="162" x2="250" y2="162" stroke="#fff" stroke-width="3" stroke-linecap="round"/>

                <!-- 第二层：蓝色 -->
                <rect x="130" y="195" width="140" height="45" rx="10" fill="#A8D8FF" stroke="#7AB8E8" stroke-width="2.5"/>
                <circle cx="155" cy="217" r="5" fill="#fff"/>
                <circle cx="175" cy="217" r="5" fill="#fff"/>
                <line x1="195" y1="217" x2="250" y2="217" stroke="#fff" stroke-width="3" stroke-linecap="round"/>

                <!-- 第三层：紫色 -->
                <rect x="130" y="250" width="140" height="45" rx="10" fill="#B39DDB" stroke="#9B86C8" stroke-width="2.5"/>
                <circle cx="155" cy="272" r="5" fill="#fff"/>
                <circle cx="175" cy="272" r="5" fill="#fff"/>
                <line x1="195" y1="272" x2="250" y2="272" stroke="#fff" stroke-width="3" stroke-linecap="round"/>

                <!-- 装饰花瓣 -->
                <g opacity=".85">
                    <ellipse cx="80" cy="120" rx="14" ry="10" fill="#FFB6D5" transform="rotate(-30 80 120)"/>
                    <ellipse cx="330" cy="160" rx="12" ry="8" fill="#FFD1E8" transform="rotate(20 330 160)"/>
                    <ellipse cx="310" cy="330" rx="10" ry="7" fill="#FFB6D5" transform="rotate(-45 310 330)"/>
                    <ellipse cx="90" cy="320" rx="11" ry="8" fill="#FFD1E8" transform="rotate(30 90 320)"/>
                </g>

                <!-- 星星 -->
                <text x="100" y="80" font-size="20" opacity=".7">⭐</text>
                <text x="320" y="80" font-size="16" opacity=".7">✨</text>
                <text x="70" y="260" font-size="16" opacity=".7">💎</text>
                <text x="330" y="280" font-size="18" opacity=".7">🌸</text>

                <defs>
                    <radialGradient id="grad1">
                        <stop offset="0%" stop-color="#FF9EC4" stop-opacity=".6"/>
                        <stop offset="100%" stop-color="#FF9EC4" stop-opacity="0"/>
                    </radialGradient>
                </defs>
            </svg>
        </div>
    </div>
</section>

{{-- 四大特色 --}}
<section class="py-16 border-t-2 border-pink-100" style="background:rgba(255,255,255,.5)">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="text-center reveal">
            <div class="text-4xl mb-2">🌸</div>
            <div class="font-bold">樱花机房</div>
            <div class="text-xs mt-1" style="color:#9CA3AF">多地冗余备份</div>
        </div>
        <div class="text-center reveal">
            <div class="text-4xl mb-2">⚡</div>
            <div class="font-bold">极速响应</div>
            <div class="text-xs mt-1" style="color:#9CA3AF">CN2 直连</div>
        </div>
        <div class="text-center reveal">
            <div class="text-4xl mb-2">💎</div>
            <div class="font-bold">超值价格</div>
            <div class="text-xs mt-1" style="color:#9CA3AF">5 元起购</div>
        </div>
        <div class="text-center reveal">
            <div class="text-4xl mb-2">🎀</div>
            <div class="font-bold">萌妹客服</div>
            <div class="text-xs mt-1" style="color:#9CA3AF">7×24 在线</div>
        </div>
    </div>
</section>

{{-- 产品展示 --}}
<section id="products" class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <h2 class="text-4xl font-bold mb-3" style="font-family:'ZCOOL KuaiLe';color:#B39DDB">我们的云产品</h2>
            <p class="text-sm" style="color:#9CA3AF">每一台都用心呵护 🌸</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $homeProducts = \App\Models\Product::where('is_active', true)->take(6)->get();
            @endphp
            @forelse($homeProducts as $p)
            <a href="/product/{{ $p->id }}" class="anime-card p-8 text-center block reveal">
                <div class="text-5xl mb-4">🖥️</div>
                <h3 class="text-xl font-bold mb-2" style="color:#FF9EC4">{{ $p->name }}</h3>
                <p class="text-sm" style="color:#7A7A9A">{{ $p->description ?? '优质云服务' }}</p>
                <div class="text-2xl font-bold mt-4" style="color:#B39DDB">
                    ¥{{ $p->price }}<span class="text-sm">/月起</span>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center text-gray-400 py-8">暂无产品，请先到后台添加</div>
            @endforelse
        </div>
        <div class="text-center mt-10 reveal">
            <a href="/products" class="anime-btn">查看全部产品 →</a>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16" style="background:linear-gradient(135deg,#FF9EC4 0%,#B39DDB 100%)">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-white">
        <div class="reveal">
            <div class="text-2xl font-bold" style="font-family:'ZCOOL KuaiLe'">🌸 现在就加入樱花云</div>
            <div class="text-sm opacity-90 mt-2">二次元专属，萌系体验</div>
        </div>
        <div class="flex gap-4 reveal">
            <a href="/register" class="px-6 py-3 rounded-full font-semibold" style="background:#fff;color:#FF9EC4">✨ 注册会员</a>
            <a href="/login" class="px-6 py-3 rounded-full font-semibold" style="border:2px solid #fff;color:#fff">💗 登录用户</a>
        </div>
    </div>
</section>

{{-- 页脚 --}}
@include('components.site-footer')

{{-- 粒子背景 + 数字动画 + 滚动淡入 --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 粒子
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
        for (var i = 0; i < 60; i++) {
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
                    if (d < 130) {
                        ctx.strokeStyle = 'rgba(255,158,196,' + (1 - d / 130) * .3 + ')';
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

    // 数字滚动
    var countEl = document.querySelector('[data-count]');
    if (countEl) {
        var target = parseInt(countEl.dataset.count);
        var current = 0;
        var step = target / 60;
        var timer = setInterval(function() {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            countEl.textContent = Math.floor(current).toLocaleString();
        }, 25);
    }

    // 滚动淡入
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) e.target.classList.add('visible');
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });
});
</script>

</body>
</html>
