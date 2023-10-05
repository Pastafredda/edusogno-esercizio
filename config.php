<?php
$user = 'root';
$password = 'root';
$db = 'edusogno_db';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);

if (!$success) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
