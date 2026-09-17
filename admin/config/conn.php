<?php
error_reporting(1);
session_start();
$ses_id = session_id();

// Load .env (DB credentials, API keys - never hardcoded/committed)
if (!class_exists(\Dotenv\Dotenv::class)) {
	require_once __DIR__ . '/../../vendor/autoload.php';
}
if (empty($_ENV['DOTENV_LOADED'])) {
	\Dotenv\Dotenv::createImmutable(__DIR__ . '/../..')->safeLoad();
	$_ENV['DOTENV_LOADED'] = 1;
}

if (!function_exists('ww_env')) {
	function ww_env(string $key, $default = null)
	{
		$value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
		return $value === false || $value === null || $value === '' ? $default : $value;
	}
}

$host_header = $_SERVER['HTTP_HOST'] ?? '';
$is_local = strpos($host_header, 'localhost') !== false || strpos($host_header, '127.0.0.1') !== false;

$host = $is_local ? ww_env('DB_HOST', 'localhost') : ww_env('DB_HOST_PROD');
$username = $is_local ? ww_env('DB_USER', 'root') : ww_env('DB_USER_PROD');
$password = $is_local ? ww_env('DB_PASS', '') : ww_env('DB_PASS_PROD');
$dbName = $is_local ? ww_env('DB_NAME', 'amazing_db') : ww_env('DB_NAME_PROD');

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_errno) {
	echo $conn->connect_error;
}

$site_root = $is_local ? ww_env('SITE_URL_LOCAL', 'http://localhost/amazing/') : ww_env('SITE_URL_PROD');

?>