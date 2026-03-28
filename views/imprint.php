<?php
$title = 'Imprint – pleasehireme.de';
ob_start();
?>
<section class="section__about" style="max-width:720px;margin:0 auto;padding:6rem 2rem 4rem;">
    <span class="section-indicator">#imprint</span>
    <h2>Imprint</h2>

    <div class="imprint-block">
        <h3>Angaben gemäß § 5 TMG</h3>
        <p>
            Fabian Ternis<br>
            Alzeyer Str. 97<br>
            67592 Flörsheim-Dalsheim<br>
            Rheinland-Pfalz, Deutschland
        </p>
    </div>

    <div class="imprint-block">
        <h3>Kontakt</h3>
        <p>
            E-Mail: <canvas class="email-canvas" id="imprint-email" aria-label="hey [at] fabianternis.de"></canvas>
        </p>
    </div>

    <div class="imprint-block">
        <h3>Datenschutz &amp; DSGVO</h3>
        <p>Diese Website verwendet <strong>keine Cookies</strong> und setzt <strong>keine externen Cookies</strong>.</p>
        <p>
            Diese Website wird über <strong>GitHub Pages</strong> (Microsoft Corporation, One Microsoft Way,
            Redmond, WA 98052, USA) gehostet. GitHub kann dabei technische Daten wie IP-Adressen,
            Browsertyp und Zugriffszeiten im Rahmen des Hostingbetriebs verarbeiten.
            Weitere Informationen finden Sie in der
            <a href="https://docs.github.com/en/site-policy/privacy-policies/github-general-privacy-statement"
               target="_blank" rel="noopener noreferrer">Datenschutzerklärung von GitHub</a>.
        </p>
        <p>
            Diese Website erhebt selbst <strong>keine personenbezogenen Daten</strong>,
            setzt keine Tracking-Technologien ein und gibt keine Daten an Dritte weiter.
            Die Verarbeitung durch GitHub als Hoster erfolgt auf Grundlage von
            Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse am Betrieb der Website).
        </p>
        <p>
            Sie haben das Recht auf Auskunft, Berichtigung, Löschung und Einschränkung
            der Verarbeitung Ihrer Daten sowie das Recht auf Datenübertragbarkeit.
            Wenden Sie sich dazu an die oben genannte E-Mail-Adresse.
        </p>
        <p>
            Zuständige Aufsichtsbehörde:<br>
            Der Landesbeauftragte für den Datenschutz und die Informationsfreiheit Rheinland-Pfalz<br>
            <a href="https://www.datenschutz.rlp.de" target="_blank" rel="noopener noreferrer">www.datenschutz.rlp.de</a>
        </p>
    </div>

    <div class="imprint-block">
        <h3>Haftungsausschluss</h3>
        <p>
            Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte
            externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.
        </p>
    </div>

    <p style="margin-top:2rem;">
        <a href="/">← Zurück zur Startseite</a>
    </p>
</section>

<script>
// Render imprint email on canvas (same bot-protection as contact section)
(function () {
    var canvas = document.getElementById('imprint-email');
    if (!canvas) return;
    var style = getComputedStyle(document.documentElement);
    var color = style.getPropertyValue('--text-muted').trim() || '#6b7280';
    var font  = '16px Lucida Sans, Verdana, sans-serif';
    var addr  = 'hey\u0040fabianternis.de';
    var ctx   = canvas.getContext('2d');
    ctx.font  = font;
    canvas.width  = Math.ceil(ctx.measureText(addr).width) + 4;
    canvas.height = 22;
    ctx.font         = font;
    ctx.fillStyle    = color;
    ctx.textBaseline = 'middle';
    ctx.fillText(addr, 2, 11);
}());
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
