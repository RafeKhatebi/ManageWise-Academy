<?php
    require_once 'dbconnection.php';

    if (isset($_POST['add_student'])) {
        $username      = $_POST['name'];
        $user_phone    = $_POST['phone'];
        $user_email    = $_POST['email'];
        $user_password = $_POST['password'];
        $usertype      = "student";

        $check      = "SELECT * FROM users WHERE username = '$username'";
        $check_user = mysqli_query($data, $check);
        $row_count  = mysqli_num_rows($check_user);
        // Sanitize inputs
        $username      = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $user_phone    = htmlspecialchars($user_phone, ENT_QUOTES, 'UTF-8');
        $user_email    = htmlspecialchars($user_email, ENT_QUOTES, 'UTF-8');
        $user_password = htmlspecialchars($user_password, ENT_QUOTES, 'UTF-8');
        // Validate inputs
        $username      = trim($username);
        $user_phone    = trim($user_phone);
        $user_email    = trim($user_email);
        $user_password = trim($user_password);
        // Check if the user already exists
        if ($row_count == 1) {
            echo "<script type='text/javascript'>
        alert('User name is already exist. Try another one');
        </script>
        ";
        } else {
            $sql = "INSERT INTO users(username,phone,email,usertype,password)
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