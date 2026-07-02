<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection) {
            return self::$connection;
        }

        $config = require __DIR__ . '/../../config/database.php';
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        if (!empty($config['ssl'])) {
            $sslCaPath = self::resolveSslCaPath($config);

            if ($sslCaPath) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = $sslCaPath;
            }
        }

        try {
            self::$connection = new PDO($dsn, $config['user'], $config['password'], $options);
            return self::$connection;
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            http_response_code(500);
            exit('Internal database connection error.');
        }
    }

    private static function resolveSslCaPath(array $config): ?string
    {
        if (!empty($config['ssl_ca_path']) && is_file((string) $config['ssl_ca_path'])) {
            return (string) $config['ssl_ca_path'];
        }

        if (!empty($config['ssl_ca_base64'])) {
            $decoded = base64_decode((string) $config['ssl_ca_base64'], true);

            if ($decoded !== false) {
                $path = sys_get_temp_dir() . '/landing_page-db-ca.pem';
                file_put_contents($path, $decoded);
                return $path;
            }
        }

        if (!empty($config['ssl_ca'])) {
            $path = sys_get_temp_dir() . '/landing_page-db-ca.pem';
            file_put_contents($path, (string) $config['ssl_ca']);
            return $path;
        }

        return null;
    }
}
