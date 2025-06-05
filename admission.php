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

    $sql    = "SELECT * from admission";
    $result = mysqli_query($data, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>
    <title>Admin Dashboard</title>
   <link rel="stylesheet" href="./assets/css/admission.css">
</head>
<body>
    <?php
        include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <h1> Applied For Admission</h1>
            <br>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
                <?php while ($info = $result->fetch_assoc()) {?>
                    <tr>
                        <td><?php echo "{$info['name']}"; ?></td>
                        <td><?php echo "{$info['phone']}"; ?></td>
                        <td><?php echo "{$info['email']}"; ?></td>
                        <td><?php echo "{$info['message']}"; ?></td>
                    </tr>
                <?php
                }?>
            </table>
        </center>

    </div>

</body>

</html>