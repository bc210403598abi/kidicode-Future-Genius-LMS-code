<?php require_once 'header.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-download"></i> Export
                </button>
            </div>
        </div>
    </div>

<?php
// Fetch stats
$qUsers = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($qUsers)['total'];

$qRevenue = mysqli_query($conn, "SELECT SUM(amount) AS total FROM payments");
$totalRevenue = mysqli_fetch_assoc($qRevenue)['total'];

$qCourses = mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses WHERE status='approved'");
$activeCourses = mysqli_fetch_assoc($qCourses)['total'];

// Avg Progress
$qEnroll = mysqli_query($conn, "SELECT progress FROM course_enrollments");
$progressSum = 0;
$progressCount = 0;
while($p = mysqli_fetch_assoc($qEnroll)){
    $progressSum += $p['progress'];
    $progressCount++;
}
$avgProgress = $progressCount ? round($progressSum / $progressCount) : 0;

//Student Progress Statistics Course wise
$qCourseStats = mysqli_query($conn, "SELECT c.id, c.title,
    (SELECT COUNT(*) FROM course_enrollments e WHERE e.fkcourseID=c.id) AS enrolled,
    (SELECT COUNT(*) FROM course_enrollments e WHERE e.fkcourseID=c.id AND e.progress=100) AS completed,
    (SELECT ROUND(AVG(progress)) FROM course_enrollments e WHERE e.fkcourseID=c.id) AS avg_score
    FROM courses c WHERE c.status='approved'");
$courseStats = [];
while($row = mysqli_fetch_assoc($qCourseStats)){
    $courseStats[] = $row;
}

?>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Users</h6>
                        <h2 class="mb-0"><?= $totalUsers ?></h2>
                    </div>
                    <i class="bi bi-people-fill display-6"></i>
                </div>
                <p class="card-text mt-2">All registered users</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Revenue</h6>
                        <h2 class="mb-0">$<?= number_format($totalRevenue) ?></h2>
                    </div>
                    <i class="bi bi-currency-dollar display-6"></i>
                </div>
                <p class="card-text mt-2">From all payments</p>
            </div>
        </div>0
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Active Courses</h6>
                        <h2 class="mb-0"><?= $activeCourses ?></h2>
                    </div>
                    <i class="bi bi-book-half display-6"></i>
                </div>
                <p class="card-text mt-2">Approved courses</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Avg Progress</h6>
                        <h2 class="mb-0"><?= $avgProgress ?>%</h2>
                    </div>
                    <i class="bi bi-graph-up display-6"></i>
                </div>
                <p class="card-text mt-2">Student completion rate</p>
            </div>
        </div>
    </div>
</div>

<!-- Course-wise Progress Table  Student Progress Statistics-->
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Student Progress Statistics</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Enrolled</th>
                                <th>Completed</th>
                                <th>Avg Score</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($courseStats as $cs){ ?>
                            <tr>
                                <td><?= $cs['title'] ?></td>
                                <td><?= $cs['enrolled'] ?></td>
                                <td><?= $cs['completed'] ?></td>
                                <td><?= $cs['avg_score'] ? $cs['avg_score'].'%' : 'N/A' ?></td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar" style="width: <?= $cs['avg_score'] ? $cs['avg_score'] : 0 ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
