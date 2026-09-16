<?php

/**
 * Production-ready configuration
 * Short and efficient version
 */

// Load .env (DB credentials, API keys, encryption keys - never hardcoded/committed)
if (!class_exists(\Dotenv\Dotenv::class)) {
    require_once __DIR__ . '/vendor/autoload.php';
}
if (empty($_ENV['DOTENV_LOADED'])) {
    \Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();
    $_ENV['DOTENV_LOADED'] = 1;
}

if (!function_exists('ww_env')) {
    function ww_env(string $key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        return $value === false || $value === null || $value === '' ? $default : $value;
    }
}

// Environment detection
if (!function_exists('ww_is_local_host')) {
    function ww_is_local_host(): bool
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        return strpos($host, 'localhost') !== false ||
            strpos($host, '127.0.0.1') !== false ||
            strpos($host, '::1') !== false;
    }
}

$is_local = ww_is_local_host();

// Site URLs
$site = $is_local ? ww_env('SITE_URL_LOCAL', 'http://localhost/amazing/') : ww_env('SITE_URL_PROD');
$site_root = rtrim($site, '/') . '/admin';

if (!defined("SITE_URL"))
    define("SITE_URL", $site);
if (!defined("ADMIN_URL"))
    define("ADMIN_URL", $site_root);

// Session
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', !$is_local);
    session_start();
}

// Database
$db_config = $is_local
    ? [
        'host' => ww_env('DB_HOST', 'localhost'),
        'user' => ww_env('DB_USER', 'root'),
        'pass' => ww_env('DB_PASS', ''),
        'name' => ww_env('DB_NAME', 'amazing_db'),
    ]
    : [
        'host' => ww_env('DB_HOST_PROD'),
        'user' => ww_env('DB_USER_PROD'),
        'pass' => ww_env('DB_PASS_PROD'),
        'name' => ww_env('DB_NAME_PROD'),
    ];

$conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
$conn->set_charset('utf8mb4');

if ($conn->connect_errno) {
    error_log("DB connection failed: " . $conn->connect_error);
    die($is_local ? $conn->connect_error : "Database error");
}

// IP function
if (!function_exists('ww_get_client_ip')) {
    function ww_get_client_ip(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}

// Encryption/Decryption
if (!function_exists('ww_encryptor')) {
    function ww_encryptor($string)
    {
        $key = hash('sha512', ww_env('ENCRYPTION_KEY'));
        $iv = substr(hash('sha512', ww_env('ENCRYPTION_IV_SEED')), 0, 16);
        return base64_encode(openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv));
    }
}

if (!function_exists('ww_decryptor')) {
    function ww_decryptor($string)
    {
        $key = hash('sha512', ww_env('ENCRYPTION_KEY'));
        $iv = substr(hash('sha512', ww_env('ENCRYPTION_IV_SEED')), 0, 16);
        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', $key, 0, $iv);
    }
}

// Secure resume/document upload handler (whitelisted extension + real MIME check + random filename)
if (!function_exists('ww_secure_resume_upload')) {
    function ww_secure_resume_upload(array $file, string $targetDir): array
    {
        $allowedExt = ['pdf', 'doc', 'docx'];
        $allowedMime = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip', // .docx is a zip container; some finfo builds report this
            'application/octet-stream',
        ];

        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'error' => 'File upload failed.'];
        }

        if ($file['size'] <= 0 || $file['size'] > 5 * 1024 * 1024) {
            return ['ok' => false, 'error' => 'Only PDF, DOC or DOCX files up to 5MB are allowed.'];
        }

        $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            return ['ok' => false, 'error' => 'Only PDF, DOC or DOCX files are allowed.'];
        }

        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
            if ($finfo) {
                finfo_close($finfo);
            }
            if ($mime !== false && !in_array($mime, $allowedMime, true)) {
                return ['ok' => false, 'error' => 'The uploaded file content does not match an allowed document type.'];
            }
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $safeName = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = rtrim($targetDir, '/') . '/' . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['ok' => false, 'error' => 'Could not save the uploaded file.'];
        }

        return ['ok' => true, 'path' => $destination, 'name' => $safeName];
    }
}

// Word-safe excerpt for card/teaser text (keeps card heights consistent without relying on CSS line-clamp)
if (!function_exists('ww_truncate')) {
    function ww_truncate(string $text, int $length): string
    {
        $text = trim($text);
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        $short = mb_substr($text, 0, $length);
        $short = mb_substr($short, 0, mb_strrpos($short, ' ') ?: $length);
        return rtrim($short, " .,") . '…';
    }
}