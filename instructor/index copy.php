<?php 
require_once 'header.php'; 
$teacherID = $userid;
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Instructor Dashboard</h1>
        <button class="btn btn-success" onclick="location.href='upload_course.php'">
            <i class="bi bi-plus-circle"></i> Upload New Course
        </button>
    </div>

<?php
// Fetch teacher courses
$qCourses = mysqli_query($conn, "SELECT * FROM courses WHERE fkteacherID='$teacherID'");
$courses = [];
$totalStudentsAll = 0;
$completionRates = [];
$ratings = []; // Placeholder, can be computed from reviews

while($c = mysqli_fetch_assoc($qCourses)){
    // Count enrolled students
    $qEnroll = mysqli_query($conn, "SELECT * FROM course_enrollments WHERE fkcourseID='{$c['id']}'");
    $studentCount = mysqli_num_rows($qEnroll);
    $totalStudentsAll += $studentCount;

    // Average completion
    $progressSum = 0;
    $progressCount = 0;
    while($e = mysqli_fetch_assoc($qEnroll)){
        $progressSum += $e['progress'];
        $progressCount++;
    }
    $avgCompletion = $progressCount ? round($progressSum/$progressCount) : 0;
    $completionRates[] = $avgCompletion;

    $courses[] = [
        'id'=>$c['id'],
        'title'=>$c['title'],
        'students'=>$studentCount,
        'rating'=>rand(4,5), // Placeholder for ratings
        'completion'=>$avgCompletion,
        'status'=>$c['status']
    ];
}

// Overall stats
$avgCompletionAll = count($completionRates) ? round(array_sum($completionRates)/count($completionRates)) : 0;
$avgRatingAll = count($courses) ? round(array_sum(array_column($courses,'rating'))/count($courses),1) : 0;
$totalCourses = count($courses);
?>

<!-- Stats -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">My Courses</h6>
                <h2 class="mb-0"><?= $totalCourses ?></h2>
                <p class="card-text">Active courses</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Total Students</h6>
                <h2 class="mb-0"><?= $totalStudentsAll ?></h2>
                <p class="card-text">Across all courses</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title">Avg Rating</h6>
                <h2 class="mb-0"><?= $avgRatingAll ?> <i class="bi bi-star-fill text-warning"></i></h2>
                <p class="card-text">Out of 5.0</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title">Completion Rate</h6>
                <h2 class="mb-0"><?= $avgCompletionAll ?>%</h2>
                <p class="card-text">Student completion</p>
            </div>
        </div>
    </div>
</div>

<!-- My Courses Table -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">My Courses</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Students</th>
                        <th>Avg Completion</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($courses as $c){ ?>
                    <tr>
                        <td><?= $c['title'] ?></td>
                        <td><?= $c['students'] ?></td>
                        <td><?= $c['completion'] ?>%</td>
                        <td><?= $c['rating'] ?> <i class="bi bi-star-fill text-warning"></i></td>
                        <td><span class="badge bg-<?= $c['status']=='approved' ? 'success' : ($c['status']=='pending' ? 'warning' : 'danger') ?>"><?= ucfirst($c['status']) ?></span></td>
                        <td>
                            <a href="student_progress.php" class="btn btn-sm btn-success">View Progress</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
