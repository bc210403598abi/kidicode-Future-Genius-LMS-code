<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kidicode</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<?php
include 'db.php';
$messages = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $dob       = $_POST['dob'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];
    $terms     = isset($_POST['terms']) ? 1 : 0;
    $address = $_POST['address'];

    // Password Match Check
    if ($password !== $confirm) {
        $messages = "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {

        // Check Email OR Phone Already Exists
        $check_user = "SELECT id, email, phone FROM users 
                       WHERE email = '$email' OR phone = '$phone' 
                       LIMIT 1";

        $result = mysqli_query($conn, $check_user);

        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email) {
                $messages = "<div class='alert alert-warning'>
                    Email already registered. Please login.
                </div>";
            } elseif ($row['phone'] === $phone) {
                $messages = "<div class='alert alert-warning'>
                    Phone number already registered.
                </div>";
            }

        } else {

            //Image Upload
            $profile_name = null;
            if (!empty($_FILES['profile']['name'])) {
                $profile_name = time() . "_" . $_FILES['profile']['name'];
                
                move_uploaded_file(
                    $_FILES['profile']['tmp_name'],
                
                    "uploads/" . $profile_name
                );

            }
            //Insert Query
            $sql = "INSERT INTO users 
                (full_name, dob, email, phone, password, user_type, profile, terms_accepted, address)
                VALUES
                ('$full_name', '$dob', '$email', '$phone', '$password', '$user_type', '$profile_name', '$terms', '$address')";

            if (mysqli_query($conn, $sql)) {
                $messages = "<div class='alert alert-success'>
                    Registration Successful
                </div>";
            } else {
                $messages = "<div class='alert alert-danger'>
                    Error: " . mysqli_error($conn) . "
                </div>";
            }
        }
    }
}
?>

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
                <a class="nav-link text-white" href="login.php">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Registration Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="h2 text-primary">Create Your Account</h1>
                            <p class="text-muted">Join Kidicode LMS and start your learning journey</p>
                            <?php echo $messages ?>
                        </div>
                        <!-- Registration Form -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Password *</label>
                                    <input type="password" class="form-control" name="password" required>
                                    <div class="form-text">
                                        <small>Must be at least 8 characters with letters and numbers</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password *</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                   <div class="col-md-6">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select User Type *</label>
                                <select class="form-select" name="user_type" id="loginUserType" required>
                                    <option value="">-- Select your role --</option>
                                    <option value="student">Student</option>
                                    <option value="instructor">Instructor</option>
                                    <option value="parents">Parents</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Images</label>
                                <input type="file" class="form-control" name="profile">
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#termsModal">Terms & Conditions</a> and <a href="#"
                                            data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus"></i> Create Account
                                </button>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="window.location.href='login.php'">
                                    Already have an account? Login
                                </button>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>