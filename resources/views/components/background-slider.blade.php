{{-- 背景轮播 + 浮动光晕（自动扫描 public/backgrounds/） --}}
@php
    $bgDir = public_path('backgrounds');
    $bgImages = [];
    if (is_dir($bgDir)) {
        foreach (scandir($bgDir) as $f) {
            if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif'])) {
                $bgImages[] = '/backgrounds/' . $f;
            }
        }
    }
@endphp

<div id="idc-bg-slider" class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">

    @if(count($bgImages) > 0)
        @foreach($bgImages as $i => $url)
        <div class="bg-layer absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
             data-index="{{ $i }}"
             style="background-image:url('{{ $url }}');opacity:{{ $i === 0 ? 1 : 0 }}"></div>
        @endforeach
    @else
        <div class="absolute inset-0" style="background:linear-gradient(135deg,#FFF5FA 0%,#F0F5FF 50%,#FFF0F5 100%)"></div>
    @endif

    {{-- 渐变遮罩 --}}
    <div class="absolute inset-0" style="background:linear-gradient(to bottom,rgba(255,245,250,.4),rgba(255,245,250,.25),rgba(255,245,250,.6))"></div>

    {{-- 浮动光晕 --}}
    <div class="glow-orb-a absolute" style="top:-20%;left:-20%;width:60%;height:60%;border-radius:50%;filter:blur(120px);opacity:.4;background:radial-gradient(circle,#FF9EC4,transparent)"></div>
    <div class="glow-orb-b absolute" style="bottom:-20%;right:-20%;width:60%;height:60%;border-radius:50%;filter:blur(120px);opacity:.4;background:radial-gradient(circle,#A8D8FF,transparent)"></div>
</div>

<style>
@keyframes floatSlow {
    0%,100% { transform:translate(0,0) scale(1); }
    50%     { transform:translate(30px,-30px) scale(1.1); }
}
.glow-orb-a { animation: floatSlow 20s ease-in-out infinite; }
.glow-orb-b { animation: floatSlow 25s ease-in-out infinite reverse; }
body[data-theme="dark"] #idc-bg-slider > div:nth-child(2) {
    background:linear-gradient(to bottom,rgba(10,10,20,.7),rgba(10,10,20,.6),rgba(10,10,20,.8))!important;
}
</style>

<script>
(function() {
    var layers = document.querySelectorAll('#idc-bg-slider .bg-layer');
    if (layers.length < 2) return;

    var idx = 0;
    setInterval(function() {
        layers[idx].style.opacity = '0';
        idx = (idx + 1) % layers.length;
        layers[idx].style.opacity = '1';
    }, 8000);
})();
</script>
