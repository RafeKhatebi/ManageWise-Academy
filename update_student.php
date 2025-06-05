<?php

    session_start();
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
    } elseif ($_SESSION['usertype'] == 'student') {
        header("location:login.php");
    }
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $db       = "schoolproject";
    $data     = mysqli_connect($host, $user, $password, $db);
    $id       = $_GET['student_id'];

    $sql    = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query($data, $sql);
    $info   = $result->fetch_assoc();
    if (isset($_POST['update'])) {
        $name     = $_POST['name'];
        $phone    = $_POST['phone'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $query    = "UPDATE user SET username='$name',phone='$phone', email='$email', password='$password' WHERE id='$id'";
        $result2  = mysqli_query($data, $query);
        if ($result2) {
            header("location:view_student.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>

    <title>Update Student!</title>
   <link rel="stylesheet" href="./assets/css/common.css">
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Update Student</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div><label>User name</label>
                        <input type="text" name="name" value="                                                               <?php echo "{$info['username']}"; ?>">
                    </div>
                    <div><label>Phone</label>
                        <input type="tel" name="phone" value="                                                               <?php echo "{$info['phone']}"; ?>">
                    </div>
                    <div><label>Email</label>
                        <input type="email" name="email" value="                                                                 <?php echo "{$info['email']}"; ?>">
                    </div>
                    <div><label>Password</label>
                        <input type="text" name="password" value="                                                                   <?php echo "{$info['password']}"; ?>">
                    </div>
                    <div>

                        <input type="submit" name="update" value="Update" class="btn btn-success">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>