<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>B7C - Landing Page</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="icon" type="image/png" href="/assets/img/my_icon.png">
</head>
<body>
  <button id="langToggle" class="lang-toggle public-lang-toggle" type="button" aria-label="Switch language">PT</button>
  <canvas id="bgCanvas"></canvas>

  <header class="navbar">
    <a href="/" class="brand">
      <img src="/assets/img/my_logo.png" alt="B7C Logo">
    </a>
    <nav>
      <a href="#about" data-i18n="navAbout">About</a>
      <a href="#projects" data-i18n="navProjects">Projects</a>
      <a href="#admin" data-i18n="navPanel">Panel</a>
      <a href="#skills" data-i18n="navSkills">Skills</a>
      <a href="#contact" data-i18n="navContact">Contact</a>
      <button id="themeToggle" class="theme-toggle" type="button" data-i18n="themeIndustrial">Industrial</button>
    </nav>
  </header>

  <main>
    <section class="hero section">
      <div class="hero-content reveal">
        <p class="eyebrow" data-i18n="heroEyebrow">Frontend • Backend • Database</p>
        <h1><span class="hero-intro" data-i18n="heroIntro">Hi, I am</span><br><span data-i18n="heroName">Benício Castro.</span></h1>
        <p class="hero-text" data-i18n="heroText">Developer in training, building modern interfaces, database-driven systems and premium digital experiences.</p>
        <div class="actions">
          <a href="#projects" class="btn primary" data-i18n="viewProjects">View projects</a>
          <a href="#contact" class="btn secondary" data-i18n="contact">Contact</a>
        </div>
      </div>

      <div class="hero-card reveal">
        <div class="orb"></div>
        <span class="hero-badge" data-i18n="available">● Available for projects</span>
        <h2 data-i18n="heroCardTitle">Full Stack Developer</h2>
        <p data-i18n="heroCardText">Development of modern applications using HTML, CSS, JavaScript, PHP, MySQL and Docker.</p>
        <div class="hero-techs">
          <a href="#skills">PHP</a>
          <a href="#skills">MySQL</a>
          <a href="#skills">Docker</a>
          <a href="#skills">JavaScript</a>
        </div>
      </div>
    </section>

    <section id="about" class="section about reveal">
      <div>
        <p class="eyebrow" data-i18n="aboutEyebrow">About me</p>
        <h2 data-i18n="aboutTitle">I like turning ideas into real projects.</h2>
      </div>
      <p class="about-text" data-i18n="aboutText">I am Benício Castro, a Web Development student passionate about technology. My goal is to keep evolving as a full stack developer, creating modern, functional and well-structured applications. Currently, my studies focus on HTML, CSS, JavaScript, PHP, MySQL, Docker and development best practices. This landing page was built to present my projects and demonstrate not only frontend skills, but also my ability to build complete systems, including backend, database, authentication, admin panel and application architecture. I am always looking for new challenges and opportunities to turn ideas into real solutions through programming.</p>
    </section>

    <section id="projects" class="section reveal">
      <div class="section-title">
        <p class="eyebrow" data-i18n="projectsEyebrow">Projects</p>
        <h2 data-i18n="myWorks">My work</h2>
      </div>

      <?php if (empty($projects)): ?>
        <div class="empty-public">
          <h3 data-i18n="noProjectsTitle">No projects published yet.</h3>
          <p data-i18n="noProjectsText">Use the admin panel to add projects with image, description, technologies and links.</p>
        </div>
      <?php endif; ?>

      <div class="project-grid">
        <?php foreach ($projects as $project): ?>
          <article class="project-card tilt-card">
            <?php if (!empty($project['cover_image'])): ?>
              <img class="project-image" src="<?= htmlspecialchars($project['cover_image']) ?>" alt="Project image for <?= htmlspecialchars($project['title']) ?>">
            <?php else: ?>
              <div class="project-cover"><?= htmlspecialchars(strtoupper(substr($project['title'], 0, 2))) ?></div>
            <?php endif; ?>

            <div class="project-body">
              <span
                data-project-status-pt="<?= htmlspecialchars($project['status'] ?? '') ?>"
                data-project-status-en="<?= htmlspecialchars($project['status_en'] ?? $project['status'] ?? '') ?>"
                data-project-year="<?= htmlspecialchars((string) $project['project_year']) ?>">
                <?= htmlspecialchars($project['status_en'] ?? $project['status']) ?> • <?= htmlspecialchars((string) $project['project_year']) ?>
              </span>
              <h3><?= htmlspecialchars($project['title']) ?></h3>
              <p
                data-project-short-pt="<?= htmlspecialchars($project['short_description'] ?? '') ?>"
                data-project-short-en="<?= htmlspecialchars($project['short_description_en'] ?? $project['short_description'] ?? '') ?>">
                <?= htmlspecialchars($project['short_description_en'] ?? $project['short_description']) ?>
              </p>
              <small
                data-project-tech-pt="<?= htmlspecialchars($project['technologies'] ?? '') ?>"
                data-project-tech-en="<?= htmlspecialchars($project['technologies_en'] ?? $project['technologies'] ?? '') ?>">
                <?= htmlspecialchars($project['technologies_en'] ?? $project['technologies']) ?>
              </small>
              <a href="/project/<?= htmlspecialchars($project['slug']) ?>"><span data-i18n="details">View details →</span></a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="admin" class="section admin-showcase reveal">
      <div class="section-title">
        <p class="eyebrow" data-i18n="backend">Backend</p>
        <h2 data-i18n="adminPanel">Admin Panel</h2>
      </div>

      <div class="admin-showcase-grid">
        <div class="admin-image admin-image-frame">
          <img class="admin-preview-image admin-theme-image admin-theme-image-cyber" src="/assets/img/admin-cyber.png" alt="Cyber admin panel screenshot">
          <img class="admin-preview-image admin-theme-image admin-theme-image-industrial" src="/assets/img/admin-industrial.png" alt="Industrial admin panel screenshot">
        </div>

        <div class="admin-content">
          <h3 data-i18n="adminShowTitle">Complete project management</h3>
          <p data-i18n="adminShowText">This landing page has an exclusive admin panel to create, edit and delete projects automatically displayed on the website.</p>
          <ul>
            <li data-i18n="adminFeatureLogin">Login protected by authentication</li>
            <li data-i18n="adminFeatureDb">MySQL database</li>
            <li data-i18n="adminFeatureCreate">Create new projects</li>
            <li data-i18n="adminFeatureUpload">Image upload</li>
            <li data-i18n="adminFeatureEdit">Edit and delete projects</li>
          </ul>
          <p class="admin-note" data-i18n="adminNote">Panel access is restricted to the administrator.</p>
        </div>
      </div>
    </section>

    <section id="skills" class="section skills reveal">
      <div class="section-title">
        <p class="eyebrow" data-i18n="skillsEyebrow">Skills</p>
        <h2 data-i18n="techs">Technologies</h2>
      </div>

      <div class="skills-grid">
        <div class="skill-card skill-modal-btn" data-skill="html"><i class="bi bi-filetype-html"></i><span>HTML</span></div>
        <div class="skill-card skill-modal-btn" data-skill="css"><i class="bi bi-filetype-css"></i><span>CSS</span></div>
        <div class="skill-card skill-modal-btn" data-skill="javascript"><i class="bi bi-filetype-js"></i><span>JavaScript</span></div>
        <div class="skill-card skill-modal-btn" data-skill="php"><i class="bi bi-filetype-php"></i><span>PHP</span></div>
        <div class="skill-card skill-modal-btn" data-skill="mysql"><i class="bi bi-database"></i><span>MySQL</span></div>
        <div class="skill-card skill-modal-btn" data-skill="docker"><i class="bi bi-box-seam"></i><span>Docker</span></div>
        <div class="skill-card skill-modal-btn" data-skill="git"><i class="bi bi-git"></i><span>Git</span></div>
        <div class="skill-card skill-modal-btn" data-skill="linux"><i class="bi bi-terminal"></i><span>Linux</span></div>
      </div>
    </section>

    <section id="contact" class="section contact reveal">
      <p class="eyebrow" data-i18n="navContact">Contact</p>
      <h2 data-i18n="contactTitle">Let's talk?</h2>
      <p data-i18n="contactText">You can contact me by email or follow my projects on GitHub.</p>
      <div class="actions">
        <a class="btn primary" href="mailto:beniciomcastro@gmail.com?subject=Contact%20via%20Landing%20Page&body=Hello%20Ben%C3%ADcio,%0A%0AI%20found%20your%20landing%20page%20and%20would%20like%20to%20talk%20about%20a%20project.%0A%0ABest%20regards.%0A" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-envelope-fill"></i>
          <span data-i18n="sendEmail">Send email</span>
        </a>
        <a class="btn secondary" href="https://github.com/beniciomcastro" target="_blank" rel="noopener noreferrer"><i class="bi bi-github"></i><span>GitHub</span></a>
        <a class="btn secondary" href="https://www.linkedin.com/in/beniciocastro/" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i><span>LinkedIn</span></a>
      </div>
    </section>
  </main>

  <div class="skill-modal" id="skillModal">
    <div class="skill-modal-content">
      <button class="skill-modal-close" type="button">&times;</button>
      <h3 id="skillModalTitle"></h3>
      <p id="skillModalText"></p>
      <a id="skillModalLink" href="#" target="_blank" rel="noopener noreferrer">Official documentation →</a>
    </div>
  </div>

  <button id="scrollTopBtn" class="scroll-top-btn" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

  <div id="lightbox" class="lightbox">
    <button class="lightbox-close" type="button">&times;</button>
    <img id="lightboxImage" src="" alt="Expanded image">
  </div>

  <footer class="site-footer">
    <p><span>©</span> <span data-i18n="footerCredit">Developed by Benício Castro</span></p>
  </footer>

  <script src="/assets/js/background.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
