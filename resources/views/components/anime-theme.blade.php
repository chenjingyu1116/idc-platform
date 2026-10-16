{{-- ═══════════════ 二次元主题增强包 V3 ═══════════════ --}}
<style>
:root {
    --sakura:     #FF9EC4;
    --sakura-2:   #FFB6D5;
    --sky:        #A8D8FF;
    --purple:     #B39DDB;
    --cream:      #FFE5B4;
    --text-main:  #4A4A6A;
    --text-muted: #9CA3AF;
    --bg-grad:    linear-gradient(135deg, #FFF5FA 0%, #F0F5FF 50%, #FFF0F5 100%);
    --card-bg:    rgba(255,255,255,.88);
    --card-border: rgba(255,158,196,.3);
    --shadow-soft: 0 8px 32px rgba(255,158,196,.15);
    --shadow-hover: 0 12px 40px rgba(255,158,196,.3);
}

/* 全站背景：樱花渐变 + 星点 */
body.anime-theme {
    background: var(--bg-grad);
    position: relative;
    min-height: 100vh;
    color: var(--text-main);
    font-family: 'Quicksand','ZCOOL KuaiLe',system-ui,sans-serif;
}
body.anime-theme::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
        radial-gradient(2px 2px at 20% 30%, rgba(255,209,232,.8) 50%, transparent),
        radial-gradient(2px 2px at 60% 70%, rgba(255,229,180,.8) 50%, transparent),
        radial-gradient(2px 2px at 80% 20%, rgba(212,197,255,.8) 50%, transparent),
        radial-gradient(2px 2px at 30% 80%, rgba(255,209,232,.8) 50%, transparent),
        radial-gradient(2px 2px at 90% 60%, rgba(255,229,180,.8) 50%, transparent);
    background-size: 300px 300px;
    animation: anime-sparkle 8s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
    opacity: .7;
}
@keyframes anime-sparkle {
    0%, 100% { opacity: .5; }
    50%      { opacity: .9; }
}

/* 樱花飘落 */
.sakura-petal {
    position: fixed;
    top: -20px;
    color: #FFB6D5;
    font-size: 18px;
    pointer-events: none;
    animation: sakura-fall linear infinite;
    z-index: 1;
    opacity: .75;
    filter: drop-shadow(0 0 4px rgba(255,158,196,.5));
}
@keyframes sakura-fall {
    0%   { transform: translateY(-20px) rotate(0deg); opacity: 0; }
    10%  { opacity: .75; }
    100% { transform: translateY(105vh) rotate(720deg); opacity: 0; }
}

/* 卡片：二次元发光 */
.anime-card {
    background: var(--card-bg);
    backdrop-filter: blur(14px);
    border: 2px solid var(--card-border);
    border-radius: 22px;
    box-shadow: var(--shadow-soft);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    position: relative;
    overflow: hidden;
}
.anime-card::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,.4) 50%, transparent 60%);
    transform: translateX(-100%);
    transition: transform .8s;
    pointer-events: none;
}
.anime-card:hover {
    border-color: rgba(255,158,196,.7);
    box-shadow: var(--shadow-hover);
    transform: translateY(-4px);
}
.anime-card:hover::before {
    transform: translateX(100%);
}

/* 按钮：粉紫渐变 */
.anime-btn {
    background: linear-gradient(135deg, #FF9EC4 0%, #FFB6D5 50%, #A8D8FF 100%);
    background-size: 200% 200%;
    color: #fff;
    border-radius: 9999px;
    padding: 10px 28px;
    font-weight: 600;
    box-shadow: 0 6px 20px rgba(255,158,196,.4);
    border: none;
    cursor: pointer;
    transition: all .3s;
    animation: gradient-shift 3s ease infinite;
}
.anime-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255,158,196,.6);
}
@keyframes gradient-shift {
    0%,100% { background-position: 0% 50%; }
    50%     { background-position: 100% 50%; }
}

.anime-btn-soft {
    background: rgba(255,255,255,.9);
    color: #FF9EC4;
    border: 2px solid #FF9EC4;
    border-radius: 9999px;
    padding: 8px 24px;
    font-weight: 600;
    transition: all .3s;
}
.anime-btn-soft:hover {
    background: #FF9EC4;
    color: #fff;
    transform: translateY(-2px);
}

/* 表格：淡粉条纹 */
.anime-card table tbody tr:hover {
    background: rgba(255,158,196,.06);
}
.anime-card table thead {
    background: rgba(255,158,196,.08);
}
.anime-card table th {
    color: #FF9EC4 !important;
    letter-spacing: .05em;
}

