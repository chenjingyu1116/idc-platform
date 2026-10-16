{{-- 弹幕背景 --}}
<div id="idc-danmaku" class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index:1" aria-hidden="true"></div>

<style>
@keyframes danmakuMove {
    0%   { transform:translateX(0); }
    100% { transform:translateX(calc(-100vw - 100%)); }
}
.danmaku-item {
    position: absolute;
    white-space: nowrap;
    pointer-events: none;
    font-weight: 600;
    text-shadow: 0 2px 8px rgba(255,158,196,.4), 0 0 20px rgba(255,255,255,.6);
    animation: danmakuMove linear forwards;
}
body[data-theme="dark"] .danmaku-item {
    text-shadow: 0 2px 8px rgba(0,0,0,.6), 0 0 20px rgba(255,158,196,.3);
}
</style>

<script>
(function() {
    var MESSAGES = [
        '🌸 欢迎来到樱花云',
        '⚡ 萌系 VPS 空间',
        '✨ 免备案 · 五元起',
        '🎀 7×24 萌妹客服',
        '💎 香港 CN2 直连',
        '🌸 二次元专属云平台',
        '💗 稳定运行 · 永久在线',
        '⭐ 樱花云 · 让 IDC 管理也能如此可爱',
        '🎁 新用户注册即送优惠券',
        '💴 支持支付宝 / 微信支付',
        '🚀 一键开通 · 秒级部署',
        '🛡️ 全站 HTTPS · 数据加密',
    ];
    var COLORS = ['#FF9EC4', '#A8D8FF', '#B39DDB', '#FFB6D5', '#7AB8E8', '#9B86C8'];

    var container = document.getElementById('idc-danmaku');
    if (!container) return;

    function spawn() {
        var el = document.createElement('div');
        el.className = 'danmaku-item';
        var text = MESSAGES[Math.floor(Math.random() * MESSAGES.length)];
        var top = 5 + Math.random() * 85;
        var duration = 18 + Math.random() * 12;
        var size = 14 + Math.random() * 8;
        var color = COLORS[Math.floor(Math.random() * COLORS.length)];

        el.textContent = text;
        el.style.top = top + '%';
        el.style.left = '100%';
        el.style.fontSize = size + 'px';
        el.style.color = color;
        el.style.animationDuration = duration + 's';

        container.appendChild(el);
        setTimeout(function() { el.remove(); }, duration * 1000 + 500);
    }

    // 每 4 秒一条
    setInterval(spawn, 4000);
    // 启动时错峰放 3 条
    for (var i = 0; i < 3; i++) {
        setTimeout(spawn, i * 1200);
    }
})();
</script>
