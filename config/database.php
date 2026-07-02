<?php
return [
    'host' => getenv('DB_HOST') ?: 'db',
    'port' => (int) (getenv('DB_PORT') ?: 3306),
    'database' => getenv('DB_DATABASE') ?: (getenv('DB_NAME') ?: 'landing_page'),
    'user' => getenv('DB_USER') ?: 'landing_page',
    'password' => getenv('DB_PASSWORD') ?: 'landing_page',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'ssl' => filter_var(getenv('DB_SSL') ?: 'false', FILTER_VALIDATE_BOOLEAN),
    'ssl_ca_path' => getenv('DB_SSL_CA_PATH') ?: null,
    'ssl_ca' => getenv('DB_SSL_CA') ?: null,
    'ssl_ca_base64' => getenv('DB_SSL_CA_BASE64') ?: null,
];
