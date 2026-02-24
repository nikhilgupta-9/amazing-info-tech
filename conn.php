<?php

if (!function_exists('ww_is_local_host')) {
    function ww_is_local_host()
    {
        return false;
    }
}


$site_root = 'https://' . $_SERVER['HTTP_HOST'] . '/';
$site_root = 'https://amazinginfotech.in/admin';
// $site_root = 'https://localhost/amazin/';
$site = 'https://amazinginfotech.in/';
// $site = 'https://localhost/amazin/';

if (ww_is_local_host()) {
    $site_root = 'http://localhost:8000/admin';
    $site = 'http://localhost:8000/';
}

// define site url
if (!defined("SITE_URL")) {
    define("SITE_URL", $site);
}

if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ses_id = session_id();

// $host = 'localhost';
// $username = 'amazing';
// $password = 'KJcd+j(g2yPL';
// $dbName = 'amazing';

$host = 'localhost';
$username = 'root';
$password = '';
$dbName = 'amazin_db';

if (ww_is_local_host()) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'amazin_db';
}

$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_errno) {
    echo $conn->connect_error;
}


if (!function_exists('ww_get_client_ip')) {
    /**
     * @return mixed
     * Return ip address of client
     */
    function ww_get_client_ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

}

if (!function_exists('ww_encryptor')) {
    /**
     * @param $string
     * @return string
     * encryptor
     */
    function ww_encryptor($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'e@c@l@i@c@k';
        $secret_iv = 'S3cur3';
        // hash
        $key = hash('sha512', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha512', $secret_iv), 0, 16);
        //do the encyption given text/string/number
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
}

/**
 * ww_decryptor
 */
if (!function_exists('ww_decryptor')) {
    function ww_decryptor($string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'e@c@l@i@c@k';
        $secret_iv = 'S3cur3';

        // hash
        $key = hash('sha512', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha512', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}


?>