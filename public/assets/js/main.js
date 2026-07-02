/*
  Main browser script.
  Responsibilities: theme switching, language switching, reveal animations,
  card tilt, skill modal, scroll-to-top and image lightbox.
*/
document.addEventListener("DOMContentLoaded", () => {
  const translations = {
    en: {
      themeIndustrial: "Industrial",
      themeCyber: "Cyber",
      languageButton: "PT",
      navAbout: "About",
      navProjects: "Projects",
      navPanel: "Panel",
      navSkills: "Skills",
      navContact: "Contact",
      back: "Back",
      heroEyebrow: "Frontend • Backend • Database",
      heroIntro: "Hi, I am",
      heroName: "Benício Castro.",
      heroText: "Developer in training, building modern interfaces, database-driven systems and premium digital experiences.",
      viewProjects: "View projects",
      contact: "Contact",
      available: "● Available for projects",
      heroCardTitle: "Full Stack Developer",
      heroCardText: "Development of modern applications using HTML, CSS, JavaScript, PHP, MySQL and Docker.",
      aboutEyebrow: "About me",
      aboutTitle: "I like turning ideas into real projects.",
      aboutText: "I am Benício Castro, a Web Development student passionate about technology. My goal is to keep evolving as a full stack developer, creating modern, functional and well-structured applications. Currently, my studies focus on HTML, CSS, JavaScript, PHP, MySQL, Docker and development best practices. This landing page was built to present my projects and demonstrate not only frontend skills, but also my ability to build complete systems, including backend, database, authentication, admin panel and application architecture. I am always looking for new challenges and opportunities to turn ideas into real solutions through programming.",
      projectsEyebrow: "Projects",
      myWorks: "My work",
      noProjectsTitle: "No projects published yet.",
      noProjectsText: "Use the admin panel to add projects with image, description, technologies and links.",
      details: "View details →",
      backend: "Backend",
      adminPanel: "Admin Panel",
      adminShowTitle: "Complete project management",
      adminShowText: "This landing page has an exclusive admin panel to create, edit and delete projects automatically displayed on the website.",
      adminFeatureLogin: "Login protected by authentication",
      adminFeatureDb: "MySQL database",
      adminFeatureCreate: "Create new projects",
      adminFeatureUpload: "Image upload",
      adminFeatureEdit: "Edit and delete projects",
      adminNote: "Panel access is restricted to the administrator.",
      skillsEyebrow: "Skills",
      techs: "Technologies",
      contactTitle: "Let's talk?",
      contactText: "You can contact me by email or follow my projects on GitHub.",
      sendEmail: "Send email",
      docs: "Official documentation →",
      dashboardTitle: "Projects",
      newProject: "New Project",
      logout: "Logout",
      register: "Create",
      emptyAdminTitle: "No projects registered yet.",
      emptyAdminText: "Click “Create” to add the first project to the landing page.",
      edit: "Edit",
      delete: "Delete",
      loginTitle: "Admin",
      loginText: "Sign in to manage your projects.",
      emailPlaceholder: "Email",
      passwordPlaceholder: "Password",
      enter: "Sign in",
      backSite: "Back to site",
      formNew: "New Project",
      formEdit: "Edit Project",
      labelTitle: "Title",
      labelPhoto: "Project image",
      labelShort: "Short description (PT)",
      labelFull: "Full description (PT)",
      labelTech: "Technologies (PT)",
      labelGithub: "GitHub link",
      labelDemo: "Demo link",
      labelStatus: "Status (PT)",
      labelYear: "Year",
      labelShortEn: "Short description (EN)",
      labelFullEn: "Full description (EN)",
      labelTechEn: "Technologies (EN)",
      labelStatusEn: "Status (EN)",
      save: "Save",
      github: "GitHub",
      demo: "Demo",
      skillHtml: "HTML is the language used to structure web page content, defining headings, text, images, links, forms and sections.",
      skillCss: "CSS styles web pages, controlling colors, spacing, layouts, responsiveness, animations and visual appearance.",
      skillJs: "JavaScript adds interactivity to pages, enabling animations, element manipulation, validations and dynamic behavior.",
      skillPhp: "PHP is a backend language used to create dynamic systems, authentication, CRUDs, database connections and business rules.",
      skillMysql: "MySQL is a relational database used to store, query and organize information for web applications.",
      skillDocker: "Docker creates isolated environments to run applications with PHP, MySQL, Nginx and other services in a standardized way.",
      skillGit: "Git is a version control system used to track code changes, create branches and collaborate on projects.",
      skillLinux: "Linux is an operating system widely used for servers, web development, terminal workflows, automation and production environments.",
      footerCredit: "Developed by Benício Castro",
    },
    pt: {
      themeIndustrial: "Industrial",
      themeCyber: "Cyber",
      languageButton: "EN",
      navAbout: "Sobre",
      navProjects: "Projetos",
      navPanel: "Painel",
      navSkills: "Skills",
      navContact: "Contato",
      back: "Voltar",
      heroEyebrow: "Frontend • Backend • Banco de dados",
      heroIntro: "Olá, eu sou",
      heroName: "Benício Castro.",
      heroText: "Desenvolvedor em formação, criando interfaces modernas, sistemas com banco de dados e experiências digitais com visual premium.",
      viewProjects: "Ver projetos",
      contact: "Contato",
      available: "● Disponível para projetos",
      heroCardTitle: "Desenvolvedor Full Stack",
      heroCardText: "Desenvolvimento de aplicações modernas utilizando HTML, CSS, JavaScript, PHP, MySQL e Docker.",
      aboutEyebrow: "Sobre mim",
      aboutTitle: "Gosto de transformar ideias em projetos reais.",
      aboutText: "Sou Benício Castro, estudante de Desenvolvimento Web e apaixonado por tecnologia. Tenho como objetivo evoluir continuamente como desenvolvedor full stack, criando aplicações modernas, funcionais e bem estruturadas. Atualmente, meus estudos são focados em HTML, CSS, JavaScript, PHP, MySQL, Docker e boas práticas de desenvolvimento. Esta landing page foi desenvolvida para apresentar meus projetos e demonstrar não apenas minhas habilidades em frontend, mas também minha capacidade de construir sistemas completos, incluindo backend, banco de dados, autenticação, painel administrativo e arquitetura de aplicações. Estou sempre em busca de novos desafios e oportunidades para transformar ideias em soluções reais por meio da programação.",
      projectsEyebrow: "Projetos",
      myWorks: "Meus trabalhos",
      noProjectsTitle: "Nenhum projeto publicado ainda.",
      noProjectsText: "Use o painel administrativo para cadastrar projetos com imagem, descrição, tecnologias e links.",
      details: "Ver detalhes →",
      backend: "Backend",
      adminPanel: "Painel Administrativo",
      adminShowTitle: "Gerenciamento completo dos projetos",
      adminShowText: "Esta landing page possui um painel administrativo exclusivo para cadastrar, editar e excluir projetos exibidos automaticamente no site.",
      adminFeatureLogin: "Login protegido por autenticação",
      adminFeatureDb: "Banco de dados MySQL",
      adminFeatureCreate: "Cadastro de novos projetos",
      adminFeatureUpload: "Upload de imagens",
      adminFeatureEdit: "Edição e exclusão de projetos",
      adminNote: "O acesso ao painel é restrito ao administrador.",
      skillsEyebrow: "Habilidades",
      techs: "Tecnologias",
      contactTitle: "Vamos conversar?",
      contactText: "Você pode falar comigo por e-mail ou acompanhar meus projetos no GitHub.",
      sendEmail: "Enviar e-mail",
      docs: "Documentação oficial →",
      dashboardTitle: "Projetos",
      newProject: "Novo Projeto",
      logout: "Sair",
      register: "Cadastrar",
      emptyAdminTitle: "Nenhum projeto cadastrado ainda.",
      emptyAdminText: "Clique em “Cadastrar” para adicionar o primeiro projeto à landing page.",
      edit: "Editar",
      delete: "Excluir",
      loginTitle: "Admin",
      loginText: "Entre para gerenciar seus projetos.",
      emailPlaceholder: "E-mail",
      passwordPlaceholder: "Senha",
      enter: "Entrar",
      backSite: "Voltar ao site",
      formNew: "Novo Projeto",
      formEdit: "Editar Projeto",
      labelTitle: "Título",
      labelPhoto: "Imagem do projeto",
      labelShort: "Descrição curta (PT)",
      labelFull: "Descrição completa (PT)",
      labelTech: "Tecnologias (PT)",
      labelGithub: "Link do GitHub",
      labelDemo: "Link da demo",
      labelStatus: "Status (PT)",
      labelYear: "Ano",
      labelShortEn: "Descrição curta (EN)",
      labelFullEn: "Descrição completa (EN)",
      labelTechEn: "Tecnologias (EN)",
      labelStatusEn: "Status (EN)",
      save: "Salvar",
      github: "GitHub",
      demo: "Demo",
      skillHtml: "HTML é a linguagem usada para estruturar o conteúdo das páginas web, definindo títulos, textos, imagens, links, formulários e seções.",
      skillCss: "CSS é usado para estilizar páginas web, controlando cores, espaçamentos, layouts, responsividade, animações e aparência visual.",
      skillJs: "JavaScript adiciona interatividade às páginas, permitindo animações, manipulação de elementos, validações e comportamento dinâmico.",
      skillPhp: "PHP é uma linguagem backend usada para criar sistemas dinâmicos, autenticação, CRUDs, conexão com banco de dados e regras de negócio.",
      skillMysql: "MySQL é um banco de dados relacional usado para armazenar, consultar e organizar informações de aplicações web.",
      skillDocker: "Docker permite criar ambientes isolados para rodar aplicações com PHP, MySQL, Nginx e outros serviços de forma padronizada.",
      skillGit: "Git é um sistema de controle de versão usado para registrar alterações no código, criar branches e colaborar em projetos.",
      skillLinux: "Linux é um sistema operacional muito usado em servidores, desenvolvimento web, terminal, automação e ambientes de produção.",
      footerCredit: "Desenvolvido por Benício Castro",
    },
  };

  const isAdminArea = document.body.classList.contains("admin-page") || document.body.classList.contains("admin-body") || window.location.pathname.startsWith("/admin");
  const themeStorageKey = isAdminArea ? "adminTheme" : "siteTheme";
  const languageStorageKey = isAdminArea ? "adminLanguage" : "siteLanguage";

  const getLanguage = () => localStorage.getItem(languageStorageKey) || "en";
  const getDictionary = () => translations[getLanguage()] || translations.en;

  const applyTheme = (theme) => {
    const selectedTheme = theme === "industrial" ? "industrial" : "cyber";
    const isIndustrial = selectedTheme === "industrial";

    document.body.classList.toggle("industrial-theme", isIndustrial);
    localStorage.setItem(themeStorageKey, selectedTheme);

    document.querySelectorAll(".theme-toggle").forEach((button) => {
      button.textContent = isIndustrial ? getDictionary().themeCyber : getDictionary().themeIndustrial;
      button.setAttribute("aria-label", isIndustrial ? "Activate Cyber theme" : "Activate Industrial theme");
    });
  };

  const applyProjectLanguage = (language) => {
    document.querySelectorAll("[data-project-status-pt]").forEach((element) => {
      const status = language === "en" ? element.dataset.projectStatusEn : element.dataset.projectStatusPt;
      const year = element.dataset.projectYear || "";
      element.textContent = `${status || ""}${year ? ` • ${year}` : ""}`;
    });

    document.querySelectorAll("[data-project-short-pt]").forEach((element) => {
      element.textContent = language === "en" ? element.dataset.projectShortEn : element.dataset.projectShortPt;
    });

    document.querySelectorAll("[data-project-tech-pt]").forEach((element) => {
      element.textContent = language === "en" ? element.dataset.projectTechEn : element.dataset.projectTechPt;
    });

    document.querySelectorAll("[data-project-description-pt]").forEach((element) => {
      const value = language === "en" ? element.dataset.projectDescriptionEn : element.dataset.projectDescriptionPt;
      element.innerHTML = (value || "").replace(/\n/g, "<br>");
    });
  };

  const applyLanguage = (language) => {
    const selectedLanguage = translations[language] ? language : "en";
    const dictionary = translations[selectedLanguage];

    document.documentElement.lang = selectedLanguage === "en" ? "en" : "pt-BR";
    localStorage.setItem(languageStorageKey, selectedLanguage);

    document.querySelectorAll("[data-i18n]").forEach((element) => {
      const key = element.dataset.i18n;
      if (dictionary[key]) element.textContent = dictionary[key];
    });

    document.querySelectorAll("[data-i18n-placeholder]").forEach((element) => {
      const key = element.dataset.i18nPlaceholder;
      if (dictionary[key]) element.setAttribute("placeholder", dictionary[key]);
    });

    document.querySelectorAll(".lang-toggle").forEach((button) => {
      button.textContent = dictionary.languageButton;
      button.setAttribute("aria-label", selectedLanguage === "en" ? "Switch to Portuguese" : "Switch to English");
    });

    applyProjectLanguage(selectedLanguage);
    applyTheme(localStorage.getItem(themeStorageKey) || "cyber");
  };

  applyLanguage(getLanguage());

  document.querySelectorAll(".lang-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      applyLanguage(getLanguage() === "pt" ? "en" : "pt");
    });
  });

  document.querySelectorAll(".theme-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      applyTheme(document.body.classList.contains("industrial-theme") ? "cyber" : "industrial");
    });
  });

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add("visible");
      });
    },
    { threshold: 0.15 },
  );

  document.querySelectorAll(".reveal").forEach((element) => observer.observe(element));

  document.querySelectorAll(".tilt-card").forEach((card) => {
    card.addEventListener("mousemove", (event) => {
      const rect = card.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = event.clientY - rect.top;
      const rotateX = (y / rect.height - 0.5) * -8;
      const rotateY = (x / rect.width - 0.5) * 8;
      card.style.transform = `perspective(900px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
    });

    card.addEventListener("mouseleave", () => {
      card.style.transform = "";
    });
  });

  const skillDocs = {
    html: { title: "HTML", textKey: "skillHtml", link: "https://developer.mozilla.org/docs/Web/HTML" },
    css: { title: "CSS", textKey: "skillCss", link: "https://developer.mozilla.org/docs/Web/CSS" },
    javascript: { title: "JavaScript", textKey: "skillJs", link: "https://developer.mozilla.org/docs/Web/JavaScript" },
    php: { title: "PHP", textKey: "skillPhp", link: "https://www.php.net/docs.php" },
    mysql: { title: "MySQL", textKey: "skillMysql", link: "https://dev.mysql.com/doc/" },
    docker: { title: "Docker", textKey: "skillDocker", link: "https://docs.docker.com/" },
    git: { title: "Git", textKey: "skillGit", link: "https://git-scm.com/doc" },
    linux: { title: "Linux", textKey: "skillLinux", link: "https://docs.kernel.org/" },
  };

  const modal = document.getElementById("skillModal");
  const modalTitle = document.getElementById("skillModalTitle");
  const modalText = document.getElementById("skillModalText");
  const modalLink = document.getElementById("skillModalLink");
  const closeModal = document.querySelector(".skill-modal-close");

  if (modal && modalTitle && modalText && modalLink && closeModal) {
    document.querySelectorAll(".skill-modal-btn").forEach((button) => {
      button.addEventListener("click", () => {
        const skill = skillDocs[button.dataset.skill];
        if (!skill) return;
        const dictionary = getDictionary();
        modalTitle.textContent = skill.title;
        modalText.textContent = dictionary[skill.textKey];
        modalLink.textContent = dictionary.docs;
        modalLink.href = skill.link;
        modal.classList.add("active");
        document.body.style.overflow = "hidden";
      });
    });

    const closeSkillModal = () => {
      modal.classList.remove("active");
      document.body.style.overflow = "";
    };

    closeModal.addEventListener("click", closeSkillModal);
    modal.addEventListener("click", (event) => {
      if (event.target === modal) closeSkillModal();
    });
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape") closeSkillModal();
    });
  }

  const scrollTopButton = document.getElementById("scrollTopBtn");
  if (scrollTopButton) {
    window.addEventListener("scroll", () => {
      scrollTopButton.classList.toggle("show", window.scrollY > 400);
    });
    scrollTopButton.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  const lightbox = document.getElementById("lightbox");
  const lightboxImage = document.getElementById("lightboxImage");
  const closeLightbox = document.querySelector(".lightbox-close");

  if (lightbox && lightboxImage && closeLightbox) {
    document.addEventListener("click", (event) => {
      const image = event.target.closest(".lightbox-trigger, .admin-preview-image");
      if (!image) return;
      lightboxImage.src = image.src;
      lightboxImage.alt = image.alt || "Expanded image";
      lightbox.classList.add("active");
      document.body.style.overflow = "hidden";
    });

    const closeProjectLightbox = () => {
      lightbox.classList.remove("active");
      document.body.style.overflow = "";
    };

    closeLightbox.addEventListener("click", closeProjectLightbox);
    lightbox.addEventListener("click", (event) => {
      if (event.target === lightbox) closeProjectLightbox();
    });
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape") closeProjectLightbox();
    });
  }
});
