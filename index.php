<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Professional Learning Platform</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
    <style>

    </style>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Kidicode
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="login.php" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-5 fw-bold text-dark mb-4">
                        Welcome to LearnHub - Your Learning Management System
                    </h1>
                    <p class="lead text-muted mb-4">
                        A comprehensive platform for students, instructors, and administrators to manage learning experiences effectively.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#portfolio" class="btn btn-primary btn-lg">
                            <i class="bi bi-book me-2"></i>Explore Courses
                        </a>
                        <a href="register.php" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Register Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Learning Platform" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <h3 class="text-primary fw-bold">50K+</h3>
                            <p class="text-muted mb-0">Active Learners</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <h3 class="text-primary fw-bold">500+</h3>
                            <p class="text-muted mb-0">Certified Instructors</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <h3 class="text-primary fw-bold">1.2K+</h3>
                            <p class="text-muted mb-0">Premium Courses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <h3 class="text-primary fw-bold">95%</h3>
                            <p class="text-muted mb-0">Success Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Platform Features</h2>
                <p class="text-muted lead">Everything you need for effective learning management</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-4">
                                <i class="bi bi-book text-primary fs-3"></i>
                            </div>
                            <h5 class="card-title mb-3">Course Management</h5>
                            <p class="card-text text-muted">
                                Create, edit, and manage courses with different difficulty levels for structured learning.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-4">
                                <i class="bi bi-question-circle text-success fs-3"></i>
                            </div>
                            <h5 class="card-title mb-3">Quizzes & Assessments</h5>
                            <p class="card-text text-muted">
                                Multiple choice, coding challenges, and subjective questions for comprehensive evaluation.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-4">
                                <i class="bi bi-trophy text-warning fs-3"></i>
                            </div>
                            <h5 class="card-title mb-3">Gamification</h5>
                            <p class="card-text text-muted">
                                Points, badges, and leaderboards to increase student engagement and motivation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio -->
    <section id="portfolio" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Company Portfolio</h2>
                <p class="text-muted lead">Our achievements and success stories</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-trophy text-warning display-6 mb-4"></i>
                            <h5 class="card-title mb-3">Our Achievements</h5>
                            <p class="card-text text-muted">
                                • 50,000+ Active Learners<br>
                                • 95% Satisfaction Rate<br>
                                • Award-Winning Platform<br>
                                • 500+ Certified Instructors
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-person-check text-success display-6 mb-4"></i>
                            <h5 class="card-title mb-3">Success Stories</h5>
                            <p class="card-text text-muted">
                                "LearnHub transformed my career in just 6 months!"
                                <br><strong>- Sarah Johnson</strong>
                            </p>
                            <a href="#" class="btn btn-outline-success mt-3">View More Stories</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-laptop text-primary display-6 mb-4"></i>
                            <h5 class="card-title mb-3">Training Programs</h5>
                            <p class="card-text text-muted">
                                • Web Development<br>
                                • Data Science<br>
                                • Mobile App Development<br>
                                • Digital Marketing<br>
                                • Graphic Design
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section id="blog" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Latest Blog Posts</h2>
                <p class="text-muted lead">Insights and updates from our team</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">The Future of Online Learning</h5>
                            <p class="card-text text-muted">
                                How AI and machine learning are transforming education and making learning more personalized.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">March 20, 2023</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Gamification in Education</h5>
                            <p class="card-text text-muted">
                                Points, badges, and leaderboards increase student engagement by 40% in learning platforms.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">March 15, 2023</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Parent's Guide to Online Learning</h5>
                            <p class="card-text text-muted">
                                Tips for parents to effectively monitor and support their children's progress in online education.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">March 10, 2023</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-newspaper me-2"></i>View All Articles
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">What Our Students Say</h2>
                <p class="text-muted lead">Join thousands of satisfied learners</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-4">
                                "LearnHub completely changed my career trajectory. The courses are top-notch and the instructors are incredibly supportive."
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=2563eb&color=fff" 
                                     alt="Sarah Johnson" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                    <small class="text-muted">Senior Developer at TechCorp</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-4">
                                "The gamification features made learning fun and engaging. I completed three certifications in just 6 months!"
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=10b981&color=fff" 
                                     alt="Michael Chen" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">Michael Chen</h6>
                                    <small class="text-muted">Data Scientist at DataWorks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-4">
                                "As a working professional, the flexible learning schedule made it possible to upskill without compromising work."
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Priya+Sharma&background=f59e0b&color=fff" 
                                     alt="Priya Sharma" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">Priya Sharma</h6>
                                    <small class="text-muted">Product Manager at Innovate Inc.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="mb-3">Ready to Start Your Learning Journey?</h2>
                    <p class="mb-0">Join thousands of successful learners today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="register.php" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-right-circle me-2"></i>Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-mortarboard-fill me-2"></i>Kidicode
                    </h5>
                    <p class="text-light">
                        Transforming education through innovative technology and quality learning experiences.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">Features</a></li>
                        <li class="mb-2"><a href="#portfolio" class="text-white text-decoration-none">Portfolio</a></li>
                        <li class="mb-2"><a href="#blog" class="text-white text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Platform</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="login.php" class="text-white text-decoration-none">Student Login</a></li>
                        <li class="mb-2"><a href="login.php" class="text-white text-decoration-none">Instructor Login</a></li>
                        <li class="mb-2"><a href="login.php" class="text-white text-decoration-none">Admin Login</a></li>
                        <li class="mb-2"><a href="register.php" class="text-white text-decoration-none">Create Account</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <p class="text-light mb-2">
                        <i class="bi bi-envelope me-2"></i>contact@learnhub.com
                    </p>
                    <p class="text-light mb-2">
                        <i class="bi bi-phone me-2"></i>+1 (555) 123-4567
                    </p>
                    <p class="text-light mb-2">
                        <i class="bi bi-geo-alt me-2"></i>123 Education Street
                    </p>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2023 LearnHub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white me-3 text-decoration-none">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>