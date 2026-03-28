// Render email addresses onto a canvas so no text ever exists in the DOM.
// Scrapers parse HTML/JS strings — they can't read pixel data.
(function () {
    var emails = [
        { id: 'email-1', parts: ['hey', 'fabianternis', 'de'] },
        { id: 'email-2', parts: ['f.ternix', 'xpsystems', 'eu'] }
    ];

    var style = getComputedStyle(document.documentElement);
    var color = style.getPropertyValue('--text-muted').trim() || '#6b7280';
    var font  = '16px Lucida Sans, Verdana, sans-serif';

    emails.forEach(function (entry) {
        var canvas = document.getElementById(entry.id);
        if (!canvas) return;

        // Build the address only in memory, never as a DOM string
        var addr = entry.parts[0] + '\u0040' + entry.parts[1] + '.' + entry.parts[2];

        var ctx = canvas.getContext('2d');
        ctx.font = font;
        var w = ctx.measureText(addr).width;

        canvas.width  = Math.ceil(w) + 4;
        canvas.height = 22;

        // Re-apply font after resize (resize resets canvas state)
        ctx.font         = font;
        ctx.fillStyle    = color;
        ctx.textBaseline = 'middle';
        ctx.fillText(addr, 2, 11);
    });
}());

// ── Lightbox ──
(function () {
    var lightbox = document.getElementById('lightbox');
    var lightImg = document.getElementById('lightbox-img');
    var caption  = document.getElementById('lightbox-caption');
    var closeBtn = document.getElementById('lightbox-close');
    var cache    = {};  // src → Image (preloaded)

    function preload(src) {
        if (cache[src]) return;
        var img = new Image();
        img.src = src;
        cache[src] = img;
    }

    function open(src, alt, title) {
        // Only change src if different — avoids reload flicker
        if (lightImg.dataset.loaded !== src) {
            lightImg.src = src;
            lightImg.dataset.loaded = src;
        }
        lightImg.alt = alt || '';
        caption.textContent = title || '';
        caption.style.display = title ? 'block' : 'none';
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.remove('is-open');
        document.body.style.overflow = '';
        // Don't clear src — keep it cached in the element
    }

    document.querySelectorAll('img[data-lightbox]').forEach(function (img) {
        img.style.cursor = 'zoom-in';
        var fullSrc = img.dataset.fullsrc || img.src;

        // Preload on hover
        img.addEventListener('mouseenter', function () { preload(fullSrc); });

        img.addEventListener('click', function () {
            open(fullSrc, img.alt, img.dataset.title);
        });
    });

    closeBtn.addEventListener('click', close);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) close();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });
}());

// ── Navbar: scroll state + active indicator + mobile toggle ──
(function () {
    var navbar    = document.getElementById('navbar');
    var toggle    = document.getElementById('nav-toggle');
    var menu      = document.getElementById('nav-menu');
    var indicator = document.getElementById('nav-indicator');
    var linkEls   = document.querySelectorAll('.nav-link__link');

    // ── Scroll state ──
    function onScroll() {
        navbar.classList.toggle('is-scrolled', window.scrollY > 50);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ── Sliding pill indicator ──
    function moveIndicator(el) {
        if (!indicator || !el) return;
        var listRect = el.closest('.nav-links__list').getBoundingClientRect();
        var linkRect = el.getBoundingClientRect();
        var offsetX  = linkRect.left - listRect.left;
        indicator.style.width   = linkRect.width + 'px';
        indicator.style.transform = 'translateY(-50%) translateX(' + offsetX + 'px)';
        indicator.style.opacity = '1';
    }

    function hideIndicator() {
        if (indicator) indicator.style.opacity = '0';
    }

    // Hover: show pill on hovered link
    linkEls.forEach(function (link) {
        link.addEventListener('mouseenter', function () {
            moveIndicator(link);
        });
    });

    // Mouse leaves the whole list: snap back to active or hide
    var list = document.querySelector('.nav-links__list');
    if (list) {
        list.addEventListener('mouseleave', function () {
            var active = document.querySelector('.nav-link__link.active');
            active ? moveIndicator(active) : hideIndicator();
        });
    }

    // ── Active section via IntersectionObserver ──
    var sections = document.querySelectorAll('section[id]');
    var activeId = null;

    function setActive(id) {
        if (id === activeId) return;
        activeId = id;
        linkEls.forEach(function (link) {
            var href = link.getAttribute('href');
            var matches = href === '/#' + id || href === '#' + id;
            link.classList.toggle('active', matches);
            if (matches) moveIndicator(link);
        });
    }

    if (sections.length && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });

        sections.forEach(function (s) { observer.observe(s); });
    }

    // ── Mobile toggle ──
    function openMenu() {
        menu.classList.add('is-open');
        toggle.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        menu.classList.remove('is-open');
        toggle.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (toggle) toggle.addEventListener('click', function () {
        menu.classList.contains('is-open') ? closeMenu() : openMenu();
    });

    linkEls.forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
}());

