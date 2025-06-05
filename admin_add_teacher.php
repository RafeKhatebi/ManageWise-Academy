<?php

    session_start();
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
    } elseif ($_SESSION['usertype'] == 'student') {
        header("location:login.php");
    }
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $db       = "schoolproject";

    $data = mysqli_connect($host, $user, $password, $db);
    if (isset($_POST['add_teacher'])) {
        $t_name        = $_POST['name'];
        $t_description = $_POST['description'];
        $file          = $_FILES['image']['name'];
        $dst           = "./image/" . $file;
        $dst_db        = "image/" . $file;
        move_uploaded_file($_FILES['image']['tmp_name'], $dst);
        $sql = "INSERT INTO teacher (name,description,image)
    VALUES ('$t_name','$t_description','$dst_db')";
        $result = mysqli_query($data, $sql);
        if ($result) {
            echo "<script type='text/javascript'>
    alert('Data uploaded successfuly');
    </script>
    ";
        } else {
            echo "<script type='text/javascript'>
    alert('Data not uploaded ');
    </script>
    ";
        }

        if ($result) {
            header('location:admin_add_teacher.php');
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
            <h1>Admin Teacher</h1>
            <br>
            <div class="div_deg">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div>
                        <label>TeacherName</label>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <label>Description</label>
                        <textarea name="description"></textarea>
                    </div>
                    <div>
                        <label>Image:</label>
                        <input type="file" name="image">
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