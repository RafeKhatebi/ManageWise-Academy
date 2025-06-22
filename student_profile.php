<?php
    session_start();
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
        exit();
    } elseif ($_SESSION['usertype'] == 'admin') {
        header("location:adminhome.php");
        exit();
    }

    $host     = "localhost";
    $user     = "root";
    $password = "";
    $db       = "schoolproject";
    $data     = mysqli_connect($host, $user, $password, $db);

    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Get student profile data
    $username = $_SESSION['username'];
    $sql      = "SELECT * FROM users WHERE username = '$username'";
    $result   = mysqli_query($data, $sql);

    if (! $result) {
        die("Query error: " . mysqli_error($data));
    }

    $student_info = mysqli_fetch_assoc($result);

    // Handle profile update
    if (isset($_POST['update_profile'])) {
        $new_username = mysqli_real_escape_string($data, $_POST['username']);
        $new_password = mysqli_real_escape_string($data, $_POST['password']);
        $email        = mysqli_real_escape_string($data, $_POST['email']);
        $phone        = mysqli_real_escape_string($data, $_POST['phone']);

        $update_sql    = "UPDATE users SET username='$new_username', password='$new_password', email='$email', phone='$phone' WHERE username='$username'";
        $update_result = mysqli_query($data, $update_sql);

        if ($update_result) {
            $_SESSION['username'] = $new_username;
            echo "<script>alert('Profile updated successfully!');</script>";
            header("refresh:1;url=student_profile.php");
        } else {
            echo "<script>alert('Update failed: " . mysqli_error($data) . "');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <?php include 'student_css.php'?>
    <link rel="stylesheet" href="./assets/css/common.css">
</head>
<body>
    <?php include 'student_sidebar.php'?>
    <div class="content">
        <center>
            <h1>My Profile</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>Username:</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($student_info['username']); ?>" required>
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" name="password" value="<?php echo htmlspecialchars($student_info['password']); ?>" required>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($student_info['email'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>Phone:</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($student_info['phone'] ?? ''); ?>">
                    </div>
                    <div>
                        <input type="submit" name="update_profile" value="Update Profile" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
