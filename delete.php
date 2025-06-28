<?php
session_start();
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "schoolproject";

// Establish database connection
$data = mysqli_connect($host, $user, $password, $db);
if (! $data) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['student_id'])) {
    $user_id = $_GET['student_id'];

    // Validate input: Ensure $user_id is an integer
    if (! filter_var($user_id, FILTER_VALIDATE_INT)) {
        $_SESSION['message'] = 'Invalid student ID.';
        header("location:view_student.php");
        exit();
    }

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($data, "DELETE FROM users WHERE id=?");
    if (! $stmt) {
        die("Prepare failed: " . mysqli_error($data));
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id); // "i" means integer type

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = 'Student deleted successfully.';
    } else {
        $_SESSION['message'] = 'Error deleting student: ' . mysqli_error($data);
    }

    mysqli_stmt_close($stmt);

    header("location:view_student.php");
    exit();
} else {

    $_SESSION['message'] = 'Student ID not provided.';
    header("location:view_student.php");
    exit();
}

mysqli_close($data);
