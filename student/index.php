<?php 
require_once 'header.php'; 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Student Dashboard</h1>
        <button class="btn btn-success" onclick="location.href='enroll_courses.php'">
            <i class="bi bi-plus-circle"></i> Enroll New Course
        </button>
    </div>

<?php
// 1️⃣ Enrolled Courses Count
$qCourses = mysqli_query($conn,"
    SELECT COUNT(*) AS total 
    FROM course_enrollments 
    WHERE fkstudentID='$userid' AND enStatus='active'
");
$courseData = mysqli_fetch_assoc($qCourses);
$totalCourses = $courseData['total'] ?? 0;

// 2️⃣ Overall Completion %
$qProgress = mysqli_query($conn,"
    SELECT AVG(progress) AS avg_progress
    FROM course_enrollments
    WHERE fkstudentID='$userid'
");
$progressData = mysqli_fetch_assoc($qProgress);
$overallProgress = round($progressData['avg_progress'] ?? 0);

// 3️⃣ Points System
$qPoints = mysqli_query($conn,"
    SELECT SUM(total_score) AS quiz_points
    FROM quiz_result
    WHERE student_id='$userid' AND status='pass'
");
$p = mysqli_fetch_assoc($qPoints);
$quizPoints = $p['quiz_points'] ?? 0;

// Course Completion Bonus
$qBonus = mysqli_query($conn,"
    SELECT COUNT(*) AS completed
    FROM course_enrollments
    WHERE fkstudentID='$userid' AND progress=100
");
$b = mysqli_fetch_assoc($qBonus);
$completionBonus = ($b['completed'] ?? 0) * 200;

$totalPoints = $quizPoints + $completionBonus;

// 4️⃣ Badges
$badges = [];
if($totalPoints >= 500) $badges[] = "Quick Learner";
if($totalPoints >= 1000) $badges[] = "Quiz Master";
if(($b['completed'] ?? 0) >= 3) $badges[] = "Course Completer";

// 5️⃣ Leaderboard Rank
$qRank = mysqli_query($conn,"
    SELECT student_id, SUM(total_score) AS points
    FROM quiz_result
    GROUP BY student_id
    ORDER BY points DESC
");

$rank = 0;
$i = 1;
while($r = mysqli_fetch_assoc($qRank)){
    if($r['student_id'] == $userid){
        $rank = $i;
        break;
    }
    $i++;
}

// 6️⃣ My Enrolled Courses
$qMyCourses = mysqli_query($conn,"
    SELECT c.title, c.description, ce.progress
    FROM course_enrollments ce
    JOIN courses c ON c.id = ce.fkcourseID
    WHERE ce.fkstudentID='$userid'
");

// 7️⃣ Certificates (completed courses)
$qCert = mysqli_query($conn,"
    SELECT c.title, ce.enrolled_at
    FROM course_enrollments ce
    JOIN courses c ON c.id=ce.fkcourseID
    WHERE ce.fkstudentID='$userid' AND ce.progress=100
");
?>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">Enrolled Courses</h6>
                <h2 class="mb-0"><?= $totalCourses ?></h2>
                <p class="card-text">Active courses</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Completion %</h6>
                <h2 class="mb-0"><?= $overallProgress ?>%</h2>
                <p class="card-text">Overall progress</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title">Points Earned</h6>
                <h2 class="mb-0"><?= $totalPoints ?></h2>
                <p class="card-text"><i class="bi bi-star-fill"></i> Learning points</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title">Badges</h6>
                <h2 class="mb-0"><?= count($badges) ?></h2>
                <p class="card-text"><i class="bi bi-award-fill"></i> Achievements</p>
            </div>
        </div>
    </div>
</div>

<!-- Enrolled Courses -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">My Enrolled Courses</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php while($row = mysqli_fetch_assoc($qMyCourses)) { ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <p class="card-text"><?= $row['description'] ?></p>
                        <div class="mb-3">
                            <h6>Progress: <?= $row['progress'] ?>%</h6>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" style="width: <?= $row['progress'] ?>%"></div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">Continue Learning</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Certificates & Badges -->
<div class="row mt-4">
   <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Points & Badges</h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-warning"><?= $totalPoints ?> <i class="bi bi-star-fill"></i></h2>
                <p>Total Learning Points</p>

                <div class="d-flex justify-content-center flex-wrap gap-3 mt-3">
                    <?php foreach($badges as $b) { ?>
                        <div class="text-center">
                            <i class="bi bi-award-fill display-6 text-primary"></i>
                            <p><?= $b ?></p>
                        </div>
                    <?php } ?>
                </div>

                <div class="mt-3">
                    <h6>Leaderboard Rank: #<?= $rank ?></h6>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-warning" style="width: <?= $overallProgress ?>%">Top <?= 100 - $overallProgress ?>%</div>
                    </div>
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
