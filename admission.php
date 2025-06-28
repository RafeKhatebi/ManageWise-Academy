<?php
       require_once 'dbconnection.php';

    // Check connection
    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    
    $sql    = "SELECT * FROM admission_new";
    $result = mysqli_query($data, $sql);

    // Check if query was successful
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
    <link rel="stylesheet" href="./assets/css/admission.css">
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Applied For Admission</h1>
            <br>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Applied Date</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($info = $result->fetch_assoc()) {
                        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($info['name']); ?></td>
                        <td><?php echo htmlspecialchars($info['phone']); ?></td>
                        <td><?php echo htmlspecialchars($info['email']); ?></td>
                        <td><?php echo htmlspecialchars($info['message']); ?></td>
                        <td><?php echo htmlspecialchars($info['created_at']); ?></td>
                    </tr>
                <?php
                    }
                    } else {
                        echo "<tr><td colspan='5'>No admission applications found</td></tr>";
                    }
                ?>
            </table>
        </center>
    </div>
</body>
</html>
