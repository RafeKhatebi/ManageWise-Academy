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

    // Get all available courses
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
    <title>My Courses</title>
    <?php include 'student_css.php'?>
    <link rel="stylesheet" href="./assets/css/adminView.css">
</head>
<body>
    <?php include 'student_sidebar.php'?>
    <div class="content">
        <center>
            <h1>Available Courses</h1>
            <p>Welcome,<?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <br>
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Fee (Af)</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>Action</th>
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
                            <a class='btn btn-success' href='#'>
                                Enroll Now
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                    } else {
                        echo "<tr><td colspan='5'>No courses available</td></tr>";
                    }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
