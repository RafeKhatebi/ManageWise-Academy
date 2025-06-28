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
    // Use mysqli_real_escape_string to prevent SQL injection
    $data_name    = mysqli_real_escape_string($data, $data_name);
    $data_phone   = mysqli_real_escape_string($data, $data_phone);
    $data_email   = mysqli_real_escape_string($data, $data_email);
    $data_message = mysqli_real_escape_string($data, $data_message);
    //trim the input to remove any leading or trailing whitespace
    $data_name    = trim($data_name);
    $data_phone   = trim($data_phone);
    $data_email   = trim($data_email);
    $data_message = trim($data_message);

    // Execute the query
    $result = mysqli_query($data, $sql);

    if ($result) {
        $_SESSION['message'] = "Your application sent successfully.";
        header("location:index.php");
    } else {
        echo "Apply Failed";
    }
}
