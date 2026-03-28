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

    function open(src, alt, title) {
        lightImg.src = src;
        lightImg.alt = alt || '';
        caption.textContent = title || '';
        caption.style.display = title ? 'block' : 'none';
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.remove('is-open');
        document.body.style.overflow = '';
        lightImg.src = '';
    }

    // Any img with data-lightbox attribute triggers the gallery
    document.querySelectorAll('img[data-lightbox]').forEach(function (img) {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', function () {
            // Use data-fullsrc for full resolution in lightbox if available
            var fullSrc = img.dataset.fullsrc || img.src;
            open(fullSrc, img.alt, img.dataset.title);
        });
    });

    closeBtn.addEventListener('click', close);

    // Click backdrop to close
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) close();
    });

    // Escape key to close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
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
