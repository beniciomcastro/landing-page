<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $project ? 'Edit Project' : 'New Project' ?></title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="icon" type="image/png" href="/assets/img/my_icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="admin-page">
  <canvas id="bgCanvas"></canvas>
  <div class="admin-controls">
    <button id="langToggle" class="lang-toggle admin-lang-toggle" type="button">PT</button>
    <button id="themeToggle" class="theme-toggle admin-theme-toggle" type="button" data-i18n="themeIndustrial">Industrial</button>
  </div>

  <aside class="admin-sidebar">
    <h2><a href="/admin" class="brand"><img src="/assets/img/my_logo.png" alt="B7C Logo"></a></h2>
    <a href="/admin" class="sidebar-links" data-i18n="dashboardTitle">Projects</a>
    <form class="logout-form" method="POST" action="/admin/logout">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <button class="sidebar-links" type="submit" data-i18n="logout">Logout</button>
    </form>
  </aside>

  <main class="admin-main">
    <h1 data-i18n="<?= $project ? 'formEdit' : 'formNew' ?>"><?= $project ? 'Edit Project' : 'New Project' ?></h1>

    <form class="project-form" method="POST" enctype="multipart/form-data" action="<?= $project ? '/admin/projects/' . $project['id'] . '/update' : '/admin/projects/store' ?>">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <label><span data-i18n="labelTitle">Title</span>
        <input name="title" maxlength="160" value="<?= htmlspecialchars($project['title'] ?? '') ?>" required>
      </label>

      <label><span data-i18n="labelPhoto">Project image</span>
        <input name="cover_image" type="file" accept="image/png,image/jpeg,image/webp">
      </label>

      <?php if (!empty($project['cover_image'])): ?>
        <img class="admin-preview" src="<?= htmlspecialchars($project['cover_image']) ?>" alt="Current project image">
      <?php endif; ?>

      <label><span data-i18n="labelShort">Short description (PT)</span>
        <input name="short_description" maxlength="255" value="<?= htmlspecialchars($project['short_description'] ?? '') ?>" required>
      </label>

      <label><span data-i18n="labelShortEn">Short description (EN)</span>
        <input name="short_description_en" maxlength="255" value="<?= htmlspecialchars($project['short_description_en'] ?? $project['short_description'] ?? '') ?>" required>
      </label>

      <label><span data-i18n="labelFull">Full description (PT)</span>
        <textarea name="description" required><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
      </label>

      <label><span data-i18n="labelFullEn">Full description (EN)</span>
        <textarea name="description_en" required><?= htmlspecialchars($project['description_en'] ?? $project['description'] ?? '') ?></textarea>
      </label>

      <label><span data-i18n="labelTech">Technologies (PT)</span>
        <input name="technologies" maxlength="255" value="<?= htmlspecialchars($project['technologies'] ?? '') ?>" required>
      </label>

      <label><span data-i18n="labelTechEn">Technologies (EN)</span>
        <input name="technologies_en" maxlength="255" value="<?= htmlspecialchars($project['technologies_en'] ?? $project['technologies'] ?? '') ?>" required>
      </label>

      <label><span data-i18n="labelGithub">GitHub link</span>
        <input name="github_url" type="url" value="<?= htmlspecialchars($project['github_url'] ?? '') ?>">
      </label>

      <label><span data-i18n="labelDemo">Demo link</span>
        <input name="demo_url" type="url" value="<?= htmlspecialchars($project['demo_url'] ?? '') ?>">
      </label>

      <label><span data-i18n="labelStatus">Status (PT)</span>
        <input name="status" maxlength="80" value="<?= htmlspecialchars($project['status'] ?? 'Published') ?>">
      </label>

      <label><span data-i18n="labelStatusEn">Status (EN)</span>
        <input name="status_en" maxlength="80" value="<?= htmlspecialchars($project['status_en'] ?? 'Published') ?>">
      </label>

      <label><span data-i18n="labelYear">Year</span>
        <input name="project_year" type="number" min="2020" max="2100" value="<?= htmlspecialchars($project['project_year'] ?? date('Y')) ?>">
      </label>

      <button class="btn primary" type="submit" data-i18n="save">Save</button>
    </form>
  </main>

  <footer class="site-footer admin-footer">
    <p><span>©</span> <span data-i18n="footerCredit">Developed by Benício Castro</span></p>
  </footer>

  <script src="/assets/js/background.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
