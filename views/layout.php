<?php
// Expected vars: $title (string), $content (string)
$title   = $title   ?? 'Please hire me (.de)';
$content = $content ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<nav class="navbar" id="navbar">
    <div class="nav-logo">pleasehireme</div>
    <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
    <div class="nav-links__container" id="nav-menu">
        <span class="nav-indicator" id="nav-indicator"></span>
        <ul class="nav-links__list">
            <li class="nav-link__item"><a href="/#about"        class="nav-link__link">About</a></li>
            <li class="nav-link__item"><a href="/#projects"     class="nav-link__link">Projects</a></li>
            <li class="nav-link__item"><a href="/#skills"       class="nav-link__link">Skills</a></li>
            <li class="nav-link__item"><a href="/#wettbewerbe"  class="nav-link__link">Wettbewerbe</a></li>
            <li class="nav-link__item"><a href="/#availability" class="nav-link__link">Availability</a></li>
            <li class="nav-link__item"><a href="/#contact"      class="nav-link__link">Contact</a></li>
        </ul>
    </div>
</nav>

<?= $content ?>

<footer class="footer">
    <span class="footer__copy">&copy; <?= date('Y') ?> pleasehireme.de &mdash;
        <a href="https://fabianternis.de" target="_blank" rel="noopener noreferrer">Fabian Ternis</a>
    </span>
    <div class="footer__links">
        <a href="/imprint">Imprint</a>
    </div>
</footer>

<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image preview">
    <button class="lightbox__close" id="lightbox-close" aria-label="Close">&times;</button>
    <figure class="lightbox__figure">
        <img class="lightbox__img" id="lightbox-img" src="" alt="">
        <figcaption class="lightbox__caption" id="lightbox-caption"></figcaption>
    </figure>
</div>

<script src="/assets/js/app.js"></script>
</body>
</html>
