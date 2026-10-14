{{-- 亮色/暗色主题切换 --}}
<button id="theme-toggle" onclick="__toggleTheme()"
        class="fixed top-4 right-4 z-50 w-10 h-10 rounded-full flex items-center justify-center text-xl shadow-lg hover:scale-110 transition"
        style="background:linear-gradient(135deg,#FF9EC4,#B39DDB);color:#fff"
        title="切换主题">
    <span id="theme-icon">🌙</span>
</button>

<script>
(function(){
    // 初始化：读取 localStorage
    var saved = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', saved);
    var icon = document.getElementById('theme-icon');
    if (icon) icon.textContent = saved === 'dark' ? '☀️' : '🌙';
})();

function __toggleTheme() {
    var cur = document.body.getAttribute('data-theme') || 'light';
    var next = cur === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    var icon = document.getElementById('theme-icon');
    if (icon) icon.textContent = next === 'dark' ? '☀️' : '🌙';
}
</script>
