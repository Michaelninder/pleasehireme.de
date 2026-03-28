<?php
$title   = $title   ?? 'Please hire me (.de)';
$content = $content ?? '';
$locale  = Lang::locale();
$isDE    = $locale === 'de';
?>
<!DOCTYPE html>
<html lang="<?= $locale ?>">
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
            <li class="nav-link__item"><a href="/#about"        class="nav-link__link"><?= Lang::get('nav.about') ?></a></li>
            <li class="nav-link__item"><a href="/#projects"     class="nav-link__link"><?= Lang::get('nav.projects') ?></a></li>
            <li class="nav-link__item"><a href="/#skills"       class="nav-link__link"><?= Lang::get('nav.skills') ?></a></li>
            <?php if ($isDE): ?>
            <li class="nav-link__item"><a href="/#wettbewerbe"  class="nav-link__link"><?= Lang::get('nav.wettbewerbe') ?></a></li>
            <?php endif; ?>
            <li class="nav-link__item"><a href="/#availability" class="nav-link__link"><?= Lang::get('nav.availability') ?></a></li>
            <li class="nav-link__item"><a href="/#contact"      class="nav-link__link"><?= Lang::get('nav.contact') ?></a></li>
        </ul>
    </div>
</nav>

<?= $content ?>

<footer class="footer">
    <div class="footer__inner">

        <!-- Col 1: Brand -->
        <div class="footer__section footer__section--brand">
            <span class="footer__logo">pleasehireme.de</span>
            <p class="footer__tagline">Open for new opportunities.</p>
            <p class="footer__copy">&copy; <?= date('Y') ?> <a href="https://fabianternis.de" target="_blank" rel="noopener noreferrer">Fabian Ternis</a></p>
        </div>

        <!-- Col 2: Navigation -->
        <div class="footer__section">
            <h4 class="footer__heading"><?= Lang::get('nav.about') ?></h4>
            <nav class="footer__nav">
                <a href="/#about"><?= Lang::get('nav.about') ?></a>
                <a href="/#projects"><?= Lang::get('nav.projects') ?></a>
                <a href="/#skills"><?= Lang::get('nav.skills') ?></a>
                <?php if ($isDE): ?>
                <a href="/#wettbewerbe"><?= Lang::get('nav.wettbewerbe') ?></a>
                <?php endif; ?>
                <a href="/#availability"><?= Lang::get('nav.availability') ?></a>
                <a href="/#contact"><?= Lang::get('nav.contact') ?></a>
            </nav>
        </div>

        <!-- Col 3: Legal + Locale -->
        <div class="footer__section">
            <h4 class="footer__heading"><?= $isDE ? 'Rechtliches' : 'Legal' ?></h4>
            <nav class="footer__nav">
                <a href="/imprint"><?= Lang::get('footer.imprint') ?></a>
            </nav>

            <h4 class="footer__heading" style="margin-top:1.25rem;"><?= $isDE ? 'Sprache' : 'Language' ?></h4>
            <div class="lang-switcher" id="lang-switcher">
                <button class="lang-switcher__btn" id="lang-btn" aria-haspopup="listbox" aria-expanded="false">
                    <span><?= Lang::locale() === 'de' ? 'DE — Deutsch' : 'EN — English' ?></span>
                    <svg class="lang-switcher__arrow" width="8" height="5" viewBox="0 0 8 5" fill="none" aria-hidden="true">
                        <path d="M1 1l3 3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <!-- desktop dropdown -->
                <ul class="lang-switcher__menu" id="lang-menu" role="listbox">
                    <li class="lang-switcher__option <?= Lang::locale() === 'en' ? 'is-active' : '' ?>" data-lang="en" role="option">EN — English</li>
                    <li class="lang-switcher__option <?= Lang::locale() === 'de' ? 'is-active' : '' ?>" data-lang="de" role="option">DE — Deutsch</li>
                </ul>
            </div>

            <!-- mobile popover -->
            <div class="lang-popover" id="lang-popover" aria-hidden="true">
                <div class="lang-popover__backdrop" id="lang-popover-backdrop"></div>
                <div class="lang-popover__sheet">
                    <p class="lang-popover__title"><?= $isDE ? 'Sprache wählen' : 'Select language' ?></p>
                    <ul class="lang-popover__list">
                        <li class="lang-popover__option <?= Lang::locale() === 'en' ? 'is-active' : '' ?>" data-lang="en">
                            <span>EN</span><span>English</span>
                            <?php if (Lang::locale() === 'en'): ?><svg width="14" height="10" viewBox="0 0 14 10" fill="none"><path d="M1 5l4 4L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><?php endif; ?>
                        </li>
                        <li class="lang-popover__option <?= Lang::locale() === 'de' ? 'is-active' : '' ?>" data-lang="de">
                            <span>DE</span><span>Deutsch</span>
                            <?php if (Lang::locale() === 'de'): ?><svg width="14" height="10" viewBox="0 0 14 10" fill="none"><path d="M1 5l4 4L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="footer__bar">
        <span>Built with PHP &amp; vanilla JS &mdash; no frameworks, no trackers.</span>
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
