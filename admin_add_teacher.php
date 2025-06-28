<?php
    require_once 'dbconnection.php';

    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    if (isset($_POST['add_teacher'])) {
        $t_name        = mysqli_real_escape_string($data, $_POST['name']);
        $t_description = mysqli_real_escape_string($data, $_POST['description']);
        $file          = $_FILES['image']['name'];
        $dst           = "./image/" . $file;
        $dst_db        = "image/" . $file;
        // Sanitize inputs
        $t_name        = htmlspecialchars($t_name, ENT_QUOTES, 'UTF-8');
        $t_description = htmlspecialchars($t_description, ENT_QUOTES, 'UTF-8');
        // Validate inputs
        $t_name        = trim($t_name);
        $t_description = trim($t_description);

        // Create image directory if it doesn't exist
        if (! is_dir("./image/")) {
            mkdir("./image/", 0777, true);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $dst);

        // Changed table name from 'teacher' to 'teachers_new'
        $sql    = "INSERT INTO teachers_new (name, description, image) VALUES ('$t_name', '$t_description', '$dst_db')";
        $result = mysqli_query($data, $sql);

        if ($result) {
            echo "<script type='text/javascript'>
        alert('Teacher added successfully');
        window.location.href = 'admin_add_teacher.php';
        </script>";
        } else {
            echo "<script type='text/javascript'>
        alert('Error: " . mysqli_error($data) . "');
        </script>";
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
            <h1>Add Teacher</h1>
            <br>
            <div class="div_deg">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div>
                        <label>Teacher Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label>Description</label>
                        <textarea name="description" required></textarea>
                    </div>
                    <div>
                        <label>Image:</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <div>
                        <input type="submit" name="add_teacher" value="Add Teacher" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
