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
body{
  font-family:'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;
  background:linear-gradient(135deg,#FFE5F0 0%,#E8F0FF 50%,#FFF0F5 100%);
  min-height:100vh;
  margin:0;
  color:#4A4A6A;
}
.page-wrap{
  min-height:calc(100vh - 120px);
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  padding:40px 16px;
}
.guest-card{
  background:rgba(255,255,255,.92);
  backdrop-filter:blur(16px);
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
.petal{
  position:fixed;top:-10px;color:#FFB6D5;font-size:16px;pointer-events:none;
  animation:fall linear infinite;z-index:1;
}
@keyframes fall{
  0%{transform:translateY(-10px) rotate(0);opacity:0}
  10%{opacity:.7}
  100%{transform:translateY(105vh) rotate(360deg);opacity:0}
}
</style>
@include("components.theme-vars")
</head>
<body>
<div class="fixed top-4 right-4 z-50">@include("components.theme-switcher")</div>
<div class="petal" style="left:10%;animation-duration:12s">🌸</div>
<div class="fixed top-4 right-4 z-50">@include("components.theme-switcher")</div>
<div class="petal" style="left:30%;animation-duration:15s;animation-delay:2s">🌸</div>
<div class="fixed top-4 right-4 z-50">@include("components.theme-switcher")</div>
<div class="petal" style="left:50%;animation-duration:13s;animation-delay:1s">🌸</div>
<div class="fixed top-4 right-4 z-50">@include("components.theme-switcher")</div>
<div class="petal" style="left:70%;animation-duration:14s;animation-delay:3s">🌸</div>
<div class="fixed top-4 right-4 z-50">@include("components.theme-switcher")</div>
<div class="petal" style="left:90%;animation-duration:16s;animation-delay:4s">🌸</div>

{{-- 主内容区（flex 居中） --}}
<div class="page-wrap">
    <div class="guest-card">
        <a href="/" class="block text-center mb-6">
            <div class="text-3xl mb-2">🌸</div>
            <div class="text-2xl font-bold" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">樱花云</div>
            <div class="text-xs mt-1" style="color:#B39DDB">二次元专属 IDC 平台</div>
        </a>
        {{ $slot }}
    </div>
</div>

{{-- Footer（独立于 flex 容器外，在页面底部） --}}
@include('components.site-footer')

</body>
</html>
