<?php

// ── Stack ──────────────────────────────────────────────────────────────────
$stack = [
    'PHP', 'Laravel', 'TailwindCSS', 'CSS3',
    'Blade (Laravel views)', 'JavaScript', 'MySQL', 'SQLite', 'Python',
];

// ── Projects ───────────────────────────────────────────────────────────────
$projects = [
    [
        'name'  => 'api-sandbox.de',
        'desc'  => 'A sandbox environment for testing and exploring APIs.',
        'img'   => 'assets/img/projects/api-sandbox.png',
        'links' => [
            ['label' => 'Live',   'url' => 'https://api-sandbox.de'],
            ['label' => 'GitHub', 'url' => 'https://github.com/api-sandbox-DE/api-sandbox.de'],
        ],
    ],
    [
        'name'  => 'httpclient.de',
        'desc'  => 'A local HTTP client tool for developers.',
        'img'   => 'assets/img/projects/httpclient.png',
        'links' => [
            ['label' => 'Live',   'url' => 'https://localhttpclient.de'],
            ['label' => 'GitHub', 'url' => 'https://github.com/httpclient-de'],
        ],
    ],
    [
        'name'  => 'Louixch.de',
        'desc'  => '...',
        'img'   => 'assets/img/projects/louixch.png',
        'links' => [
            ['label' => 'Live',   'url' => 'https://louixch.de'],
            ['label' => 'GitHub', 'url' => 'https://github.com/fabianternis/louixch.de'],
        ],
    ],
];

// ── Skills ─────────────────────────────────────────────────────────────────
// levels: expert | advanced | intermediate | beginner
$skills = [
    ['name' => 'PHP',         'category' => 'Back-End',   'level' => 'expert'],
    ['name' => 'Laravel',     'category' => 'Framework',  'level' => 'expert'],
    ['name' => 'MySQL',       'category' => 'Database',   'level' => 'advanced'],
    ['name' => 'SQLite',      'category' => 'Database',   'level' => 'advanced'],
    ['name' => 'TailwindCSS', 'category' => 'Styling',    'level' => 'advanced'],
    ['name' => 'CSS3',        'category' => 'Styling',    'level' => 'advanced'],
    ['name' => 'Python',      'category' => 'Back-End',   'level' => 'intermediate'],
    ['name' => 'JavaScript',  'category' => 'Front-End',  'level' => 'intermediate'],
    ['name' => 'Blade',       'category' => 'Templating', 'level' => 'expert'],
];

// ── Competitions / Wettbewerbe ─────────────────────────────────────────────
// Each entry may have an optional 'img' and 'img_title'.
// Multi-stage entries use 'stages'; single entries use top-level 'level', 'date', 'awards'.
$competitions = [
    [
        'category' => 'Mathematik/Informatik',
        'title'    => 'Mensa Bewertungssystem',
        'date'     => '31.01.2026',
        'level'    => 'Jugend forscht – Kaiserslautern',
        'awards'   => ['2. Preis Mathematik/Informatik'],
    ],
    [
        'category'  => 'Arbeitswelt',
        'title'     => 'Optimierung der Organisation und Ermöglichung von freiem Arbeiten in der JuFo-AG',
        'img'       => 'assets/img/wettbewerbe/2026-jufo-arbeitswelt.jpg',
        'img_title' => 'Jugend forscht – Arbeitswelt: Optimierung der JuFo-AG',
        'img_thumb' => 'half=r&w=400',
        'stages'    => [
            [
                'level'  => 'Jugend forscht – Mainz-Rheinhessen',
                'date'   => '20.02.2026',
                'awards' => ['Regionalsieg – 1. Preis Arbeitswelt'],
            ],
            [
                'level'  => 'Jugend forscht – Rheinland-Pfalz (Landeswettbewerb)',
                'date'   => '17.03.2026 – 19.03.2026',
                'awards' => ['3. Preis Arbeitswelt'],
            ],
        ],
    ],
];
