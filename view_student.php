<?php
    error_reporting(0);

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

    $sql    = "SELECT * FROM users WHERE usertype='student'";
    $result = mysqli_query($data, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>

    <title>Admin Dashboard</title>
<link rel="stylesheet" href="./assets/css/adminView.css">
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Student Data</h1>
            <?php

                if ($_SESSION['message']) {
                    echo $_SESSION['message'];
                }
                unset($_SESSION['message']);

            ?>
            <br>
            <table>
                <tr>
                    <th>UserName</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Delete</th>
                    <th>Update</th>
                </tr>
                <?php while ($info = $result->fetch_assoc()) {?>
                    <tr>
                        <td><?php echo "{$info['username']}"; ?></td>
                        <td><?php echo "{$info['phone']}"; ?></td>
                        <td><?php echo "{$info['email']}"; ?></td>
                        <td><?php echo "{$info['password']}"; ?></td>
                        <td><?php echo "<a class='btn btn-danger' onClick=\" javascript:return confirm('Are you sure to delete ?');\" href='delete.php?student_id={$info['id']}'>Delete </a>"; ?></td>
                        <td><?php echo "<a class='btn btn-primary' href='update_student.php?student_id={$info['id']}'> Update </a>"; ?> </td>

                    </tr>
                <?php
                }?>
            </table>
        </center>
    </div>
</body>

</html>