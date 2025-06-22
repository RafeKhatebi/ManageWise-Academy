<?php
error_reporting(0);
session_start();

// Database connection
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "schoolproject";
$data     = mysqli_connect($host, $user, $password, $db);

// Check connection
if ($data === false) {
    die("connection error");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($data, $_POST["username"]);
    $pass = mysqli_real_escape_string($data, $_POST["password"]);

    // Query the users table (not 'user')
    $sql    = "SELECT * FROM users WHERE username = '$name' AND password = '$pass'";
    $result = mysqli_query($data, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['usertype'] == "student") {
            $_SESSION['username'] = $name;
            $_SESSION['usertype'] = "student";
            header("location:studenthome.php");
            exit();
        } elseif ($row['usertype'] == "admin") {
            $_SESSION['username'] = $name;
            $_SESSION['usertype'] = "admin";
            header("location:adminhome.php");
            exit();
        }
    } else {
        $message                  = "Username or password do not match";
        $_SESSION['loginMessage'] = $message;
        header("location:login.php");
        exit();
    }
}
