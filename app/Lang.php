<?php

class Lang
{
    private static array $strings = [];
    private static string $locale = 'en';

    private static array $translations = [
        'en' => [
            'nav.about'        => 'About',
            'nav.projects'     => 'Projects',
            'nav.skills'       => 'Skills',
            'nav.availability' => 'Availability',
            'nav.contact'      => 'Contact',

            'hero.title'       => 'Please hire <span class="highlight">ME</span>!',
            'hero.subtitle'    => 'pleasehireme.de',

            'about.indicator'  => '#about',
            'about.heading'    => 'About ME',
            'about.body'       => 'I am <span class="highligh">Fabian Ternis</span>, a <span class="highligh">German</span> Developer, mainly focused on <span class="highlight">Back-End</span> ...',

            'stack.indicator'  => '#stack',
            'stack.heading'    => 'My Tech Stack',

            'projects.indicator' => '#projects',
            'projects.heading'   => 'Some of my (wayy too many) Projects',
            'projects.more'      => 'and many more ...',
            'projects.live'      => 'Live',

            'skills.indicator'   => '#skills',
            'skills.heading'     => 'Skills & Proficiency',
            'skills.col.skill'   => 'Skill',
            'skills.col.cat'     => 'Category',
            'skills.col.level'   => 'Level',
            'skills.filter.all'  => 'All',

            'availability.indicator' => '#availability',
            'availability.heading'   => 'Availability',
            'availability.body'      => 'I am currently <span class="highlight">open to new opportunities</span>. Feel free to reach out if you think I\'d be a good fit for your team.',

            'contact.indicator' => '#contact',
            'contact.heading'   => 'Contact',
            'contact.email'     => 'Email',
            'contact.email_work'=> 'Email (work)',

            'footer.imprint'    => 'Imprint',
            'footer.lang_de'    => 'DE',
            'footer.lang_en'    => 'EN',

            'imprint.title'     => 'Imprint',
        ],

        'de' => [
            'nav.about'        => 'Über mich',
            'nav.projects'     => 'Projekte',
            'nav.skills'       => 'Fähigkeiten',
            'nav.wettbewerbe'  => 'Wettbewerbe',
            'nav.availability' => 'Verfügbarkeit',
            'nav.contact'      => 'Kontakt',

            'hero.title'       => 'Bitte stell mich ein <span class="highlight">!</span>',
            'hero.subtitle'    => 'pleasehireme.de',

            'about.indicator'  => '#about',
            'about.heading'    => 'Über mich',
            'about.body'       => 'Ich bin <span class="highligh">Fabian Ternis</span>, ein <span class="highligh">deutscher</span> Entwickler, hauptsächlich fokussiert auf <span class="highlight">Back-End</span> ...',

            'stack.indicator'  => '#stack',
            'stack.heading'    => 'Mein Tech-Stack',

            'projects.indicator' => '#projects',
            'projects.heading'   => 'Einige meiner (viel zu vielen) Projekte',
            'projects.more'      => 'und viele mehr ...',
            'projects.live'      => 'Live',

            'skills.indicator'   => '#skills',
            'skills.heading'     => 'Fähigkeiten & Kenntnisse',
            'skills.col.skill'   => 'Fähigkeit',
            'skills.col.cat'     => 'Kategorie',
            'skills.col.level'   => 'Level',
            'skills.filter.all'  => 'Alle',

            'wettbewerbe.indicator' => '#wettbewerbe',
            'wettbewerbe.heading'   => 'Wettbewerbe',

            'availability.indicator' => '#availability',
            'availability.heading'   => 'Verfügbarkeit',
            'availability.body'      => 'Ich bin derzeit <span class="highlight">offen für neue Möglichkeiten</span>. Melde dich gerne, wenn du denkst, dass ich gut in dein Team passe.',

            'contact.indicator' => '#contact',
            'contact.heading'   => 'Kontakt',
            'contact.email'     => 'E-Mail',
            'contact.email_work'=> 'E-Mail (Arbeit)',

            'footer.imprint'    => 'Impressum',
            'footer.lang_de'    => 'DE',
            'footer.lang_en'    => 'EN',

            'imprint.title'     => 'Impressum',
        ],
    ];

    public static function init(string $locale): void
    {
        self::$locale  = in_array($locale, ['de', 'en']) ? $locale : 'en';
        self::$strings = self::$translations[self::$locale];
    }

    public static function get(string $key, string $fallback = ''): string
    {
        return self::$strings[$key] ?? self::$translations['en'][$key] ?? $fallback;
    }

    public static function locale(): string
    {
        return self::$locale;
    }

    /** Detect preferred locale from Accept-Language header */
    public static function detectLocale(): string
    {
        $header = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en';
        // Check if German is preferred
        if (preg_match('/\bde\b/i', strtok($header, ','))) {
            return 'de';
        }
        return 'en';
    }
}
