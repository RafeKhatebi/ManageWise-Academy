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
    if (isset($_POST['add_course'])) {
        $c_name = $_POST['name'];
        $c_fee  = $_POST['fee'];
        $c_des  = $_POST['description'];
        $c_date = $_POST['date'];
        echo $c_name;
        $sql = "INSERT INTO course (name,fee,description,date)
    VALUES ('$c_name','$c_fee','$c_des','$c_date')";
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
            header('location:add_course.php');
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
            <h1>Add Courses</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>Name:</label>
                        <select name="name">
                            <option value="english">English Language</option>
                            <option value="java">JAVA Pro Language</option>
                            <option value="php">PHP Pro language</option>
                        </select>
                    </div>
                    <div>
                        <label>fee:</label>
                        <input type="number" name="fee">
                    </div>
                    <div>
                        <label>Description:</label>
                        <textarea cols="30" rows="3" name="fee"></textarea>
                    </div>
                    <div>
                        <label>Date:</label>
                        <input type="date" name="date">
                    </div>

                    <div>
                        <input type="submit" name="add_course" value="Add Course" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>