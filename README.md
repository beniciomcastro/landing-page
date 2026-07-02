# OficialLandingPage

A dark, bilingual landing page for Benício Castro with a PHP backend, MySQL database, authenticated admin panel, project management and two visual themes: Cyber and Industrial.

## Features

- Public landing page with English as the default language.
- Portuguese toggle for public content only.
- Admin panel with separate language and theme preferences.
- Cyber and Industrial themes with independent persistence.
- Project CRUD with image upload.
- Project content fields in English and Portuguese.
- Render-ready Docker deployment.
- Aiven MySQL-ready configuration.
- Secure session cookies, CSRF protection, POST logout and basic login rate limiting.
- Upload storage mode for Render using the database.

## Stack

- PHP 8.3
- MySQL 8
- Docker Compose for local development
- Nginx for local development
- Render Docker deployment
- Aiven MySQL

## Local development

Run the project locally:

```bash
docker compose up --build -d
```

Open the website:

```text
http://localhost:8080
```

Open the admin panel:

```text
http://localhost:8080/admin/login
```

Local database credentials:

```text
Host: db
Database: landing_page
User: landing_page
Password: landing_page
```

Stop containers:

```bash
docker compose down
```

Remove the local database volume:

```bash
docker compose down -v
```

## Environment variables

Use `.env.example` as a reference.

```env
APP_DEBUG=false
UPLOAD_STORAGE=database

DB_HOST=
DB_PORT=3306
DB_DATABASE=landing_page
DB_USER=landing_page
DB_PASSWORD=
DB_SSL=true
DB_SSL_CA_BASE64=
```

## Render + Aiven deployment

This project includes:

```text
render.yaml
render.Dockerfile
```

In Render, create a web service from this project and configure the environment variables from `.env.example`.

For Aiven MySQL, create a database and import:

```text
database/schema-hosting.sql
```

`schema-hosting.sql` does not include `CREATE DATABASE` or `USE`, so it is safe for managed database providers.

## Upload storage

Render uses ephemeral storage. For production, keep:

```env
UPLOAD_STORAGE=database
```

With this option, project images are stored in MySQL as data URIs and remain available after redeploys.

For local development, you may use:

```env
UPLOAD_STORAGE=filesystem
```

## Theme and language storage

The public website and admin panel use separated browser storage keys:

```text
siteLanguage / siteTheme
adminLanguage / adminTheme
```

This prevents admin preferences from changing the public landing page.

## CSS organization

```text
public/assets/css/base.css
public/assets/css/layout.css
public/assets/css/components.css
public/assets/css/admin.css
public/assets/css/themes/cyber.css
public/assets/css/themes/industrial.css
public/assets/css/responsive.css
```

`style.css` only imports these files.

## Production notes

- Keep `APP_DEBUG=false` in production.
- Use `UPLOAD_STORAGE=database` on Render.
- Use Aiven SSL settings with `DB_SSL=true`.
- Change the default admin password after the first deployment.
- Do not expose phpMyAdmin or MySQL ports publicly.
