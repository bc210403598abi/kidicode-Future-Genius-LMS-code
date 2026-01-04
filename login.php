<?php
session_start();
include 'db.php';

$messages = '';

if (isset($_POST['login-btn'])) {
    $email    = $_POST['email'];  
    $password = $_POST['password'];
    $sql = "SELECT * FROM users 
            WHERE email = '$email' OR phone = '$email'
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        $messages = "<div class='alert alert-danger mt-3'>
            Invalid Email/Phone or Password
        </div>";
    } else {
        $data = mysqli_fetch_assoc($result);
        if ($data['password'] != $password) {
            $messages = "<div class='alert alert-danger mt-3'>
                Invalid Email or Password
            </div>";
        } else {
            if ($data['status'] == 'inactive') {
                $messages = "<div class='alert alert-warning mt-3'>
                    Your account is inactive. Approval required.
                </div>";
            } elseif ($data['status'] == 'blocked') {
                $messages = "<div class='alert alert-danger mt-3'>
                    Your account has been blocked by admin.
                </div>";
            } else {
               // Session Set
                $_SESSION['id']        = $data['id'];
                $_SESSION['user_type'] = $data['user_type'];
                $_SESSION['authemail'] = $data['email'];
                // Role Wise Redirect
                if ($data['user_type'] == 'admin') {
                    header("Location: admin/index.php");
                } elseif ($data['user_type'] == 'student') {
                    header("Location: student/index.php");
                } elseif ($data['user_type'] == 'instructor') {
                    header("Location: instructor/index.php");
                } elseif ($data['user_type'] == 'parents') {
                    header("Location: parents/index.php");
                } else {
                    header("Location: login.php");
                }
                exit();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kidicode</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-mortarboard-fill"></i> Kidicode
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="index.php">
                    <i class="bi bi-house"></i> Home
                </a>
                <a class="nav-link text-white" href="register.php">
                    <i class="bi bi-person-plus"></i> Register
                </a>

            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="h2 text-primary">Welcome Back</h1>
                            <p class="text-muted">Login to your LearnHub LMS account</p>
                            <?php echo $messages ?>
                        </div>
                        <!-- Login Form -->
                        <form action="" method="post">
                            <div class="mb-4">
                                <label class="form-label">Email *</label>
                                <input type="text" class="form-control" name="email" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" name="login-btn" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>


                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Enter your email address and we'll send you instructions to reset your password.</p>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User Type</label>
                        <select class="form-select">
                            <option value="">Select user type</option>
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send Reset Link</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-mortarboard-fill"></i> LearnHub LMS</h5>
                    <p>Your learning journey starts here</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">&copy; 2023 LearnHub LMS. All rights reserved.</p>
                    <p class="mb-0">
                        <a href="#" class="text-white text-decoration-none me-3">Help</a>
                        <a href="#" class="text-white text-decoration-none">Contact</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>