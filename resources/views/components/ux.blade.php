{{-- ══════════ 顶部进度条 ══════════ --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
<script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>
<style>
#nprogress .bar {
    background: linear-gradient(90deg, #FF9EC4, #B39DDB) !important;
    height: 3px !important;
}
#nprogress .peg {
    box-shadow: 0 0 10px #FF9EC4, 0 0 5px #FF9EC4 !important;
}
#nprogress .spinner-icon {
    border-top-color: #FF9EC4 !important;
    border-left-color: #FF9EC4 !important;
}
</style>
<script>
if (typeof NProgress !== 'undefined') {
    NProgress.configure({ showSpinner: false, easing: 'ease', speed: 400 });
    NProgress.start();
    window.addEventListener('load', () => NProgress.done());
}
</script>

{{-- ══════════ 页面淡入动画 ══════════ --}}
<style>
main {
    animation: pageFadeIn .5s ease-out;
}
@keyframes pageFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* 卡片逐个淡入 */
.anime-card {
    animation: cardFadeIn .4s ease-out backwards;
}
.anime-card:nth-child(1) { animation-delay: .05s; }
.anime-card:nth-child(2) { animation-delay: .10s; }
.anime-card:nth-child(3) { animation-delay: .15s; }
.anime-card:nth-child(4) { animation-delay: .20s; }
.anime-card:nth-child(5) { animation-delay: .25s; }
.anime-card:nth-child(6) { animation-delay: .30s; }
@keyframes cardFadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

{{-- ══════════ 骨架屏 ══════════ --}}
<style>
.skeleton {
    background: linear-gradient(90deg, rgba(255,158,196,.15) 25%, rgba(255,158,196,.30) 50%, rgba(255,158,196,.15) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 8px;
    display: inline-block;
    min-height: 1em;
    width: 100%;
}
@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>

{{-- ══════════ Ctrl+K 搜索 ══════════ --}}
<div id="cmd-palette" style="
    display:none;position:fixed;inset:0;z-index:99999;
    background:rgba(20,10,30,.5);backdrop-filter:blur(6px);
    align-items:flex-start;justify-content:center;padding-top:15vh;
">
    <div style="
        width:90%;max-width:540px;background:#fff;border-radius:20px;
        box-shadow:0 30px 80px rgba(255,158,196,.4);
        overflow:hidden;
    ">
        <div style="padding:16px 20px;border-bottom:1px solid #FFD1E8">
            <input id="cmd-input" type="text" placeholder="🔍 搜索页面或功能..."
                style="width:100%;border:none;outline:none;font-size:16px;background:transparent"
                autocomplete="off">
        </div>
        <div id="cmd-results" style="max-height:400px;overflow-y:auto;padding:8px"></div>
        <div style="padding:8px 16px;font-size:11px;color:#9CA3AF;border-top:1px solid #FFD1E8;text-align:right">
            ↑↓ 选择 · Enter 打开 · Esc 关闭
        </div>
    </div>
</div>

<script>
(function() {
    const pages = [
        { title: '产品列表',   url: '/products',                icon: '🎀' },
        { title: '我的服务',   url: '/client/services',         icon: '💗' },
        { title: '充值',       url: '/client/recharge',         icon: '💎' },
        { title: '工单',       url: '/client/tickets',          icon: '💌' },
        { title: '优惠券',     url: '/client/coupons',          icon: '🎫' },
        { title: '代理中心',   url: '/client/agent',            icon: '🌸' },
        { title: '通知中心',   url: '/client/notifications',    icon: '🔔' },
        { title: '购物车',     url: '/cart',                    icon: '🛒' },
        { title: '知识库',     url: '/kb',                      icon: '📚' },
        { title: '公告',       url: '/announcements',           icon: '📢' },
        { title: '管理看板',   url: '/admin/dashboard',         icon: '👑', admin: true },
        { title: '资源管理',   url: '/admin/services',          icon: '⚙️', admin: true },
        { title: '充值审核',   url: '/admin/recharges',         icon: '💰', admin: true },
        { title: '上游管理',   url: '/admin/providers',         icon: '🔌', admin: true },
        { title: '用户管理',   url: '/admin/users',             icon: '👥', admin: true },
        { title: '报表',       url: '/admin/reports',           icon: '📊', admin: true },
        { title: '监控',       url: '/admin/monitor',           icon: '📡', admin: true },
        { title: '系统设置',   url: '/admin/settings',          icon: '⚙️', admin: true },
        { title: '审计日志',   url: '/admin/audit-logs',        icon: '📜', admin: true },
        { title: '工单管理',   url: '/admin/tickets',           icon: '💌', admin: true },
    ];

    const isAdmin = @json(auth()->user()?->is_admin ?? false);

    const palette = document.getElementById('cmd-palette');
    const input = document.getElementById('cmd-input');
    const results = document.getElementById('cmd-results');
    let filtered = [];
    let selected = 0;

    function filter(q) {
        const list = pages.filter(p => (!p.admin || isAdmin) &&
            (q === '' || p.title.toLowerCase().includes(q.toLowerCase())));
        filtered = list;
        selected = 0;
        render();
    }

    function render() {
        if (filtered.length === 0) {
            results.innerHTML = '<div style="padding:20px;text-align:center;color:#9CA3AF">🔍 没有匹配的结果</div>';
            return;
        }
        results.innerHTML = filtered.map((p, i) => `
            <a href="${p.url}" style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:12px;text-decoration:none;color:#4A4A6A;
                ${i === selected ? 'background:linear-gradient(135deg,rgba(255,158,196,.2),rgba(179,157,219,.2))' : ''}"
                onmouseover="document.querySelectorAll('#cmd-results a')[${i}].click!==undefined"">
                <span style="font-size:20px">${p.icon}</span>
                <span style="font-weight:600">${p.title}</span>
                <span style="margin-left:auto;font-size:11px;color:#9CA3AF">${p.url}</span>
            </a>
        `).join('');
    }

    function open() {
        palette.style.display = 'flex';
        input.value = '';
        filter('');
        setTimeout(() => input.focus(), 50);
    }

    function close() {
        palette.style.display = 'none';
    }

    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            palette.style.display === 'flex' ? close() : open();
        }
        if (e.key === 'Escape' && palette.style.display === 'flex') close();
        if (palette.style.display === 'flex') {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selected = Math.min(selected + 1, filtered.length - 1);
                render();
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                selected = Math.max(selected - 1, 0);
                render();
            }
            if (e.key === 'Enter' && filtered[selected]) {
                window.location.href = filtered[selected].url;
            }
        }
    });

    input.addEventListener('input', e => filter(e.target.value));
    palette.addEventListener('click', e => { if (e.target === palette) close(); });
})();
</script>

