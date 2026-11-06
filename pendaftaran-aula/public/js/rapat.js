/* ==========================================================================
   SAPA — interaksi antarmuka
   Dimuat sekali dari layouts/app.blade.php (defer).
   ========================================================================== */

(function () {
    'use strict';

    var $  = function (s, c) { return (c || document).querySelector(s); };
    var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;


    /* ------------------------------------------------------------------
       Hari & jam realtime (Asia/Makassar)
       ------------------------------------------------------------------ */

    (function clock() {
        var dayEl  = $('#tbDay');
        var timeEl = $('#tbTime');

        if (!dayEl || !timeEl || typeof Intl === 'undefined') return;

        var fmt = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Makassar',
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', hourCycle: 'h23'
        });

        function tick() {
            var p = {};
            fmt.formatToParts(new Date()).forEach(function (x) { p[x.type] = x.value; });

            dayEl.textContent  = p.weekday + ', ' + p.day + ' ' + p.month + ' ' + p.year;
            timeEl.textContent = p.hour + '.' + p.minute + '.' + p.second + ' WITA';
        }

        tick();
        setInterval(tick, 1000);
    })();


    /* ------------------------------------------------------------------
       Dropdown topbar (notifikasi & profil)
       ------------------------------------------------------------------ */

    var toggles = $$('[data-tb-toggle]');

    function closeDropdowns(except) {
        toggles.forEach(function (btn) {
            if (btn === except) return;
            btn.setAttribute('aria-expanded', 'false');
            var panel = document.getElementById(btn.getAttribute('data-tb-toggle'));
            if (panel) panel.classList.remove('open');
        });
    }

    toggles.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();

            var panel = document.getElementById(btn.getAttribute('data-tb-toggle'));
            if (!panel) return;

            var willOpen = !panel.classList.contains('open');
            closeDropdowns(btn);
            panel.classList.toggle('open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.tb-dropdown')) closeDropdowns();
    });


    /* ------------------------------------------------------------------
       Penanda notifikasi belum dibaca (per akun, di localStorage)
       ------------------------------------------------------------------ */

    (function notifications() {
        var badge = $('#tbBadge');
        var items = $$('.tb-item[data-ts]');

        if (!badge || !items.length) return;

        var account = badge.getAttribute('data-account') || '';
        var KEY = 'sapa_notif_read_' + account;
        var lastRead = 0;

        try {
            lastRead = parseInt(localStorage.getItem(KEY) || '0', 10) || 0;
        } catch (e) { /* penyimpanan tidak tersedia */ }

        function setBadge(n) {
            badge.hidden = n === 0;
            badge.textContent = n > 9 ? '9+' : String(n);
        }

        var unread = 0;

        items.forEach(function (it) {
            // Hanya keputusan admin yang dihitung sebagai notifikasi baru.
            var baru =
                ['disetujui', 'ditolak'].indexOf(it.getAttribute('data-status')) !== -1 &&
                parseInt(it.getAttribute('data-ts'), 10) > lastRead;

            it.classList.toggle('unread', baru);
            if (baru) unread++;
        });

        setBadge(unread);

        function markRead() {
            var max = lastRead;
            items.forEach(function (it) {
                max = Math.max(max, parseInt(it.getAttribute('data-ts'), 10) || 0);
            });
            try { localStorage.setItem(KEY, String(max)); } catch (e) {}
            lastRead = max;
            setBadge(0);
            items.forEach(function (it) { it.classList.remove('unread'); });
        }

        var bell = $('[data-tb-toggle="tbNotifPanel"]');
        if (bell) bell.addEventListener('click', markRead);
    })();


    /* ------------------------------------------------------------------
       Navigasi mobile (drawer)
       ------------------------------------------------------------------ */

    (function drawer() {
        var toggleBtn = $('[data-nav-toggle]');
        if (!toggleBtn) return;

        var sidebar = $('#sidebar');

        function open() {
            document.body.classList.add('nav-open');
            toggleBtn.setAttribute('aria-expanded', 'true');
            if (sidebar) {
                var first = sidebar.querySelector('.sidebar-nav a');
                if (first) first.focus();
            }
        }

        function close() {
            if (!document.body.classList.contains('nav-open')) return;
            document.body.classList.remove('nav-open');
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.focus();
        }

        toggleBtn.addEventListener('click', function () {
            document.body.classList.contains('nav-open') ? close() : open();
        });

        $$('[data-nav-close]').forEach(function (el) {
            el.addEventListener('click', close);
        });

        // Menutup drawer saat salah satu menu dipilih.
        $$('.sidebar-nav a').forEach(function (a) {
            a.addEventListener('click', close);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 1024) close();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });
    })();


    /* ------------------------------------------------------------------
       Bayangan appbar & tombol kembali ke atas
       ------------------------------------------------------------------ */

    (function onScroll() {
        var appbar   = $('#appbar');
        var scrollTop = $('[data-scroll-top]');
        var ticking  = false;

        function update() {
            var y = window.scrollY || document.documentElement.scrollTop;
            ticking = false;

            if (appbar) appbar.classList.toggle('is-stuck', y > 8);
            if (scrollTop) scrollTop.classList.toggle('show', y > 420);
        }

        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }, { passive: true });

        update();

        if (scrollTop) {
            scrollTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
                var target = $('#main') || document.body;
                target.focus({ preventScroll: true });
            });
        }
    })();


    /* ------------------------------------------------------------------
       Alert: tutup manual & otomatis
       ------------------------------------------------------------------ */

    (function alerts() {
        function dismiss(alert) {
            alert.classList.add('is-dismissed');
            window.setTimeout(function () { alert.remove(); }, prefersReducedMotion ? 0 : 220);
        }

        $$('.alert').forEach(function (alert) {
            var btn = $('[data-alert-close]', alert);
            if (btn) btn.addEventListener('click', function () { dismiss(alert); });

            var delay = parseInt(alert.getAttribute('data-autohide') || '0', 10);
            if (delay > 0) window.setTimeout(function () { dismiss(alert); }, delay);
        });
    })();


    /* ------------------------------------------------------------------
       Konfirmasi aksi berbahaya
       ------------------------------------------------------------------ */

    document.addEventListener('submit', function (e) {
        var form = e.target.closest('form[data-confirm]');
        if (!form || form.dataset.confirmed === '1') return;

        if (!window.confirm(form.getAttribute('data-confirm'))) {
            e.preventDefault();
            return;
        }

        form.dataset.confirmed = '1';
    });

    document.addEventListener('click', function (e) {
        var el = e.target.closest('a[data-confirm], button[data-confirm]');
        if (!el || el.closest('form[data-confirm]')) return;

        if (!window.confirm(el.getAttribute('data-confirm'))) e.preventDefault();
    });


    /* ------------------------------------------------------------------
       Tombol submit: cegah klik ganda
       ------------------------------------------------------------------ */

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!(form instanceof HTMLFormElement) || form.dataset.busy === '1') return;
        if (form.method && form.method.toLowerCase() === 'get') return;

        var btn = $('button[type="submit"]:not([data-no-lock])', form);
        if (!btn) return;

        form.dataset.busy = '1';
        btn.classList.add('is-loading');
        btn.disabled = true;

        // Jaga-jaga bila navigasi dibatalkan (mis. validasi HTML5 gagal).
        window.setTimeout(function () {
            form.dataset.busy = '';
            btn.classList.remove('is-loading');
            btn.disabled = false;
        }, 8000);
    });


    /* ------------------------------------------------------------------
       Modal: tutup dengan ESC / klik latar, kunci fokus di dalamnya
       ------------------------------------------------------------------ */

    var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
    var lastOpener = null;

    function isShown(overlay) {
        return overlay.classList.contains('show') || overlay.classList.contains('open');
    }

    function syncLock() {
        var anyOpen = $$('.modal-overlay').some(isShown);
        document.body.classList.toggle('modal-open', anyOpen);
    }

    function openModal(overlay, opener) {
        lastOpener = opener || null;
        overlay.classList.add('show');
    }

    function closeModal(overlay) {
        overlay.classList.remove('show', 'open');
        syncLock();

        if (lastOpener && lastOpener.isConnected) {
            lastOpener.focus({ preventScroll: true });
            lastOpener = null;
        }
    }

    document.addEventListener('click', function (e) {
        var opener = e.target.closest('[data-modal-open]');

        if (opener) {
            var target = document.getElementById(opener.getAttribute('data-modal-open'));
            if (target) openModal(target, opener);
        }

        if (e.target.closest('.close-modal, [data-modal-close]')) {
            var overlay = e.target.closest('.modal-overlay');
            if (overlay) closeModal(overlay);
        }
    });

    $$('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('mousedown', function (e) {
            if (e.target === overlay) closeModal(overlay);
        });

        // Kunci fokus, kunci gulir, dan arahkan fokus saat modal tampil.
        new MutationObserver(function () {
            syncLock();

            if (!isShown(overlay)) return;

            var fields = $$(FOCUSABLE, overlay).filter(function (el) {
                return el.offsetParent !== null;
            });

            var target = $('textarea[autofocus], input[autofocus], textarea, input', overlay)
                || fields[0];

            if (target) target.focus({ preventScroll: true });
        }).observe(overlay, { attributes: true, attributeFilter: ['class'] });

        // Modal yang dibuka dari sisi server (mis. validasi gagal).
        if (isShown(overlay)) syncLock();
    });

    document.addEventListener('keydown', function (e) {
        var active = $$('.modal-overlay').filter(isShown);
        if (!active.length) return;

        var top = active[active.length - 1];

        if (e.key === 'Escape') {
            e.preventDefault();
            closeModal(top);
            return;
        }

        if (e.key !== 'Tab') return;

        var items = $$(FOCUSABLE, top).filter(function (el) {
            return el.offsetParent !== null;
        });

        if (!items.length) return;

        var first = items[0];
        var last  = items[items.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    });


    /* ------------------------------------------------------------------
       Tampilan sandi & textarea yang mengikuti isi
       ------------------------------------------------------------------ */

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-password-toggle]');
        if (!btn) return;

        var input = document.getElementById(btn.getAttribute('data-password-toggle'));
        if (!input) return;

        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.classList.toggle('is-visible', show);
        btn.setAttribute('aria-label', show ? 'Sembunyikan sandi' : 'Tampilkan sandi');
        input.focus();
    });

    $$('[data-autogrow]').forEach(function (ta) {
        function grow() {
            ta.style.height = 'auto';
            ta.style.height = ta.scrollHeight + 'px';
        }
        ta.addEventListener('input', grow);
        grow();
    });


    /* ------------------------------------------------------------------
       Sorot field yang gagal validasi
       ------------------------------------------------------------------ */

    $$('.error-text').forEach(function (msg) {
        var group = msg.closest('.form-group') || msg.parentElement;
        if (!group) return;

        group.classList.add('has-error');
        $$('input, select, textarea', group).forEach(function (f) {
            f.classList.add('is-invalid');
            f.setAttribute('aria-invalid', 'true');
        });
    });

    var firstInvalid = $('.is-invalid');
    if (firstInvalid && !window.location.hash) {
        firstInvalid.focus({ preventScroll: true });
        firstInvalid.scrollIntoView({ block: 'center', behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    }


    /* ------------------------------------------------------------------
       Penanda tautan aktif pada .info-nav
       ------------------------------------------------------------------ */

    (function infoNav() {
        var links = $$('.info-nav a[href^="#"]');
        if (links.length < 2 || !('IntersectionObserver' in window)) return;

        var byId = {};

        var targets = links.reduce(function (acc, a) {
            var el = document.getElementById(a.getAttribute('href').slice(1));
            if (el && !byId[el.id]) {
                byId[el.id] = a;
                acc.push(el);
            }
            return acc;
        }, []);

        if (targets.length < 2) return;

        function setActive(id) {
            links.forEach(function (a) {
                var on = a === byId[id];
                a.classList.toggle('active', on);
                if (on) a.setAttribute('aria-current', 'true');
                else a.removeAttribute('aria-current');
            });
        }

        var visible = {};

        new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { visible[en.target.id] = en.isIntersecting; });

            for (var i = 0; i < targets.length; i++) {
                if (visible[targets[i].id]) { setActive(targets[i].id); return; }
            }
        }, { rootMargin: '-96px 0px -62% 0px', threshold: 0 })
            .observe(targets[0]);

        targets.slice(1).forEach(function (t) {
            new IntersectionObserver(function (entries) {
                entries.forEach(function (en) { visible[en.target.id] = en.isIntersecting; });
                for (var i = 0; i < targets.length; i++) {
                    if (visible[targets[i].id]) { setActive(targets[i].id); return; }
                }
            }, { rootMargin: '-96px 0px -62% 0px', threshold: 0 }).observe(t);
        });
    })();

})();
