<div id="toast-container" class="fixed top-20 right-4 z-[9999] space-y-2"></div>

<script>
function showToast(message, type = 'success') {
    const colors = {
        success: 'background:linear-gradient(135deg,#A8E6CF,#7FD8BE);color:#1a5c3a',
        error:   'background:linear-gradient(135deg,#FFB6C1,#FF9EC4);color:#7a2040',
        info:    'background:linear-gradient(135deg,#A8D8FF,#7AB8E8);color:#1a3c5c',
    };
    const icons = { success: '🌸', error: '⚠️', info: '💎' };

    const el = document.createElement('div');
    el.className = 'anime-card px-5 py-3 shadow-lg transition-all duration-300';
    el.style.cssText = colors[type] + ';opacity:0;transform:translateX(20px)';
    el.innerHTML = '<span class="text-lg mr-2">' + icons[type] + '</span>' + message;
    document.getElementById('toast-container').appendChild(el);

    requestAnimationFrame(() => {
        el.style.opacity = '1';
        el.style.transform = 'translateX(0)';
    });

    setTimeout(() => {
        el.style.opacity = '0';
        el.style.transform = 'translateX(20px)';
        setTimeout(() => el.remove(), 300);
    }, 3500);
}

@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));
@endif
@if(session('error'))
    document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'error'));
@endif
</script>
