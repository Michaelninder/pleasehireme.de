<?php
// $stack, $projects, $skills, $competitions must be in scope (passed from router)
?>

<!-- ── Hero ── -->
<section class="section__hero" id="hero">
    <h1>Please hire <span class="highlight">ME</span>!</h1>
    <h5 class="domain-subtitle">pleasehireme.de</h5>
</section>

<!-- ── About ── -->
<section class="section__about" id="about">
    <span class="section-indicator">#about</span>
    <h2>About ME</h2>
    <p>I am <span class="highligh">Fabian Ternis</span>, a <span class="highligh">German</span> Developer, mainly focused on <span class="highlight">Back-End</span> ...</p>
</section>

<!-- ── Stack ── -->
<section class="section__stack" id="stack">
    <span class="section-indicator">#stack</span>
    <h2>My Tech Stack</h2>
    <ul>
        <?php foreach ($stack as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
        <li class="note">and more ...</li>
    </ul>
</section>

<!-- ── Projects ── -->
<section class="section__projects" id="projects">
    <span class="section-indicator">#projects</span>
    <h2>Some of my (wayy too many) Projects</h2>
    <ul class="projects-list">
        <?php foreach ($projects as $project): ?>
        <li class="project-card">
            <?php if (!empty($project['img'])): ?>
                <img class="project-card__img"
                     src="/img?src=<?= urlencode($project['img']) ?>&w=720"
                     data-fullsrc="/img?src=<?= urlencode($project['img']) ?>&w=1400"
                     alt="<?= htmlspecialchars($project['name']) ?> preview"
                     data-lightbox>
            <?php endif; ?>
            <div class="project-card__header">
                <span class="project-card__name"><?= htmlspecialchars($project['name']) ?></span>
            </div>
            <p class="project-card__desc"><?= htmlspecialchars($project['desc']) ?></p>
            <div class="project-card__links">
                <?php foreach ($project['links'] as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer">
                        <?= htmlspecialchars($link['label']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </li>
        <?php endforeach; ?>
        <li class="project-card project-card--more"><span>and many more ...</span></li>
    </ul>
</section>

<!-- ── Skills ── -->
<section class="section__skills" id="skills">
    <span class="section-indicator">#skills</span>
    <h2>Skills &amp; Proficiency</h2>
    <div class="skills-filters">
        <button class="skills-filter is-active" data-filter="all">All</button>
        <?php foreach (array_unique(array_column($skills, 'category')) as $cat): ?>
            <button class="skills-filter" data-filter="<?= htmlspecialchars($cat) ?>">
                <?= htmlspecialchars($cat) ?>
            </button>
        <?php endforeach; ?>
    </div>
    <table class="skills-table">
        <thead>
            <tr><th>Skill</th><th>Category</th><th>Level</th></tr>
        </thead>
        <tbody>
            <?php foreach ($skills as $skill): ?>
            <tr data-category="<?= htmlspecialchars($skill['category']) ?>">
                <td><?= htmlspecialchars($skill['name']) ?></td>
                <td><?= htmlspecialchars($skill['category']) ?></td>
                <td><span class="level level--<?= htmlspecialchars($skill['level']) ?>">
                    <?= ucfirst(htmlspecialchars($skill['level'])) ?>
                </span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- ── Wettbewerbe ── -->
<section class="section__wettbewerbe" id="wettbewerbe">
    <span class="section-indicator">#wettbewerbe</span>
    <h2>Wettbewerbe</h2>
    <div class="competition-list">
        <?php foreach ($competitions as $comp): ?>
        <div class="competition__item">
            <div class="competition__meta">
                <span class="competition__category"><?= htmlspecialchars($comp['category']) ?></span>
                <?php if (!empty($comp['date'])): ?>
                    <span class="competition__date"><?= htmlspecialchars($comp['date']) ?></span>
                <?php endif; ?>
            </div>
            <h3><?= htmlspecialchars($comp['title']) ?></h3>

            <?php if (!empty($comp['img'])): ?>
                <?php $thumbParams = $comp['img_thumb'] ?? 'w=400'; ?>
                <img class="competition__img competition__img--desktop"
                     src="/img?src=<?= urlencode($comp['img']) ?>&<?= htmlspecialchars($thumbParams) ?>"
                     data-fullsrc="/img?src=<?= urlencode($comp['img']) ?>&w=1200"
                     alt="<?= htmlspecialchars($comp['title']) ?>"
                     data-lightbox
                     <?php if (!empty($comp['img_title'])): ?>data-title="<?= htmlspecialchars($comp['img_title']) ?>"<?php endif; ?>>
                <img class="competition__img competition__img--mobile"
                     src="/img?src=<?= urlencode($comp['img']) ?>&w=800"
                     data-fullsrc="/img?src=<?= urlencode($comp['img']) ?>&w=1200"
                     alt="<?= htmlspecialchars($comp['title']) ?>"
                     data-lightbox
                     <?php if (!empty($comp['img_title'])): ?>data-title="<?= htmlspecialchars($comp['img_title']) ?>"<?php endif; ?>>
            <?php endif; ?>

            <?php if (!empty($comp['stages'])): ?>
                <div class="competition__stages">
                    <?php foreach ($comp['stages'] as $stage): ?>
                    <div class="competition__stage">
                        <span class="competition__level"><?= htmlspecialchars($stage['level']) ?></span>
                        <?php if (!empty($stage['date'])): ?>
                            <span class="competition__date"><?= htmlspecialchars($stage['date']) ?></span>
                        <?php endif; ?>
                        <ul class="competition__awards">
                            <?php foreach ($stage['awards'] as $award): ?>
                                <li><?= htmlspecialchars($award) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <?php if (!empty($comp['level'])): ?>
                    <span class="competition__level"><?= htmlspecialchars($comp['level']) ?></span>
                <?php endif; ?>
                <?php if (!empty($comp['awards'])): ?>
                    <ul class="competition__awards">
                        <?php foreach ($comp['awards'] as $award): ?>
                            <li><?= htmlspecialchars($award) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ── Availability ── -->
<section class="section__availability" id="availability">
    <span class="section-indicator">#availability</span>
    <h2>Availability</h2>
    <p>I am currently <span class="highlight">open to new opportunities</span>. Feel free to reach out if you think I'd be a good fit for your team.</p>
</section>

<!-- ── Contact ── -->
<section class="section__contact" id="contact">
    <span class="section-indicator">#contact</span>
    <h2>Contact</h2>
    <ul class="contact-list">
        <li>
            <span class="contact-label">Email</span>
            <canvas class="email-canvas" id="email-1" aria-label="hey [at] fabianternis.de"></canvas>
        </li>
        <li>
            <span class="contact-label">Email (work)</span>
            <canvas class="email-canvas" id="email-2" aria-label="f.ternix [at] xpsystems.eu"></canvas>
        </li>
        <li>
            <span class="contact-label">GitHub</span>
            <a class="contact-link" href="https://github.com/michaelninder" target="_blank" rel="noopener noreferrer">github.com/michaelninder</a>
        </li>
        <li>
            <span class="contact-label">Instagram</span>
            <a class="contact-link" href="https://instagram.com/ternisfabian" target="_blank" rel="noopener noreferrer">@ternisfabian</a>
        </li>
    </ul>
</section>