{{-- ══════════ 返回顶部按钮 ══════════ --}}
<button id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" style="
    display:none;position:fixed;bottom:100px;right:24px;z-index:1000;
    width:48px;height:48px;border-radius:50%;border:none;cursor:pointer;
    background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff;font-size:20px;
    box-shadow:0 6px 20px rgba(255,158,196,.5);
    transition:all .3s;
">
    🌸
</button>
<script>
window.addEventListener('scroll', () => {
    const btn = document.getElementById('back-to-top');
    if (btn) btn.style.display = window.scrollY > 400 ? 'block' : 'none';
});
</script>

{{-- ══════════ 复制到剪贴板 ══════════ --}}
<script>
function copyText(text, label) {
    navigator.clipboard.writeText(text).then(() => {
        if (typeof showToast === 'function') {
            showToast((label || '内容') + ' 已复制', 'success');
        }
    }).catch(() => {
        if (typeof showToast === 'function') {
            showToast('复制失败，请手动选中', 'error');
        }
    });
}
</script>

{{-- ══════════ 图片懒加载 ══════════ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('img:not([loading])').forEach(img => {
        img.setAttribute('loading', 'lazy');
    });
});
</script>

{{-- ══════════ 表单输入美化 ══════════ --}}
<style>
input:focus, textarea:focus, select:focus {
    box-shadow: 0 0 0 4px rgba(255,158,196,.15) !important;
    transition: box-shadow .2s;
}
input::placeholder, textarea::placeholder {
    color: #B8B8CC;
}
</style>
