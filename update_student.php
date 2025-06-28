<?php
        require_once 'dbconnection.php';

    if ($data === false) {
        die("Connection error: " . mysqli_connect_error());
    }

    $id = $_GET['student_id'];

    // Change 'user' to 'users' to match your actual table name
    $sql    = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($data, $sql);

    // Add error checking
    if (! $result) {
        die("Query error: " . mysqli_error($data));
    }

    if (mysqli_num_rows($result) == 0) {
        die("Student not found");
    }

    $info = $result->fetch_assoc();

    if (isset($_POST['update'])) {
        $name     = mysqli_real_escape_string($data, $_POST['name']);
        $phone    = mysqli_real_escape_string($data, $_POST['phone']);
        $email    = mysqli_real_escape_string($data, $_POST['email']);
        $password = mysqli_real_escape_string($data, $_POST['password']);

        // Change 'user' to 'users' here too
        $query   = "UPDATE users SET username='$name', phone='$phone', email='$email', password='$password' WHERE id='$id'";
        $result2 = mysqli_query($data, $query);

        if ($result2) {
            $_SESSION['message'] = "Student updated successfully!";
            header("location:view_student.php");
            exit();
        } else {
            echo "Update failed: " . mysqli_error($data);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'admin_css.php'; ?>
    <title>Update Student!</title>
    <link rel="stylesheet" href="./assets/css/common.css">
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Update Student</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>User name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($info['username']); ?>" required>
                    </div>
                    <div>
                        <label>Phone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($info['phone']); ?>">
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($info['email']); ?>">
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="text" name="password" value="<?php echo htmlspecialchars($info['password']); ?>" required>
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update" class="btn btn-success">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
