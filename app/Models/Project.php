<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Project
{
    public static function all(): array
    {
        return Database::connect()->query('SELECT * FROM projects ORDER BY created_at DESC')->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::connect()->prepare('SELECT * FROM projects WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connect()->prepare('SELECT * FROM projects WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data, ?string $coverImage): void
    {
        $sql = 'INSERT INTO projects (title, slug, short_description, short_description_en, description, description_en, technologies, technologies_en, cover_image, github_url, demo_url, status, status_en, project_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        Database::connect()->prepare($sql)->execute([
            self::clean($data['title'] ?? ''),
            self::uniqueSlug($data['title'] ?? ''),
            self::clean($data['short_description'] ?? ''),
            self::clean($data['short_description_en'] ?? $data['short_description'] ?? ''),
            trim($data['description'] ?? ''),
            trim($data['description_en'] ?? $data['description'] ?? ''),
            self::clean($data['technologies'] ?? ''),
            self::clean($data['technologies_en'] ?? $data['technologies'] ?? ''),
            $coverImage,
            filter_var($data['github_url'] ?? '', FILTER_VALIDATE_URL) ? $data['github_url'] : null,
            filter_var($data['demo_url'] ?? '', FILTER_VALIDATE_URL) ? $data['demo_url'] : null,
            self::clean($data['status'] ?? 'Published'),
            self::clean($data['status_en'] ?? $data['status'] ?? 'Published'),
            (int) ($data['project_year'] ?? date('Y')),
        ]);
    }

    public static function update(int $id, array $data, ?string $coverImage): void
    {
        $current = self::find($id);
        $image = $coverImage ?: ($current['cover_image'] ?? null);

        $sql = 'UPDATE projects SET title=?, slug=?, short_description=?, short_description_en=?, description=?, description_en=?, technologies=?, technologies_en=?, cover_image=?, github_url=?, demo_url=?, status=?, status_en=?, project_year=? WHERE id=?';
        Database::connect()->prepare($sql)->execute([
            self::clean($data['title'] ?? ''),
            self::uniqueSlug($data['title'] ?? '', $id),
            self::clean($data['short_description'] ?? ''),
            self::clean($data['short_description_en'] ?? $data['short_description'] ?? ''),
            trim($data['description'] ?? ''),
            trim($data['description_en'] ?? $data['description'] ?? ''),
            self::clean($data['technologies'] ?? ''),
            self::clean($data['technologies_en'] ?? $data['technologies'] ?? ''),
            $image,
            filter_var($data['github_url'] ?? '', FILTER_VALIDATE_URL) ? $data['github_url'] : null,
            filter_var($data['demo_url'] ?? '', FILTER_VALIDATE_URL) ? $data['demo_url'] : null,
            self::clean($data['status'] ?? 'Published'),
            self::clean($data['status_en'] ?? $data['status'] ?? 'Published'),
            (int) ($data['project_year'] ?? date('Y')),
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $project = self::find($id);
        if ($project && !empty($project['cover_image'])) {
            $file = __DIR__ . '/../../public' . $project['cover_image'];
            if (is_file($file)) {
                unlink($file);
            }
        }

        Database::connect()->prepare('DELETE FROM projects WHERE id = ?')->execute([$id]);
    }

    private static function uniqueSlug(string $text, ?int $ignoreId = null): string
    {
        $base = self::slug($text);
        $slug = $base;
        $count = 1;

        while (self::slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private static function slugExists(string $slug, ?int $ignoreId): bool
    {
        $sql = 'SELECT id FROM projects WHERE slug = ?' . ($ignoreId ? ' AND id != ?' : '') . ' LIMIT 1';
        $params = $ignoreId ? [$slug, $ignoreId] : [$slug];
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }

    private static function slug(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text) ?: $text;
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower($text));
        return trim($text ?: 'project', '-');
    }

    private static function clean(string $value): string
    {
        return trim(strip_tags($value));
    }
}
