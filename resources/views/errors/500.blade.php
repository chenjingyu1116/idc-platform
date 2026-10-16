<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>500 · 樱花云</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Quicksand','ZCOOL KuaiLe',sans-serif;background:linear-gradient(135deg,#FFF5FA,#F0F5FF,#FFF0F5);min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;color:#4A4A6A}
.petal{position:fixed;top:-10px;color:#FFB6D5;font-size:24px;pointer-events:none;animation:fall linear infinite}
@keyframes fall{0%{transform:translateY(-10px) rotate(0);opacity:0}10%{opacity:.8}100%{transform:translateY(105vh) rotate(360deg);opacity:0}}
.card{background:rgba(255,255,255,.9);backdrop-filter:blur(12px);border:2px solid rgba(255,158,196,.3);border-radius:28px;padding:48px;text-align:center;max-width:480px;box-shadow:0 20px 60px rgba(255,158,196,.2)}
.code{font-size:96px;font-weight:700;background:linear-gradient(135deg,#FF9EC4,#B39DDB);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1}
</style>
</head>
<body>
<div class="petal" style="left:10%;animation-duration:12s">🌸</div>
<div class="petal" style="left:40%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="petal" style="left:70%;animation-duration:14s;animation-delay:1s">🌸</div>
<div class="card">
<div class="code">500</div>
<div class="text-2xl font-bold mt-4" style="font-family:'ZCOOL KuaiLe'">
@if(500 == 403) 🌸 这里不欢迎你哦
@elseif(500 == 404) 🌸 找不到这个页面
@elseif(500 == 500) 🌸 服务器有点小情绪
@else 🌸 服务器正在休息
@endif
</div>
<p class="text-gray-500 mt-4 mb-6">
@if(500 == 403) 你的账号没有权限访问这个页面
@elseif(500 == 404) 可能是链接错了，或页面已经搬家
@elseif(500 == 500) 我们正在紧急修复，请稍后再试
@else 我们正在维护，稍后就回来
@endif
</p>
<a href="/" class="inline-block px-6 py-3 rounded-full text-white font-semibold" style="background:linear-gradient(135deg,#FF9EC4,#B39DDB)">🌸 回到首页</a>
</div>
</body>
</html>
