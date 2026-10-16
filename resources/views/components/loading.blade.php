<div id="page-loader" style="
    position:fixed;inset:0;z-index:9998;
    background:rgba(255,245,250,.85);backdrop-filter:blur(4px);
    display:none;align-items:center;justify-content:center;
    transition:opacity .3s;
">
    <div style="text-align:center">
        <div style="font-size:48px;animation:spin 1.2s linear infinite;display:inline-block">🌸</div>
        <div style="color:#FF9EC4;margin-top:12px;font-weight:600">加载中...</div>
    </div>
</div>
<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
<script>
(function() {
    var loaderTimer = null;

    function showLoader() {
        var l = document.getElementById('page-loader');
        if (l) {
            l.style.display = 'flex';
            // 3 秒兜底：即使页面没跳转，也自动隐藏
            clearTimeout(loaderTimer);
            loaderTimer = setTimeout(hideLoader, 3000);
        }
    }

    function hideLoader() {
        var l = document.getElementById('page-loader');
        if (l) l.style.display = 'none';
        clearTimeout(loaderTimer);
    }

    // 只在真正点击链接/提交表单时显示
    document.addEventListener('click', function(e) {
        var a = e.target.closest('a');
        if (a && a.href && !a.target && !a.href.startsWith('javascript:') && !a.href.startsWith('#')) {
            // 页面内锚点跳过
            if (a.href.split('#')[0] !== window.location.href.split('#')[0]) {
                showLoader();
            }
        }
    });

    document.addEventListener('submit', function() {
        showLoader();
    });

    // 页面加载完成后隐藏
    window.addEventListener('pageshow', hideLoader);
    document.addEventListener('DOMContentLoaded', hideLoader);
    window.addEventListener('load', hideLoader);
})();
</script>
