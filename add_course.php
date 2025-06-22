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

    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    if (isset($_POST['add_course'])) {
        $c_name = mysqli_real_escape_string($data, $_POST['name']);
        $c_fee  = mysqli_real_escape_string($data, $_POST['fee']);
        $c_des  = mysqli_real_escape_string($data, $_POST['description']);
        $c_date = mysqli_real_escape_string($data, $_POST['date']);

        if (empty($c_name) || empty($c_fee) || empty($c_des) || empty($c_date)) {
            echo "<script>alert('Please fill all fields');</script>";
        } else {
            $sql    = "INSERT INTO courses_new (name, fee, description, date) VALUES ('$c_name', '$c_fee', '$c_des', '$c_date')";
            $result = mysqli_query($data, $sql);

            if ($result) {
                echo "<script>
            alert('Course added successfully');
            window.location.href = 'add_course.php';
            </script>";
            } else {
                echo "<script>
            alert('Error: " . mysqli_error($data) . "');
            </script>";
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
    <link rel="stylesheet" href="./assets/css/common.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Add Courses</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>Course Name:</label>
                        <select name="name" required>
                            <option value="">Select Course</option>
                            <option value="English Language">English Language</option>
                            <option value="JAVA Pro Language">JAVA Pro Language</option>
                            <option value="PHP Pro language">PHP Pro language</option>
                            <option value="Python Programming">Python Programming</option>
                            <option value="Web Development">Web Development</option>
                        </select>
                    </div>
                    <div>
                        <label>Course Fee:</label>
                        <input type="number" name="fee" step="0.01" min="0" required>
                    </div>
                    <div>
                        <label>Description:</label>
                        <textarea cols="30" rows="3" name="description" required></textarea>
                    </div>
                    <div>
                        <label>Start Date:</label>
                        <input type="date" name="date" required>
                    </div>
                    <div>
                        <input type="submit" name="add_course" value="Add Course" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
