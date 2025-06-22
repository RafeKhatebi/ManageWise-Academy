<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/login.css" />
</head>
<body class="login-bg">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg login-card">
            <div class="card-header text-center bg-info text-white">
                <h3 class="mb-0">Login Form</h3>
                <h4>
                    <?php
                        error_reporting(0);
                        session_start();

                        // Display login message if exists
                        if (isset($_SESSION['loginMessage'])) {
                            echo $_SESSION['loginMessage'];
                            // Clear the message after displaying it
                            unset($_SESSION['loginMessage']);
                        }
                    ?>
                </h4>
            </div>
            <div class="card-body p-4">
                <form action="login_check.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label text-info fw-bold">User Name</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-info fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-info text-white fw-bold">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-transparent">
                <a href="#" class="text-info small">Forgot Password?</a>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
