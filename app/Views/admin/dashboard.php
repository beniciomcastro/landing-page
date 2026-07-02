<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
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
    <a href="/admin/projects/new" class="sidebar-links" data-i18n="newProject">New Project</a>
    <form class="logout-form" method="POST" action="/admin/logout">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <button class="sidebar-links" type="submit" data-i18n="logout">Logout</button>
    </form>
  </aside>

  <main class="admin-main">
    <div class="admin-top">
      <h1 data-i18n="dashboardTitle">Projects</h1>
      <a class="btn primary" href="/admin/projects/new" data-i18n="register">Create</a>
    </div>

    <div class="admin-table">
      <?php if (empty($projects)): ?>
        <div class="empty-state">
          <strong data-i18n="emptyAdminTitle">No projects registered yet.</strong>
          <p data-i18n="emptyAdminText">Click “Create” to add the first project to the landing page.</p>
        </div>
      <?php endif; ?>

      <?php foreach ($projects as $project): ?>
        <div class="admin-row">
          <div>
            <strong><?= htmlspecialchars($project['title']) ?></strong>
            <p data-project-tech-pt="<?= htmlspecialchars($project['technologies'] ?? '') ?>" data-project-tech-en="<?= htmlspecialchars($project['technologies_en'] ?? $project['technologies'] ?? '') ?>"><?= htmlspecialchars($project['technologies_en'] ?? $project['technologies']) ?></p>
          </div>
          <div class="row-actions">
            <a href="/admin/projects/<?= $project['id'] ?>/edit" data-i18n="edit">Edit</a>
            <form method="POST" action="/admin/projects/<?= $project['id'] ?>/delete" onsubmit="return confirm('Delete project?')">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
              <button type="submit" data-i18n="delete">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="site-footer admin-footer">
    <p><span>©</span> <span data-i18n="footerCredit">Developed by Benício Castro</span></p>
  </footer>

  <script src="/assets/js/background.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
