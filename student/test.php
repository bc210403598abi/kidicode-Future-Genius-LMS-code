<?php require_once 'header.php' ?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Learning Courses</h1>
        <button class="btn btn-primary" onclick="location.href='enroll_courses.html'">
            <i class="bi bi-plus-circle"></i> Enroll New Course
        </button>
    </div>

    <!-- Active Courses -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Active Courses (3)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Python Course -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title">Python Programming</h5>
                                <span class="badge bg-success">85% Complete</span>
                            </div>
                            <p class="card-text">Learn Python from basics to advanced concepts.</p>

                            <div class="mb-3">
                                <h6>Progress:</h6>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar" style="width: 85%">85%</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Recent Activity:</h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <small class="text-success">Today</small><br>
                                        Completed "Functions" lesson
                                    </div>
                                    <div class="list-group-item">
                                        <small>Yesterday</small><br>
                                        Quiz score: 18/20
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-success">
                                    <i class="bi bi-play-circle"></i> Continue Learning
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-list-check"></i> View Syllabus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Dev Course -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title">Web Development</h5>
                                <span class="badge bg-warning">65% Complete</span>
                            </div>
                            <p class="card-text">HTML, CSS, and JavaScript fundamentals.</p>

                            <div class="mb-3">
                                <h6>Progress:</h6>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-warning" style="width: 65%">65%</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Upcoming:</h6>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Assignment due in 2 days
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Next Lesson:</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <strong>JavaScript Functions</strong><br>
                                        <small>Estimated time: 45 minutes</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-warning">
                                    <i class="bi bi-play-circle"></i> Continue Learning
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-clock"></i> View Schedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Python Programming - Course Content</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="courseContent">
                        <!-- Module 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module1">
                                    Module 1: Python Basics (Completed 5/5)
                                </button>
                            </h2>
                            <div id="module1" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
                                <div class="accordion-body">
                                    <div class="list-group">
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Introduction to Python
                                                </div>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Variables and Data Types
                                                </div>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Quiz: Python Basics
                                                </div>
                                                <small>Score: 18/20</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module2">
                                    Module 2: Control Structures (In Progress 3/4)
                                </button>
                            </h2>
                            <div id="module2" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                                <div class="accordion-body">
                                    <div class="list-group">
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Conditional Statements
                                                </div>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Loops
                                                </div>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-success">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    Functions
                                                </div>
                                                <small>Completed Today</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle text-primary"></i>
                                                    Assignment: Control Flow
                                                </div>
                                                <button class="btn btn-sm btn-primary">Start</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module3">
                                    Module 3: Advanced Topics (0/6)
                                </button>
                            </h2>
                            <div id="module3" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                                <div class="accordion-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-lock text-secondary"></i>
                                                    Object-Oriented Programming
                                                </div>
                                                <small>Locked</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-lock text-secondary"></i>
                                                    File Handling
                                                </div>
                                                <small>Locked</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-lock text-secondary"></i>
                                                    Error Handling
                                                </div>
                                                <small>Locked</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Stats -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Learning Streak</h5>
                    <h2 class="text-success">7 days</h2>
                    <p>Keep it up! 🔥</p>
                    <div class="d-flex justify-content-center">
                        <i class="bi bi-fire text-danger fs-4 mx-1"></i>
                        <i class="bi bi-fire text-danger fs-4 mx-1"></i>
                        <i class="bi bi-fire text-danger fs-4 mx-1"></i>
                        <i class="bi bi-fire text-danger fs-4 mx-1"></i>
                        <i class="bi bi-fire text-danger fs-4 mx-1"></i>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h5>Time Spent</h5>
                    <div class="text-center">
                        <h2 class="text-primary">45h 30m</h2>
                        <p>Total learning time</p>
                    </div>
                    <div class="mb-3">
                        <h6>This Week:</h6>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <small>7.5 hours</small>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5>Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-download"></i> Download Materials
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-chat"></i> Ask Instructor
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="bi bi-people"></i> Course Forum
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="bi bi-clock-history"></i> Learning History
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

sari detaisl isi templates me aie ta kh access kr ske and aik row me 2 cards houn show countinu learning me video aie g jo course me h view syllabus pr click kre to lesson show honmge and Quick Actions  me baqi download wala material ho 