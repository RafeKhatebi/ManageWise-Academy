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
    if (isset($_POST['add_student'])) {
        $username      = $_POST['name'];
        $user_phone    = $_POST['phone'];
        $user_email    = $_POST['email'];
        $user_password = $_POST['password'];
        $usertype      = "student";

        $check      = "SELECT * FROM user WHERE username = '$username'";
        $check_user = mysqli_query($data, $check);
        $row_count  = mysqli_num_rows($check_user);
        if ($row_count == 1) {
            echo "<script type='text/javascript'>
        alert('User name is already exist. Try another one');
        </script>
        ";
        } else {
            $sql = "INSERT INTO user(username,phone,email,usertype,password)
    VALUES ('$username','$user_phone','$user_email','$usertype','$user_password')";
            $result = mysqli_query($data, $sql);
            if ($result) {
                echo "<script type='text/javascript'>
        alert('Data uploaded successfuly');
        </script>
        ";
            } else {
                echo "<script type='text/javascript'>
        alert('Data not uploaded ');
        </script>
        ";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>

    <title>Admin Dashboard</title>
      <link rel="stylesheet" href="./assets/css/common.css">

</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Add Student</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div><label>User name</label>
                        <input type="text" name="name">
                    </div>
                    <div><label>Phone</label>
                        <input type="tel" name="phone">
                    </div>
                    <div><label>Email</label>
                        <input type="email" name="email">
                    </div>
                    <div><label>Password</label>
                        <input type="text" name="password">
                    </div>
                    <div>

                        <input type="submit" name="add_student" value="Add Student" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>