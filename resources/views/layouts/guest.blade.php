<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', '樱花云') }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/anime-visual.css">
<style>
body{
    font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;
    background:linear-gradient(135deg,#FFE5F0 0%,#E8F0FF 50%,#FFF0F5 100%);
    min-height:100vh;
    margin:0;
    color:#4A4A6A;
    position:relative;
    overflow-x:hidden;
}
.guest-wrap{
    min-height:100vh;
    display:grid;
    grid-template-columns: 1fr 1fr;
    align-items:center;
    justify-items:center;
    padding:40px 32px;
    gap:40px;
    position:relative;
    z-index:2;
}
@media (max-width: 900px) {
    .guest-wrap { grid-template-columns: 1fr; }
    .guest-left { display:none; }
}
.guest-card{
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(24px);
    border:2px solid rgba(255,158,196,.35);
    border-radius:28px;
    box-shadow:0 20px 60px rgba(255,158,196,.25);
    padding:40px;
    width:100%;
    max-width:420px;
    position:relative;
}
.guest-card::before{
    content:'🌸';
    position:absolute;
    top:-20px;left:50%;
    transform:translateX(-50%);
    font-size:36px;
    background:#fff;
    padding:0 16px;
    border-radius:50%;
    box-shadow:0 4px 12px rgba(255,158,196,.3);
}
input[type=text],input[type=email],input[type=password]{
    width:100%;
    padding:12px 18px;
    border:2px solid #FFD1E8;
    border-radius:9999px;
    background:rgba(255,245,250,.7);
    outline:none;
    transition:all .3s;
    font-size:14px;
    color:#4A4A6A;
}
input:focus{
    border-color:#FF9EC4;
    box-shadow:0 0 0 4px rgba(255,158,196,.15);
}
.anime-btn{
    background:linear-gradient(135deg,#FF9EC4,#B39DDB);
    color:#fff;
    border-radius:9999px;
    padding:12px 32px;
    font-weight:600;
    box-shadow:0 4px 15px rgba(255,158,196,.4);
    border:none;
    cursor:pointer;
    width:100%;
    transition:all .3s;
}
.anime-btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,158,196,.6)}
.petal{
    position:fixed;top:-10px;color:#FFB6D5;font-size:16px;pointer-events:none;
    animation:fall linear infinite;z-index:1;opacity:.7;
}
@keyframes fall{
    0%{transform:translateY(-10px) rotate(0);opacity:0}
    10%{opacity:.7}
    100%{transform:translateY(105vh) rotate(360deg);opacity:0}
}
.guest-illu{
    max-width: 480px;
    width: 100%;
    filter: drop-shadow(0 30px 60px rgba(255,158,196,.3));
    animation: float-illu 6s ease-in-out infinite;
}
</style>
</head>
<body>
<div class="petal" style="left:10%;animation-duration:12s">🌸</div>
<div class="petal" style="left:30%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="petal" style="left:50%;animation-duration:13s;animation-delay:1s">🌸</div>
<div class="petal" style="left:70%;animation-duration:14s;animation-delay:3s">🌸</div>
<div class="petal" style="left:90%;animation-duration:16s;animation-delay:4s">🌸</div>

<div class="guest-wrap">
    {{-- 左侧插画 --}}
    <div class="guest-left">
        <a href="/" class="block text-center mb-8">
            <svg class="guest-illu" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="sky2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#FFE5F0" />
                        <stop offset="100%" style="stop-color:#E8F0FF" />
                    </linearGradient>
                    <linearGradient id="hair2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#FF9EC4" />
                        <stop offset="100%" style="stop-color:#B39DDB" />
                    </linearGradient>
                    <linearGradient id="dress2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#A8D8FF" />
                        <stop offset="100%" style="stop-color:#7AB8E8" />
                    </linearGradient>
                </defs>

                <circle cx="200" cy="200" r="180" fill="url(#sky2)" opacity=".4"/>

                <path d="M100,200 Q80,150 120,120 Q180,80 240,120 Q290,150 280,200 Q290,280 200,320 Q110,280 100,200 Z" fill="url(#hair2)"/>

                <ellipse cx="200" cy="210" rx="60" ry="70" fill="#FFE5D0"/>

                <ellipse cx="170" cy="215" rx="8" ry="10" fill="#4A4A6A"/>
                <ellipse cx="230" cy="215" rx="8" ry="10" fill="#4A4A6A"/>
                <ellipse cx="170" cy="213" rx="3" ry="3" fill="#fff"/>
                <ellipse cx="230" cy="213" rx="3" ry="3" fill="#fff"/>

                <path d="M185,235 Q200,250 215,235" stroke="#FF6B9E" stroke-width="2" fill="none" stroke-linecap="round"/>

                <ellipse cx="155" cy="242" rx="12" ry="7" fill="#FFB6D5" opacity=".6"/>
                <ellipse cx="245" cy="242" rx="12" ry="7" fill="#FFB6D5" opacity=".6"/>

                <path d="M140,280 Q200,260 260,280 L280,360 Q200,380 120,360 Z" fill="url(#dress2)"/>

                <text x="60" y="80" font-size="24" opacity=".7">🌸</text>
                <text x="320" y="120" font-size="20" opacity=".7">🌸</text>
                <text x="340" y="280" font-size="22" opacity=".7">🌸</text>
                <text x="50" y="320" font-size="18" opacity=".7">🌸</text>
                <text x="200" y="80" font-size="28" opacity=".6">✨</text>
                <circle cx="90" cy="150" r="3" fill="#FFD700" opacity=".6"/>
                <circle cx="330" cy="180" r="4" fill="#FFD700" opacity=".6"/>
            </svg>
        </a>
        <div class="text-center">
            <div class="text-3xl font-bold gradient-title" style="font-family:ZCOOL KuaiLe">樱花云</div>
            <div class="text-sm text-gray-500 mt-2">让 IDC 管理也能如此可爱 🌸</div>
        </div>
    </div>

    {{-- 右侧表单 --}}
    <div class="guest-card">
        <div class="text-center mb-6 md:hidden">
            <div class="text-2xl font-bold" style="font-family:ZCOOL KuaiLe;color:#FF9EC4">🌸 樱花云</div>
        </div>
        {{ $slot }}
    </div>
</div>

<script src="/js/anime-visual.js"></script>
</body>
</html>
