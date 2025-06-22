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

    // Get course data
    if (isset($_GET['course_id']) && ! empty($_GET['course_id'])) {
        $c_id   = mysqli_real_escape_string($data, $_GET['course_id']);
        $sql    = "SELECT * FROM courses_new WHERE id='$c_id'";
        $result = mysqli_query($data, $sql);

        if (! $result) {
            die("Query error: " . mysqli_error($data));
        }

        if (mysqli_num_rows($result) == 0) {
            die("Course not found");
        }

        $info = $result->fetch_assoc();
    } else {
        die("Course ID not provided");
    }

    // Handle update
    if (isset($_POST['update_course'])) {
        $id     = mysqli_real_escape_string($data, $_POST['id']);
        $c_name = mysqli_real_escape_string($data, $_POST['name']);
        $c_fee  = mysqli_real_escape_string($data, $_POST['fee']);
        $c_des  = mysqli_real_escape_string($data, $_POST['description']);
        $c_date = mysqli_real_escape_string($data, $_POST['date']);

        $sql2    = "UPDATE courses_new SET name='$c_name', fee='$c_fee', description='$c_des', date='$c_date' WHERE id='$id'";
        $result2 = mysqli_query($data, $sql2);

        if ($result2) {
            echo "<script>
        alert('Course updated successfully');
        window.location.href = 'admin_view_course.php';
        </script>";
        } else {
            echo "<script>alert('Update failed: " . mysqli_error($data) . "');</script>";
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
    <title>Update Course</title>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Update Course Data</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($info['id']); ?>">
                    <div>
                        <label>Course Name:</label>
                        <select name="name" required>
                            <option value="English Language"                                                             <?php echo($info['name'] == 'English Language') ? 'selected' : ''; ?>>English Language</option>
                            <option value="JAVA Pro Language"                                                              <?php echo($info['name'] == 'JAVA Pro Language') ? 'selected' : ''; ?>>JAVA Pro Language</option>
                            <option value="PHP Pro language"                                                             <?php echo($info['name'] == 'PHP Pro language') ? 'selected' : ''; ?>>PHP Pro language</option>
                            <option value="Python Programming"                                                               <?php echo($info['name'] == 'Python Programming') ? 'selected' : ''; ?>>Python Programming</option>
                            <option value="Web Development"                                                            <?php echo($info['name'] == 'Web Development') ? 'selected' : ''; ?>>Web Development</option>
                        </select>
                    </div>
                    <div>
                        <label>Course Fee:</label>
                        <input type="number" name="fee" step="0.01" min="0" value="<?php echo htmlspecialchars($info['fee']); ?>" required>
                    </div>
                    <div>
                        <label>Description:</label>
                        <textarea name="description" rows="4" cols="40" required><?php echo htmlspecialchars($info['description']); ?></textarea>
                    </div>
                    <div>
                        <label>Start Date:</label>
                        <input type="date" name="date" value="<?php echo htmlspecialchars($info['date']); ?>" required>
                    </div>
                    <div>
                        <input type="submit" name="update_course" value="Update Course" class="btn btn-success">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
