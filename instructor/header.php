<?php require_once 'auth.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - LearnHub LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-success sidebar min-vh-100">
                <div class="position-sticky pt-3">
                    <div class="text-center py-4">
                        <h4 class="text-white"><i class="bi bi-person-badge"></i> Instructor Panel</h4>
                        <p class="text-light small">Welcome, <?php echo $full_name ?></p>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="index.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="upload_course.php">
                                <i class="bi bi-cloud-upload"></i> Upload Course
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="add_lessons.php">
                                <i class="bi bi-file-earmark-plus"></i> Add Lessons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="create_quiz.php">
                                <i class="bi bi-question-circle"></i> Create Quiz
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="student_progress.php">
                                <i class="bi bi-graph-up"></i> Student Progress
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="logout.php">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>