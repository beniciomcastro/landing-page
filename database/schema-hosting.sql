CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  short_description VARCHAR(255) NOT NULL,
  short_description_en VARCHAR(255) DEFAULT NULL,
  description TEXT NOT NULL,
  description_en TEXT DEFAULT NULL,
  technologies VARCHAR(255) NOT NULL,
  technologies_en VARCHAR(255) DEFAULT NULL,
  cover_image MEDIUMTEXT DEFAULT NULL,
  github_url VARCHAR(255) DEFAULT NULL,
  demo_url VARCHAR(255) DEFAULT NULL,
  status VARCHAR(80) DEFAULT 'Published',
  status_en VARCHAR(80) DEFAULT 'Published',
  project_year YEAR DEFAULT 2026,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password) VALUES
('Benício Castro', 'beniciomcastro@gmail.com', '$2y$10$LeeONv2TSsmoN81HKjGGWeaZombo8afAboUq8Pc4zzrs1bmsP/B4m')
ON DUPLICATE KEY UPDATE email = VALUES(email);
