<?php
    error_reporting(0);
    session_start();
    session_destroy();
    if ($_SESSION['message']) {
        $message = $_SESSION['message'];
        echo "<script type='text/javascript'>
    alert('$message');
    </script>";
    }
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $db       = "schoolproject";

    $data   = mysqli_connect($host, $user, $password, $db, "3307");
    $sql    = "SELECT * FROM teacher";
    $result = mysqli_query($data, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>W-School - Student Management System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/index.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-info bg-info fixed-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand text-white fw-bold" href="#">W-School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">Admission</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success px-4" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="position-relative text-center text-white mt-5 pt-4">
        <img class="w-100 img-fluid" src="img/sc.jpg" alt="School Image" style="max-height: 450px; object-fit: cover;" />
        <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 p-4 rounded">
            <h2 class="fs-2 fw-bold">We Teach Students with Care</h2>
        </div>
    </section>

    <main class="container my-5">
        <!-- Welcome Section -->
        <div class="row align-items-center gy-4">
            <div class="col-lg-4 col-md-6">
                <img class="img-fluid rounded shadow-sm" src="img/sc.jpg" alt="School Image 2" />
            </div>
            <div class="col-lg-8 col-md-6">
                <h1 class="mb-3">Welcome to W-School</h1>
                <p class="lead text-muted">
                    A school is an educational institution where students learn various subjects and develop skills.
                    It provides a supportive environment for growth, fostering social interactions and academic excellence.
                    Schools often include extracurricular activities to enhance students' overall development and prepare them
                    for future careers and personal success. Schools typically have dedicated teachers and staff who guide students
                    through their educational journey. The curriculum is designed to cater to different learning styles, ensuring
                    that each student reaches their full potential.
                </p>
            </div>
        </div>

        <!-- Our Teachers Section -->
        <section class="my-5 text-center">
            <h1 class="mb-4">Our Teachers</h1>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php
                    while ($info = $result->fetch_assoc()) {
                    ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?php echo htmlspecialchars($info['image']); ?>" class="card-img-top rounded-top" alt="Teacher:<?php echo htmlspecialchars($info['name']); ?>" style="height: 250px; object-fit: cover;" />
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($info['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($info['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </section>

        <!-- Our Courses Section -->
        <section class="my-5 text-center">
            <h1 class="mb-4">Our Courses</h1>
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="img/web2.png" class="card-img-top rounded-top" alt="Web Developer" style="height: 250px; object-fit: cover;" />
                        <div class="card-body">
                            <h5 class="card-title">Web Developer</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="img/web1.png" class="card-img-top rounded-top" alt="Graphic Designer" style="height: 250px; object-fit: cover;" />
                        <div class="card-body">
                            <h5 class="card-title">Graphic Designer</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="img/web.png" class="card-img-top rounded-top" alt="Marketing" style="height: 250px; object-fit: cover;" />
                        <div class="card-body">
                            <h5 class="card-title">Marketing</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admission Form Section -->
        <section class="admission-form-section my-5">
            <h1 class="text-center mb-4">Admission Form</h1>
            <form class="mx-auto needs-validation" style="max-width: 600px;" method="POST" action="data_check.php" novalidate>
                <div class="row mb-3 align-items-center">
                    <label for="name" class="col-sm-3 col-form-label text-sm-end fw-semibold">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" required />
                        <div class="invalid-feedback">
                            Please enter your name.
                        </div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="phone" class="col-sm-3 col-form-label text-sm-end fw-semibold">Phone</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="^\+?\d{10,15}$" required />
                        <div class="invalid-feedback">
                            Please enter a valid phone number.
                        </div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="email" class="col-sm-3 col-form-label text-sm-end fw-semibold">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" required />
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                </div>
                <div class="row mb-4 align-items-start">
                    <label for="message" class="col-sm-3 col-form-label text-sm-end fw-semibold">Message</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        <div class="invalid-feedback">
                            Please enter a message.
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="apply" class="btn btn-primary px-5">Apply</button>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 W-School. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="bootstrap.bundle.js"></script>

    <!-- Form validation script -->
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>
