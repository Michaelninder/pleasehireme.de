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
