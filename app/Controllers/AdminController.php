<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Project;
use App\Models\User;

class AdminController
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOGIN_BLOCK_SECONDS = 600;

    private function noCache(): void
    {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    }

    public function login(): void
    {
        $this->noCache();

        View::render('admin/login', [
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function authenticate(): void
    {
        $this->noCache();
        Auth::validateCsrf($_POST['csrf_token'] ?? null);

        $email = trim((string) ($_POST['email'] ?? ''));

        if ($this->isLoginBlocked($email)) {
            View::render('admin/login', [
                'error' => 'Too many attempts. Please wait a few minutes and try again.',
                'csrf' => Auth::csrfToken(),
            ]);
            return;
        }

        $user = User::findByEmail($email);

        if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
            $this->clearLoginAttempts($email);
            Auth::login($user);

            header('Location: /admin');
            exit;
        }

        $this->registerFailedLogin($email);

        View::render('admin/login', [
            'error' => 'Invalid email or password.',
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function dashboard(): void
    {
        Auth::requireLogin();
        $this->noCache();

        View::render('admin/dashboard', [
            'projects' => Project::all(),
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        $this->noCache();

        View::render('admin/form', [
            'project' => null,
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        $this->noCache();
        Auth::validateCsrf($_POST['csrf_token'] ?? null);

        $coverImage = $this->uploadCover($_FILES['cover_image'] ?? null);

        Project::create($_POST, $coverImage);

        header('Location: /admin');
        exit;
    }

    public function edit(int $id): void
    {
        Auth::requireLogin();
        $this->noCache();

        View::render('admin/form', [
            'project' => Project::find($id),
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function update(int $id): void
    {
        Auth::requireLogin();
        $this->noCache();
        Auth::validateCsrf($_POST['csrf_token'] ?? null);

        $coverImage = $this->uploadCover($_FILES['cover_image'] ?? null);

        Project::update($id, $_POST, $coverImage);

        header('Location: /admin');
        exit;
    }

    public function delete(int $id): void
    {
        Auth::requireLogin();
        $this->noCache();
        Auth::validateCsrf($_POST['csrf_token'] ?? null);

        Project::delete($id);

        header('Location: /admin');
        exit;
    }

    public function logout(): void
    {
        Auth::requireLogin();
        $this->noCache();
        Auth::validateCsrf($_POST['csrf_token'] ?? null);

        Auth::logout();

        header('Location: /admin/login');
        exit;
    }

    private function uploadCover(?array $file): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            exit('Image upload failed.');
        }

        if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
            exit('The image must be at most 2MB.');
        }

        $tmp = $file['tmp_name'] ?? '';

        if (!is_uploaded_file($tmp)) {
            exit('Invalid upload.');
        }

        $mime = $this->detectMime($tmp);
        $allowedMimes = [
            'image/jpeg' => IMAGETYPE_JPEG,
            'image/png' => IMAGETYPE_PNG,
            'image/webp' => IMAGETYPE_WEBP,
        ];

        if (!isset($allowedMimes[$mime])) {
            exit('Invalid format. Use JPG, PNG or WEBP.');
        }

        $info = getimagesize($tmp);

        if (!$info || ($info[2] ?? null) !== $allowedMimes[$mime]) {
            exit('Invalid image.');
        }

        if (($info[0] ?? 0) > 6000 || ($info[1] ?? 0) > 6000) {
            exit('The image is too large. Use up to 6000px wide or high.');
        }

        $safeImage = $this->safeImageContent($tmp, $mime);

        if ($safeImage === null) {
            exit('The image could not be saved.');
        }

        if ($this->uploadStorage() === 'database') {
            return 'data:' . $safeImage['mime'] . ';base64,' . base64_encode($safeImage['content']);
        }

        $dir = __DIR__ . '/../../public/uploads/projects';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!is_writable($dir)) {
            exit('The uploads folder is not writable.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $safeImage['extension'];
        $destination = $dir . '/' . $filename;

        if (file_put_contents($destination, $safeImage['content'], LOCK_EX) === false) {
            exit('The image could not be saved.');
        }

        chmod($destination, 0644);

        return '/uploads/projects/' . $filename;
    }

    private function uploadStorage(): string
    {
        $storage = strtolower((string) (getenv('UPLOAD_STORAGE') ?: 'filesystem'));

        return $storage === 'database' ? 'database' : 'filesystem';
    }

    private function detectMime(string $file): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return (string) $finfo->file($file);
    }

    private function safeImageContent(string $source, string $mime): ?array
    {
        if (!function_exists('imagewebp')) {
            $extension = match ($mime) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                default => 'img',
            };

            $content = file_get_contents($source);

            if ($content === false) {
                return null;
            }

            return [
                'content' => $content,
                'mime' => $mime,
                'extension' => $extension,
            ];
        }

        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($source),
            'image/png' => imagecreatefrompng($source),
            'image/webp' => imagecreatefromwebp($source),
            default => false,
        };

        if (!$image) {
            return null;
        }

        if ($mime === 'image/png') {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        ob_start();
        $saved = imagewebp($image, null, 82);
        $content = ob_get_clean();
        imagedestroy($image);

        if (!$saved || $content === false) {
            return null;
        }

        return [
            'content' => $content,
            'mime' => 'image/webp',
            'extension' => 'webp',
        ];
    }

    private function loginRateFile(string $email): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = hash('sha256', strtolower($email) . '|' . $ip);
        return sys_get_temp_dir() . '/landing_page-login-' . $key . '.json';
    }

    private function isLoginBlocked(string $email): bool
    {
        $data = $this->readLoginRate($email);
        return !empty($data['blocked_until']) && time() < (int) $data['blocked_until'];
    }

    private function registerFailedLogin(string $email): void
    {
        $file = $this->loginRateFile($email);
        $data = $this->readLoginRate($email);
        $count = ((int) ($data['count'] ?? 0)) + 1;

        $data = [
            'count' => $count,
            'blocked_until' => $count >= self::MAX_LOGIN_ATTEMPTS
                ? time() + self::LOGIN_BLOCK_SECONDS
                : 0,
        ];

        file_put_contents($file, json_encode($data), LOCK_EX);
    }

    private function clearLoginAttempts(string $email): void
    {
        $file = $this->loginRateFile($email);

        if (is_file($file)) {
            unlink($file);
        }
    }

    private function readLoginRate(string $email): array
    {
        $file = $this->loginRateFile($email);

        if (!is_file($file)) {
            return [];
        }

        $data = json_decode((string) file_get_contents($file), true);

        return is_array($data) ? $data : [];
    }
}
