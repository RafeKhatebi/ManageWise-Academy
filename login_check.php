<?php
error_reporting(0);
session_start();
// Database connection
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "schoolproject";
$data     = mysqli_connect($host, $user, $password, $db, port: 3306);
//Check connection
if ($data === false) {
    die("connection error");
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["username"];
    $pass = $_POST["password"];

    // Prepare statement to prevent SQL Injection
    // $stmt = $data->prepare("SELECT * FROM user WHERE username = ?");
    // $stmt->bind_param("s", $name);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $row = $result->fetch_assoc();

    $sql    = "select * from user where username = '" . $name . "' AND password= '" . $pass . "'";
    $result = mysqli_query($data, $sql);
    $row    = mysqli_fetch_array($result);
    if ($row['usertype'] == "student") {
        $_SESSION['username'] = $name;
        $_SESSION['usertype'] = "student";
        header("location:studenthome.php");
    } elseif ($row['usertype'] == "admin") {
        $_SESSION['username'] = $name;
        $_SESSION['usertype'] = "admin";
        header("location:adminhome.php");
    } else {
        session_start();
        $message                  = "Username or password do not match";
        $_SESSION['loginMessage'] = $message;
        header("location:login.php");
    }
}