// ── Skills table filters ──
(function () {
    var filters = document.querySelectorAll('.skills-filter');
    var rows    = document.querySelectorAll('.skills-table tbody tr');

    filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var cat = btn.dataset.filter;

            filters.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');

            rows.forEach(function (row) {
                if (cat === 'all' || row.dataset.category === cat) {
                    row.classList.remove('is-hidden');
                } else {
                    row.classList.add('is-hidden');
                }
            });
        });
    });
}());

// ── Preload lightbox images when wettbewerbe section enters viewport ──
(function () {
    var section = document.getElementById('wettbewerbe');
    if (!section || !('IntersectionObserver' in window)) return;

    var preloaded = false;

    var observer = new IntersectionObserver(function (entries) {
        if (preloaded || !entries[0].isIntersecting) return;
        preloaded = true;
        observer.disconnect();

        section.querySelectorAll('img[data-fullsrc]').forEach(function (img) {
            var pre = new Image();
            pre.src = img.dataset.fullsrc;
        });
    }, { rootMargin: '200px' });

    observer.observe(section);
}());





// ── Language switcher ──
(function () {
    var btn      = document.getElementById('lang-btn');
    var switcher = document.getElementById('lang-switcher');
    var menu     = document.getElementById('lang-menu');
    var popover  = document.getElementById('lang-popover');
    var backdrop = document.getElementById('lang-popover-backdrop');
    if (!btn) return;

    function isMobile() { return window.innerWidth <= 600; }

    function redirect(lang) {
        var p = new URLSearchParams(window.location.search);
        p.set('lang', lang);
        window.location.href = window.location.pathname + '?' + p.toString();
    }

    // ── Desktop dropdown ──
    function openDropdown()  { switcher.classList.add('is-open');    btn.setAttribute('aria-expanded','true'); }
    function closeDropdown() { switcher.classList.remove('is-open'); btn.setAttribute('aria-expanded','false'); }

    if (menu) {
        menu.querySelectorAll('.lang-switcher__option').forEach(function (opt) {
            opt.addEventListener('click', function () { redirect(opt.dataset.lang); });
        });
    }

    // ── Mobile popover ──
    function openPopover()  { if (popover) { popover.classList.add('is-open');    popover.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } }
    function closePopover() { if (popover) { popover.classList.remove('is-open'); popover.setAttribute('aria-hidden','true');  document.body.style.overflow=''; } }

    if (popover) {
        popover.querySelectorAll('.lang-popover__option').forEach(function (opt) {
            opt.addEventListener('click', function () { redirect(opt.dataset.lang); });
        });
        if (backdrop) backdrop.addEventListener('click', closePopover);
    }

    // ── Trigger ──
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (isMobile()) {
            openPopover();
        } else {
            switcher.classList.contains('is-open') ? closeDropdown() : openDropdown();
        }
    });

    document.addEventListener('click', closeDropdown);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeDropdown(); closePopover(); }
    });
}());
