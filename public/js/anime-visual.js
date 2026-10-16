/* ═══════ 樱花云 · 视觉交互 ═══════ */
(function() {
    'use strict';

    /* ────── 1. 滚动淡入 ────── */
    function initReveal() {
        var els = document.querySelectorAll('.reveal');
        if (!els.length) return;

        if (!('IntersectionObserver' in window)) {
            els.forEach(function(el) { el.classList.add('revealed'); });
            return;
        }

        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('revealed');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: .15, rootMargin: '0px 0px -50px 0px' });

        els.forEach(function(el) { io.observe(el); });
    }

    /* ────── 2. 产品卡片 3D 倾斜 ────── */
    function initCard3D() {
        document.querySelectorAll('.card-3d').forEach(function(card) {
            card.addEventListener('mousemove', function(e) {
                var rect = card.getBoundingClientRect();
                var x = (e.clientX - rect.left) / rect.width - .5;
                var y = (e.clientY - rect.top) / rect.height - .5;
                var rx = -y * 12;
                var ry = x * 12;
                card.style.transform = 'perspective(800px) rotateX(' + rx +
                    'deg) rotateY(' + ry + 'deg) translateY(-4px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                card.style.transform = '';
            });
        });
    }

    /* ────── 3. 数字滚动 ────── */
    function initCounters() {
        var els = document.querySelectorAll('.counter-num');
        if (!els.length) return;

        els.forEach(function(el) {
            var target = parseFloat(el.getAttribute('data-target') || el.textContent.replace(/[^\d.]/g, ''));
            if (isNaN(target)) return;
            var prefix = el.getAttribute('data-prefix') || '';
            var suffix = el.getAttribute('data-suffix') || '';
            var duration = parseInt(el.getAttribute('data-duration') || 1500);

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    observer.unobserve(el);

                    var start = performance.now();
                    function tick(now) {
                        var p = Math.min(1, (now - start) / duration);
                        var eased = 1 - Math.pow(1 - p, 3);
                        var val = target * eased;
                        var formatted = target % 1 === 0 ? Math.floor(val) : val.toFixed(2);
                        el.textContent = prefix + formatted + suffix;
                        if (p < 1) requestAnimationFrame(tick);
                        else el.textContent = prefix + (target % 1 === 0 ? target : target.toFixed(2)) + suffix;
                    }
                    requestAnimationFrame(tick);
                });
            }, { threshold: .3 });

            observer.observe(el);
        });
    }

    /* ────── 4. Hero 粒子背景 ────── */
    function initParticles() {
        var canvas = document.getElementById('particles-canvas');
        if (!canvas) return;

        var ctx = canvas.getContext('2d');
        var particles = [];
        var count = 40;
        var w = 0, h = 0;

        function resize() {
            var rect = canvas.parentElement.getBoundingClientRect();
            w = canvas.width = rect.width;
            h = canvas.height = rect.height;
        }
        resize();
        window.addEventListener('resize', resize);

        // 初始化粒子
        for (var i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * w,
                y: Math.random() * h,
                r: Math.random() * 2 + 1,
                vx: (Math.random() - .5) * .4,
                vy: (Math.random() - .5) * .4,
                alpha: Math.random() * .5 + .3,
                hue: Math.random() > .5 ? 340 : 200, // 粉 / 蓝
            });
        }

        function draw() {
            ctx.clearRect(0, 0, w, h);

            // 连线
            for (var i = 0; i < particles.length; i++) {
                for (var j = i + 1; j < particles.length; j++) {
                    var dx = particles[i].x - particles[j].x;
                    var dy = particles[i].y - particles[j].y;
                    var d = Math.sqrt(dx * dx + dy * dy);
                    if (d < 120) {
                        ctx.strokeStyle = 'rgba(255, 158, 196, ' + ((1 - d / 120) * .15) + ')';
                        ctx.lineWidth = .5;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }

            // 粒子
            particles.forEach(function(p) {
                p.x += p.vx;
                p.y += p.vy;
                if (p.x < 0 || p.x > w) p.vx *= -1;
                if (p.y < 0 || p.y > h) p.vy *= -1;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'hsla(' + p.hue + ', 80%, 75%, ' + p.alpha + ')';
                ctx.fill();
            });

            requestAnimationFrame(draw);
        }
        draw();
    }

    /* ────── 5. 全局 Toast 增强 ────── */
    function initGlobalToast() {
        if (typeof window.showToast !== 'function') return;
        var orig = window.showToast;
        window.showToast = function(msg, type) {
            orig(msg, type);
            var container = document.getElementById('toast-container');
            if (container && container.lastElementChild) {
                var el = container.lastElementChild;
                el.style.animation = 'toast-slide-in .3s cubic-bezier(.34, 1.56, .64, 1)';
            }
        };
    }

    /* ────── 6. 平滑滚动 ────── */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(a) {
            a.addEventListener('click', function(e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    /* ────── 7. 页面切换淡入 ────── */
    function initPageTransition() {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity .3s';
        requestAnimationFrame(function() {
            document.body.style.opacity = '1';
        });
    }

    /* ────── 初始化 ────── */
    function init() {
        initPageTransition();
        initReveal();
        initCard3D();
        initCounters();
        initParticles();
        initGlobalToast();
        initSmoothScroll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
