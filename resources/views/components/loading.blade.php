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
window.addEventListener('beforeunload', () => {
    const l = document.getElementById('page-loader');
    if (l) l.style.display = 'flex';
});
document.addEventListener('DOMContentLoaded', () => {
    const l = document.getElementById('page-loader');
    if (l) l.style.display = 'none';
});
</script>
