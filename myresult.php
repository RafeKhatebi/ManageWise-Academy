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

    $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Results</title>
    <?php include 'student_css.php'?>
    <link rel="stylesheet" href="./assets/css/adminView.css">
</head>
<body>
    <?php include 'student_sidebar.php'?>
    <div class="content">
        <center>
            <h1>My Academic Results</h1>
            <p>Student:                        <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <br>

            <!-- Sample Results Table -->
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Assignment</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
                <!-- Sample data - you can replace this with dynamic data from database -->
                <tr>
                    <td>English Language</td>
                    <td>Assignment 1</td>
                    <td>85</td>
                    <td>100</td>
                    <td>A</td>
                    <td><span class="badge bg-success">Pass</span></td>
                </tr>
                <tr>
                    <td>JAVA Pro Language</td>
                    <td>Assignment 1</td>
                    <td>78</td>
                    <td>100</td>
                    <td>B+</td>
                    <td><span class="badge bg-success">Pass</span></td>
                </tr>
                <tr>
                    <td>PHP Pro language</td>
                    <td>Assignment 1</td>
                    <td>92</td>
                    <td>100</td>
                    <td>A+</td>
                    <td><span class="badge bg-success">Pass</span></td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">
                        <em>More results will appear here as you complete assignments</em>
                    </td>
                </tr>
            </table>

            <br>
            <div class="summary-card">
                <h3>Overall Performance</h3>
                <p><strong>Total Courses:</strong> 3</p>
                <p><strong>Average Grade:</strong> A-</p>
                <p><strong>Overall Percentage:</strong> 85%</p>
            </div>
        </center>
    </div>
</body>
</html>
