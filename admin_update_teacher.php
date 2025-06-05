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
    if ($_GET['teacher_id']) {
        $t_id   = ($_GET['teacher_id']);
        $sql    = "SELECT * FROM teacher WHERE id='$t_id'";
        $result = mysqli_query($data, $sql);
        $info   = $result->fetch_assoc();
    }
    // $id = $_GET['teacher_id'];

    if (isset($_POST['update_teacher'])) {
        $id     = $_POST['id'];
        $t_name = $_POST['name'];
        $t_des  = $_POST['description'];
        $file   = $_FILES['image']['name'];
        $dst    = "./image/" . $file;
        $dst_db = "image/" . $file;
        move_uploaded_file($_FILES['image']['tmp_name'], $dst);
        if ($file) {
            $sql2 = "UPDATE teacher  SET  name='$t_name',description='$t_des', image='$dst_db' WHERE id='$id'";
        } else {
            $sql2 = "UPDATE teacher  SET  name='$t_name',description='$t_des' WHERE id='$id'";
        }

        $result2 = mysqli_query($data, $sql2);

        if ($result2) {
            header("location:admin_view_teacher.php");
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
                    <input hidden type="text" name="id" value="<?php echo "{$info['id']}"; ?>">
                    <div>
                        <label>Teacher Name:</label>
                        <input type="text" name="name" value="                                                                                                                             <?php echo "{$info['name']}"; ?>">
                    </div>
                    <div>
                        <label>About Teacher :</label>
                        <textarea name="description" rows="4" cols="40">
                        <?php echo "{$info['description']}"; ?>
                        </textarea>
                    </div>
                    <div><label>Teacher Old Image:</label>
                        <img class="img-fluid rounded" src="                                                                                                                          <?php echo "{$info['image']}"; ?>">
                    </div>
                    <div><label>Choose Teache New Image:</label>
                        <input type="file" name="image" value="                                                                                                                               <?php echo "{$info['image']}"; ?>">
                    </div>
                    <div>
                        <input type="submit" name="update_teacher" value="Update" class="btn btn-success">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>