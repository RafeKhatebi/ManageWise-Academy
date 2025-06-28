<?php
       require_once 'dbconnection.php';
    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Handle delete request BEFORE selecting data
    if (isset($_GET['teacher_id']) && ! empty($_GET['teacher_id'])) {
        $t_id    = mysqli_real_escape_string($data, $_GET['teacher_id']);
        $sql2    = "DELETE FROM teachers_new WHERE id='$t_id'";
        $result2 = mysqli_query($data, $sql2);
        if ($result2) {
            header('location:admin_view_teacher.php');
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
    $total_records_sql    = "SELECT COUNT(*) AS total FROM teachers_new";
    $total_records_result = mysqli_query($data, $total_records_sql);
    $total_records_row    = mysqli_fetch_assoc($total_records_result);
    $total_records        = $total_records_row['total'];
    $total_pages          = ceil($total_records / $records_per_page);

    // Select teachers for current page
    $sql    = "SELECT * FROM teachers_new LIMIT $offset, $records_per_page";
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
            <h1>View All Teacher Data</h1><br>
            <table>
                <tr>
                    <th>Teacher Name</th>
                    <th>About Teacher</th>
                    <th>Image</th>
                    <th>Delete</th>
                    <th>Update</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($info = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($info['name']); ?></td>
                        <td><?php echo htmlspecialchars($info['description']); ?></td>
                        <td>
                            <?php if (! empty($info['image']) && file_exists($info['image'])) {?>
                                <img class="teacher img-fluid rounded" src="<?php echo htmlspecialchars($info['image']); ?>" alt="Teacher Image" style="width: 100px; height: 100px;">
                            <?php } else {?>
                                No Image
                            <?php }?>
                        </td>
                        <td>
                            <a class='btn btn-danger'
                               onClick="javascript:return confirm('Are you sure you want to delete this teacher?');"
                               href='admin_view_teacher.php?teacher_id=<?php echo $info['id']; ?>'>
                               Delete
                            </a>
                        </td>
                        <td>
                            <a class='btn btn-primary'
                               href='admin_update_teacher.php?teacher_id=<?php echo $info['id']; ?>'>
                               Update
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                    } else {
                        echo "<tr><td colspan='5'>No teachers found</td></tr>";
                    }
                ?>
            </table>

            <!-- Pagination links -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="admin_view_teacher.php?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php else: ?>
                    <a class="disabled">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="admin_view_teacher.php?page=<?php echo $i; ?>"<?php if ($i == $page) {
        echo 'class="active"';
}
?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="admin_view_teacher.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php else: ?>
                    <a class="disabled">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </center>
    </div>
</body>
</html>