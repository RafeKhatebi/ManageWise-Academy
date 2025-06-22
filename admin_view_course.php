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

    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Handle delete request
    if (isset($_GET['course_id']) && ! empty($_GET['course_id'])) {
        $c_id    = mysqli_real_escape_string($data, $_GET['course_id']);
        $sql2    = "DELETE FROM courses_new WHERE id='$c_id'";
        $result2 = mysqli_query($data, $sql2);
        if ($result2) {
            header('location:admin_view_course.php');
            exit();
        } else {
            echo "<script>alert('Delete failed: " . mysqli_error($data) . "');</script>";
        }
    }

    // Select all courses
    $sql    = "SELECT * FROM courses_new ORDER BY created_at DESC";
    $result = mysqli_query($data, $sql);

    if (! $result) {
        die("Query error: " . mysqli_error($data));
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
            <h1>View All Courses</h1><br>
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Fee ($)</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>Delete</th>
                    <th>Update</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($info = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($info['name']); ?></td>
                        <td>$<?php echo number_format($info['fee'], 2); ?></td>
                        <td><?php echo htmlspecialchars($info['description']); ?></td>
                        <td><?php echo htmlspecialchars($info['date']); ?></td>
                        <td>
                            <a class='btn btn-danger'
                               onClick="javascript:return confirm('Are you sure you want to delete this course?');"
                               href='admin_view_course.php?course_id=<?php echo $info['id']; ?>'>
                               Delete
                            </a>
                        </td>
                        <td>
                            <a class='btn btn-primary'
                               href='admin_update_course.php?course_id=<?php echo $info['id']; ?>'>
                               Update
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                    } else {
                        echo "<tr><td colspan='6'>No courses found</td></tr>";
                    }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
