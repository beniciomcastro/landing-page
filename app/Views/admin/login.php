<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="icon" type="image/png" href="/assets/img/my_icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="admin-body">
  <div class="admin-controls login-controls">
    <button id="langToggle" class="lang-toggle admin-lang-toggle" type="button">PT</button>
    <button id="themeToggle" class="theme-toggle admin-theme-toggle" type="button" data-i18n="themeIndustrial">Industrial</button>
  </div>
  <canvas id="bgCanvas"></canvas>

  <form class="admin-card" method="POST" action="/admin/login">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <h1 data-i18n="loginTitle">Admin</h1>
    <p data-i18n="loginText">Sign in to manage your projects.</p>
    <?php if (!empty($error)): ?><strong class="error"><?= htmlspecialchars($error) ?></strong><?php endif; ?>
    <input type="email" name="email" placeholder="Email" data-i18n-placeholder="emailPlaceholder" required>
    <input type="password" name="password" placeholder="Password" data-i18n-placeholder="passwordPlaceholder" required>
    <button class="btn primary" type="submit" data-i18n="enter">Sign in</button>
    <a href="/" data-i18n="backSite">Back to site</a>
  </form>

  <footer class="site-footer admin-footer login-footer">
    <p><span>©</span> <span data-i18n="footerCredit">Developed by Benício Castro</span></p>
  </footer>

  <script src="/assets/js/background.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
