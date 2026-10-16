<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', '樱花云') }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --sakura:#FF9EC4;
    --sky:#A8D8FF;
    --purple:#B39DDB;
    --text:#4A4A6A;
}
* { box-sizing: border-box; }
body{
    font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;
    margin:0;
    min-height:100vh;
    color:var(--text);
    background:linear-gradient(135deg,#FFE5F0 0%,#E8F0FF 50%,#FFF0F5 100%);
    overflow-x:hidden;
    position:relative;
}

/* 全屏居中容器 */
.login-wrap{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 16px;
    position:relative;
    z-index:10;
}

/* 登录卡片 */
.login-card{
    background:rgba(255,255,255,.94);
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
    border:2px solid rgba(255,158,196,.4);
    border-radius:28px;
    box-shadow:
        0 20px 60px rgba(255,158,196,.28),
        inset 0 1px 0 rgba(255,255,255,1);
    padding:44px 40px;
    width:100%;
    max-width:440px;
    position:relative;
    animation: cardIn .6s ease-out;
}
@keyframes cardIn {
    from { opacity:0; transform:translateY(20px) scale(.98); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}

/* 卡片顶部樱花装饰 */
.login-card::before{
    content:'🌸';
    position:absolute;
    top:-22px;left:50%;
    transform:translateX(-50%);
    font-size:40px;
    background:#fff;
    padding:0 16px;
    border-radius:50%;
    box-shadow:0 4px 16px rgba(255,158,196,.3);
}

/* 表单输入框美化 */
.login-card input[type=text],
.login-card input[type=email],
.login-card input[type=password]{
    width:100%;
    padding:12px 18px;
    border:2px solid #FFD1E8;
    border-radius:9999px;
    background:rgba(255,245,250,.7);
    outline:none;
    transition:all .3s;
    font-size:14px;
    color:var(--text);
}
.login-card input:focus{
    border-color:#FF9EC4;
    box-shadow:0 0 0 4px rgba(255,158,196,.15);
    background:#fff;
}

/* 卡片内按钮 */
.login-card button[type=submit]{
    width:100%;
    padding:12px 32px;
    background:linear-gradient(135deg,#FF9EC4,#B39DDB);
    color:#fff;
    border:none;
    border-radius:9999px;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    box-shadow:0 6px 20px rgba(255,158,196,.4);
    transition:all .3s;
}
.login-card button[type=submit]:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(255,158,196,.6);
}

/* 卡片内链接 */
.login-card a{
    color:#FF9EC4;
    text-decoration:none;
    font-size:13px;
}
.login-card a:hover{ text-decoration:underline; }

/* 卡片内标签 */
.login-card label{
    font-size:13px;
    color:#5A4A6A;
    font-weight:600;
    margin-bottom:6px;
    display:block;
}

/* 卡片底部 logo 区 */
.login-brand{
    text-align:center;
    margin-bottom:28px;
}
.login-brand .logo-icon{
    font-size:36px;
    margin-bottom:8px;
    display:inline-block;
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%,100% { transform:translateY(0); }
    50%     { transform:translateY(-8px); }
}
.login-brand .logo-name{
    font-size:26px;
    font-weight:800;
    font-family:'ZCOOL KuaiLe',sans-serif;
    color:#FF9EC4;
    letter-spacing:2px;
}
.login-brand .logo-slogan{
    font-size:12px;
    color:#B39DDB;
    margin-top:4px;
    letter-spacing:1px;
}

/* 手机适配 */
@media (max-width: 480px) {
    .login-card { padding:32px 24px; border-radius:24px; }
    .login-wrap { padding:24px 12px; }
    .login-brand .logo-name { font-size:22px; }
}
</style>
</head>
<body>

{{-- 背景轮播 --}}
@include('components.background-slider')

{{-- 弹幕 --}}
@include('components.danmaku')

{{-- 居中登录卡片 --}}
<div class="login-wrap">
    <div class="login-card">

        {{-- Logo 区 --}}
        <div class="login-brand">
            <div class="logo-icon">🌸</div>
            <div class="logo-name">樱花云</div>
            <div class="logo-slogan">二次元专属 IDC 平台</div>
        </div>

        {{-- 表单内容（Breeze 的 $slot） --}}
        {{ $slot }}

    </div>
</div>

</body>
</html>
