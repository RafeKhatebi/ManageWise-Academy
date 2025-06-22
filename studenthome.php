<?php
    session_start();
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
        exit();
    } elseif ($_SESSION['usertype'] == 'admin') {
        // Redirect admin users to admin dashboard
        header("location:adminhome.php");
        exit();
    }
    // Only students will reach this point
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <?php include 'student_css.php'?>
</head>
<body>
    <?php include 'student_sidebar.php'?>
    <div class="content">
        <h1>Student Dashboard</h1>
        <p>Welcome,<?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <!-- Add student-specific content here -->
        <!-- <div class="dashboard-cards">
            <div class="card">
                <h3>My Courses</h3>
                <p>View your enrolled courses</p>
            </div>
            <div class="card">
                <h3>Assignments</h3>
                <p>Check your assignments</p>
            </div>
            <div class="card">
                <h3>Grades</h3>
                <p>View your grades</p>
            </div>
        </div> -->
    </div>
</body>
</html>

