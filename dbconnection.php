<?php
session_start();
error_reporting(0);
// Check if the user is logged in and has the correct user type or not
if (! isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'student') {
    header("location:login.php");
}

// Database connection 
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "schoolproject";
$data     = mysqli_connect($host, $user, $password, $db);
// Check if the connection was successful
if (! $data) {
    die("Connection failed: " . mysqli_connect_error());
}
// Set the character set to UTF-8
mysqli_set_charset($data, "utf8");
