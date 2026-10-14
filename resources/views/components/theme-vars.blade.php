{{-- 亮色/暗色主题变量 --}}
<style>
:root {
    --sakura:#FF9EC4;
    --sky:#A8D8FF;
    --cream:#FFE5B4;
    --purple:#B39DDB;
    --text:#4A4A6A;
    --bg-start:#FFF5FA;
    --bg-mid:#F0F5FF;
    --bg-end:#FFF0F5;
    --card-bg:rgba(255,255,255,.85);
    --card-border:rgba(255,158,196,.3);
}

body[data-theme="dark"] {
    --sakura:#FF9EC4;
    --sky:#7AB8E8;
    --cream:#E8C88A;
    --purple:#9B86C8;
    --text:#E0E0F0;
    --bg-start:#1a1420;
    --bg-mid:#1a1a2e;
    --bg-end:#201825;
    --card-bg:rgba(40,30,55,.85);
    --card-border:rgba(255,158,196,.4);
}

body[data-theme="dark"] {
    background:linear-gradient(135deg, var(--bg-start) 0%, var(--bg-mid) 50%, var(--bg-end) 100%);
    color:var(--text);
}

body[data-theme="dark"] .anime-card {
    background:var(--card-bg) !important;
    border-color:var(--card-border) !important;
}

body[data-theme="dark"] .nav-anime {
    background:rgba(20,15,30,.9) !important;
    border-bottom-color:rgba(255,158,196,.4) !important;
}

body[data-theme="dark"] input,
body[data-theme="dark"] textarea,
body[data-theme="dark"] select {
    background:rgba(30,20,45,.6) !important;
    color:#E0E0F0 !important;
    border-color:rgba(255,158,196,.4) !important;
}

body[data-theme="dark"] .glow-card {
    background:linear-gradient(135deg, rgba(40,30,55,.9), rgba(30,20,45,.9)) !important;
    border-color:rgba(255,158,196,.4) !important;
}
</style>
