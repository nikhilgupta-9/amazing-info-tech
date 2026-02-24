<?php

/**
 * Production-ready configuration
 * Short and efficient version
 */

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
$site = $is_local ? 'http://localhost/amazing/' : 'https://amazinginfotech.in/';
$site_root = $is_local ? 'http://localhost/amazing/admin' : 'https://amazinginfotech.in/admin';

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
    ? ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'name' => 'amazin_db']
    : ['host' => 'localhost', 'user' => 'amazing', 'pass' => 'KJcd+j(g2yPL', 'name' => 'amazing'];

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
        $key = hash('sha512', 'e@c@l@i@c@k');
        $iv = substr(hash('sha512', 'S3cur3'), 0, 16);
        return base64_encode(openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv));
    }
}

if (!function_exists('ww_decryptor')) {
    function ww_decryptor($string)
    {
        $key = hash('sha512', 'e@c@l@i@c@k');
        $iv = substr(hash('sha512', 'S3cur3'), 0, 16);
        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', $key, 0, $iv);
    }
}