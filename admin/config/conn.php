<?php
error_reporting(1);
session_start();
$ses_id = session_id();

// $host = 'localhost';
// $username = 'amazing';
// $password = 'KJcd+j(g2yPL';
// $dbName = 'amazing';

$host = 'localhost';
$username = 'root';
$password = '';
$dbName = 'amazin_db';

$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_errno) {
	echo $conn->connect_error;
}
// else{
//     echo "connected";
// }


$site_root = 'https://' . $_SERVER['HTTP_HOST'] . '/';
// $site_root = 'https://amazinginfotech.in/admin';
// $site = 'https://amazinginfotech.in/';

$site_root = 'http://localhost/amazing/';

?>