<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($project['title']) ?> - Project</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="icon" type="image/png" href="/assets/img/my_icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <button id="langToggle" class="lang-toggle public-lang-toggle" type="button" aria-label="Switch language">PT</button>
  <canvas id="bgCanvas"></canvas>

  <header class="navbar">
    <a href="/" class="brand"><img src="/assets/img/my_logo.png" alt="B7C Logo"></a>
    <nav>
      <a href="/" data-i18n="back">Back</a>
      <button id="themeToggle" class="theme-toggle" type="button" data-i18n="themeIndustrial">Industrial</button>
    </nav>
  </header>

  <main class="project-page section">
    <div class="project-detail reveal">
      <?php if (!empty($project['cover_image'])): ?>
        <img class="detail-image lightbox-trigger" src="<?= htmlspecialchars($project['cover_image']) ?>" alt="<?= htmlspecialchars($project['title']) ?> project image">
      <?php endif; ?>

      <p
        class="eyebrow project-tech-detail"
        data-project-tech-pt="<?= htmlspecialchars($project['technologies'] ?? '') ?>"
        data-project-tech-en="<?= htmlspecialchars($project['technologies_en'] ?? $project['technologies'] ?? '') ?>">
        <?= htmlspecialchars($project['technologies_en'] ?? $project['technologies']) ?>
      </p>
      <h1><?= htmlspecialchars($project['title']) ?></h1>
      <p
        class="project-description-detail"
        data-project-description-pt="<?= htmlspecialchars($project['description'] ?? '') ?>"
        data-project-description-en="<?= htmlspecialchars($project['description_en'] ?? $project['description'] ?? '') ?>">
        <?= nl2br(htmlspecialchars($project['description_en'] ?? $project['description'])) ?>
      </p>

      <div class="actions">
        <?php if (!empty($project['github_url'])): ?>
          <a class="btn primary" href="<?= htmlspecialchars($project['github_url']) ?>" target="_blank" rel="noopener noreferrer" data-i18n="github">GitHub</a>
        <?php endif; ?>
        <?php if (!empty($project['demo_url'])): ?>
          <a class="btn secondary" href="<?= htmlspecialchars($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer" data-i18n="demo">Demo</a>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer class="site-footer">
    <p><span>©</span> <span data-i18n="footerCredit">Developed by Benício Castro</span></p>
  </footer>

  <div id="lightbox" class="lightbox">
    <button class="lightbox-close" type="button">&times;</button>
    <img id="lightboxImage" src="" alt="Expanded project image">
  </div>

  <script src="/assets/js/background.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