/* 输入框：圆角 + 粉边 + focus 光晕 */
.anime-input,
body.anime-theme input[type=text],
body.anime-theme input[type=email],
body.anime-theme input[type=password],
body.anime-theme input[type=number],
body.anime-theme textarea,
body.anime-theme select {
    border-radius: 16px;
    border: 2px solid #FFD1E8;
    background: rgba(255,245,250,.6);
    outline: none;
    transition: all .25s;
}
body.anime-theme input:focus,
body.anime-theme textarea:focus,
body.anime-theme select:focus {
    border-color: #FF9EC4;
    box-shadow: 0 0 0 4px rgba(255,158,196,.15);
    background: rgba(255,255,255,.95);
}

/* 导航栏：玻璃质感 */
.nav-anime {
    background: rgba(255,255,255,.85) !important;
    backdrop-filter: blur(18px);
    border-bottom: 2px solid rgba(255,158,196,.25) !important;
    box-shadow: 0 4px 20px rgba(255,158,196,.08);
}

/* 顶部加载进度条 */
.anime-progress {
    position: fixed;
    top: 0; left: 0;
    height: 3px;
    width: 0;
    background: linear-gradient(90deg, #FF9EC4, #B39DDB, #A8D8FF);
    z-index: 9999;
    transition: width .3s, opacity .5s;
    border-radius: 0 2px 2px 0;
    box-shadow: 0 0 10px rgba(255,158,196,.6);
}

/* 页脚 */
.anime-footer {
    border-top: 2px solid rgba(255,158,196,.2);
    background: rgba(255,255,255,.6);
    color: var(--text-muted);
}

/* 徽章 */
.anime-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
}
.anime-badge-pink   { background: rgba(255,158,196,.2); color: #FF6B9E; }
.anime-badge-green  { background: rgba(127,216,190,.25); color: #2E7D5C; }
.anime-badge-yellow { background: rgba(255,229,180,.4); color: #B8860B; }
.anime-badge-gray   { background: rgba(200,200,200,.3); color: #666; }

/* 深色模式（data-theme=dark） */
body.anime-theme[data-theme=dark] {
    background: linear-gradient(135deg, #1a1420 0%, #1a1a2e 50%, #201825 100%);
    color: #E0E0F0;
}
body.anime-theme[data-theme=dark] .anime-card {
    background: rgba(40,30,55,.85);
    border-color: rgba(255,158,196,.4);
    color: #E0E0F0;
}
body.anime-theme[data-theme=dark] .nav-anime {
    background: rgba(20,15,30,.9) !important;
}
body.anime-theme[data-theme=dark] input,
body.anime-theme[data-theme=dark] textarea,
body.anime-theme[data-theme=dark] select {
    background: rgba(30,20,45,.7) !important;
    color: #E0E0F0 !important;
    border-color: rgba(255,158,196,.4) !important;
}

/* 浮动装饰按钮 */
.anime-float-btn {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF9EC4, #B39DDB);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 6px 20px rgba(255,158,196,.4);
    transition: all .3s;
    cursor: pointer;
    border: none;
}
.anime-float-btn:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 10px 30px rgba(255,158,196,.7);
}

/* 页面进入动画 */
@keyframes anime-fade-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anime-fade-up {
    animation: anime-fade-up .6s ease-out both;
}
</style>

{{-- 顶部进度条 --}}
<div class="anime-progress" id="animeProgress"></div>

{{-- 樱花飘落 --}}
@for($i = 0; $i < 8; $i++)
<div class="sakura-petal" style="left:{{ 5 + $i * 12 }}%;animation-duration:{{ 10 + ($i % 4) * 2 }}s;animation-delay:{{ $i * 1.2 }}s">🌸</div>
@endfor

<script>
// 页面切换进度条
(function() {
    var bar = document.getElementById('animeProgress');
    if (!bar) return;
    var timer = null;

    function start() {
        bar.style.opacity = '1';
        bar.style.width = '30%';
        setTimeout(() => bar.style.width = '70%', 150);
        clearTimeout(timer);
        timer = setTimeout(() => { bar.style.width = '100%'; }, 800);
    }
    function done() {
        bar.style.width = '100%';
        setTimeout(() => { bar.style.opacity = '0'; setTimeout(() => bar.style.width = '0', 300); }, 200);
    }

    document.addEventListener('click', function(e) {
        var a = e.target.closest('a');
        if (a && a.href && !a.target && !a.href.startsWith('javascript:') && a.href.indexOf('#') === -1) {
            if (a.href.split('#')[0] !== window.location.href.split('#')[0]) start();
        }
    });
    document.addEventListener('submit', start);
    window.addEventListener('pageshow', done);
    window.addEventListener('load', done);
})();

// 自动给 body 加 anime-theme 类
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('anime-theme');
});
</script>
