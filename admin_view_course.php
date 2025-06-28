<?php
       require_once 'dbconnection.php';

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

    // Pagination logic
    $records_per_page = 10;
    $page             = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset           = ($page - 1) * $records_per_page;

    // Get total number of records
    $total_records_sql    = "SELECT COUNT(*) AS total FROM courses_new";
    $total_records_result = mysqli_query($data, $total_records_sql);
    $total_records_row    = mysqli_fetch_assoc($total_records_result);
    $total_records        = $total_records_row['total'];
    $total_pages          = ceil($total_records / $records_per_page);

    // Select courses for current page
    $sql    = "SELECT * FROM courses_new ORDER BY created_at DESC LIMIT $offset, $records_per_page";
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
    <link rel="stylesheet" href="./assets/css/pagination.css">
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>View All Courses</h1><br>
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Fee (Af)</th>
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

            <!-- Pagination links -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="admin_view_course.php?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php else: ?>
                    <a class="disabled">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="admin_view_course.php?page=<?php echo $i; ?>"<?php if ($i == $page) {
        echo 'class="active"';
}
?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="admin_view_course.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php else: ?>
                    <a class="disabled">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </center>
    </div>
</body>
</html>