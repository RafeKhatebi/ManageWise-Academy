<?php
    session_start();
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
    } elseif ($_SESSION['usertype'] == 'admin') {

        header("location:login.php");
    }
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $db       = "schoolproject";

    $data   = mysqli_connect($host, $user, $password, $db);
    $name   = $_SESSION['username'];
    $sql    = "SELECT * FROM user WHERE username ='$name' ";
    $result = mysqli_query($data, $sql);
    $info   = mysqli_fetch_assoc($result);
    if (isset($_POST['update_profile'])) {
        $s_phone    = $_POST['phone'];
        $s_email    = $_POST['email'];
        $s_password = $_POST['password'];
        $sql2       = "UPDATE user SET phone='$s_phone',email='$s_email',password='$s_password' WHERE username='$name'";
        $result2    = mysqli_query($data, $sql2);
        if ($result2) {
            header('location:student_profile.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
   <link rel="stylesheet" href="./assets/css/common.css">
    <?php include 'student_css.php'?>
</head>

<body>

    <?php include 'student_sidebar.php'?>
    <div class="content">
        <center>
            <h1>Update Student</h1>
            <br>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div><label>Phone</label>
                        <input type="tel" name="phone" value="<?php echo "{$info['phone']}" ?>">
                    </div>
                    <div><label>Email</label>
                        <input type="email" name="email" value="<?php echo "{$info['email']}" ?>">
                    </div>
                    <div><label>Password</label>
                        <input type="text" name="password" value="<?php echo "{$info['password']}" ?>">
                    </div>
                    <div>

                        <input type="submit" name="update_profile"  class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </center>
    </div>

</body>

</html>