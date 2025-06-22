<?php
session_start();
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "schoolproject";
$data     = mysqli_connect($host, $user, $password, $db);
if ($data === false) {
    die("Connectioin Error!");
}
if (isset($_POST['apply'])) {
    $data_name    = $_POST['name'];
    $data_phone   = $_POST['phone'];
    $data_email   = $_POST['email'];
    $data_message = $_POST['message'];
    $sql          = "INSERT INTO admission_new (name,phone,email,message)
       VALUES('$data_name','$data_phone',' $data_email','$data_message')";

    $result = mysqli_query($data, $sql);

    if ($result) {
        $_SESSION['message'] = "Your aplicatiojn sent successful.";
        header("location:index.php");
    } else {
        echo "Apply Failed";
    }
}
