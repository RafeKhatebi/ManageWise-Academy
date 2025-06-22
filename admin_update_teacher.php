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

    // Get teacher data
    if (isset($_GET['teacher_id']) && ! empty($_GET['teacher_id'])) {
        $t_id = mysqli_real_escape_string($data, $_GET['teacher_id']);
        // Changed from 'teacher' to 'teachers_new'
        $sql    = "SELECT * FROM teachers_new WHERE id='$t_id'";
        $result = mysqli_query($data, $sql);

        if (! $result) {
            die("Query error: " . mysqli_error($data));
        }

        if (mysqli_num_rows($result) == 0) {
            die("Teacher not found");
        }

        $info = $result->fetch_assoc();
    } else {
        die("Teacher ID not provided");
    }

    // Handle update
    if (isset($_POST['update_teacher'])) {
        $id     = mysqli_real_escape_string($data, $_POST['id']);
        $t_name = mysqli_real_escape_string($data, $_POST['name']);
        $t_des  = mysqli_real_escape_string($data, $_POST['description']);
        $file   = $_FILES['image']['name'];

        // Create image directory if it doesn't exist
        if (! is_dir("./image/")) {
            mkdir("./image/", 0777, true);
        }

        if (! empty($file)) {
            $dst    = "./image/" . $file;
            $dst_db = "image/" . $file;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
                // Update with new image - Changed from 'teacher' to 'teachers_new'
                $sql2 = "UPDATE teachers_new SET name='$t_name', description='$t_des', image='$dst_db' WHERE id='$id'";
            } else {
                echo "<script>alert('File upload failed');</script>";
                // Update without image change - Changed from 'teacher' to 'teachers_new'
                $sql2 = "UPDATE teachers_new SET name='$t_name', description='$t_des' WHERE id='$id'";
            }
        } else {
            // Update without image change - Changed from 'teacher' to 'teachers_new'
            $sql2 = "UPDATE teachers_new SET name='$t_name', description='$t_des' WHERE id='$id'";
        }

        $result2 = mysqli_query($data, $sql2);

        if ($result2) {
            echo "<script>
        alert('Teacher updated successfully');
        window.location.href = 'admin_view_teacher.php';
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
    <title>Update Teacher</title>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Update Teacher Data</h1>
            <div class="div_deg">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($info['id']); ?>">
                    <div>
                        <label>Teacher Name:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($info['name']); ?>" required>
                    </div>
                    <div>
                        <label>About Teacher:</label>
                        <textarea name="description" rows="4" cols="40" required><?php echo htmlspecialchars($info['description']); ?></textarea>
                    </div>
                    <div>
                        <label>Teacher Current Image:</label>
                        <?php if (! empty($info['image']) && file_exists($info['image'])) {?>
                            <br><img class="img-fluid rounded" src="<?php echo htmlspecialchars($info['image']); ?>" alt="Current Image" style="width: 150px; height: 150px;">
                        <?php } else {?>
                            <br><span>No current image</span>
                        <?php }?>
                    </div>
                    <div>
                        <label>Choose New Image (optional):</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <div>
                        <input type="submit" name="update_teacher" value="Update Teacher" class="btn btn-success">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
