<?php
    error_reporting(0);
    require_once 'dbconnection.php';
    // Pagination logic
    $records_per_page = 10;
    $page             = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset           = ($page - 1) * $records_per_page;

    // Get total number of students
    $count_sql     = "SELECT COUNT(*) AS total FROM users WHERE usertype='student'";
    $count_result  = mysqli_query($data, $count_sql);
    $total_records = mysqli_fetch_assoc($count_result)['total'];
    $total_pages   = ceil($total_records / $records_per_page);

    // Get students for current page
    $sql    = "SELECT * FROM users WHERE usertype='student' LIMIT $offset, $records_per_page";
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/css/adminView.css">
     <link rel="stylesheet" href="./assets/css/pagination.css">
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
                    <th>Get CSV</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($info = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($info['username']); ?></td>
                        <td><?php echo htmlspecialchars($info['phone']); ?></td>
                        <td><?php echo htmlspecialchars($info['email']); ?></td>
                        <td><?php echo htmlspecialchars($info['password']); ?></td>
                        <td>
                            <a class='btn btn-danger'
                               onClick="javascript:return confirm('Are you sure to delete?');"
                               href='delete.php?student_id=<?php echo $info['id']; ?>'>
                               Delete
                            </a>
                        </td>
                        <td>
                            <a class='btn btn-primary'
                               href='update_student.php?student_id=<?php echo $info['id']; ?>'>
                               Update
                            </a>
                        </td>
                        <td>
                            <a class='btn btn-success'
                             href='dawnloadcsv.php?student_id=<?php echo $info['id']; ?>'>
                            CSV File</a></td>
                    </tr>
                <?php
                    }
                    } else {
                        echo "<tr><td colspan='6'>No students found</td></tr>";
                    }
                ?>
            </table>

            <!-- Pagination links -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="admin_view_student.php?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php else: ?>
                    <a class="disabled">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="admin_view_student.php?page=<?php echo $i; ?>"<?php if ($i == $page) {
        echo 'class="active"';
}
?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="admin_view_student.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php else: ?>
                    <a class="disabled">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </center>
    </div>
</body>
</html>