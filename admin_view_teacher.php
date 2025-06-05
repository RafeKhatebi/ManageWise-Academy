<?php

    session_start();
    error_reporting(0);
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
    // $row_per_page = 10;
    // $page= $_GET['page'];
//  LIMIT ( ($page * $row_per_page) - $row_per_page  $,$row_per_page
    $sql      = "SELECT * FROM teacher";
    $result   = mysqli_query($data, $sql);
    if ($_GET['teacher_id']) {
        $t_id    = $_GET['teacher_id'];
        $sql2    = "DELETE FROM teacher WHERE id='$t_id'";
        $result2 = mysqli_query($data, $sql2);
        if ($result2) {
            header('location:admin_view_teacher.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>
   <link rel="stylesheet" href="./assets/css/adminView.css">

    <title>Admin Dashboard</title>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>View All Teacher Data</h1><br>
            <table>
                <tr>
                    <th>Teacher Name</th>
                    <th>About Teacher</th>
                    <th>Image</th>
                    <th>Delete</th>
                    <th>Update</th>
                </tr>
                <?php while ($info = $result->fetch_assoc()) {?>

                    <tr>
                        <td><?php echo "{$info['name']}"; ?></td>
                        <td><?php echo "{$info['description']}"; ?></td>
                        <td> <img class="teacher img-fluid rounded" src="<?php echo "{$info['image']}"; ?>"></td>
                        <td><?php echo "<a class='btn btn-danger' onClick=\" javascript:return confirm('Are you sure to delete ?');\" href='admin_view_teacher.php?teacher_id={$info['id']}'>Delete </a>"; ?></td>
                        <td><?php echo "<a class='btn btn-primary' href='admin_update_teacher.php?teacher_id={$info['id']}'> Update </a>"; ?> </td>
                    </tr>

                <?php }?>

            </table>
        </center>
    </div>
</body>

</html>