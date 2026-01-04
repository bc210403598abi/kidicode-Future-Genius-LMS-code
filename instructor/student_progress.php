<?php 
require_once 'header.php'; 
$teacherID = $userid;
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Student Progress Monitoring</h1>
        <button class="btn btn-success" onclick="location.href='instructor_dashboard.php'">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </button>
    </div>

    <!-- Course Selection -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Select Course</label>
                    <select class="form-select" id="progressCourseSelect" onchange="this.form.submit()">
                        <option value="">-- All Courses --</option>
                        <?php
                        $qCourses = mysqli_query($conn, "SELECT * FROM courses WHERE fkteacherID='$teacherID'");
                        while($c = mysqli_fetch_assoc($qCourses)){
                            echo '<option value="'.$c['id'].'">'.$c['title'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Filter by Status</label>
                    <select class="form-select" onchange="this.form.submit()">
                        <option value="all">All Students</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="struggling">Struggling</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

<?php
$selectedCourse = $_GET['course'] ?? '';
$statusFilter = $_GET['status'] ?? 'all';

// Fetch students for selected course
$whereCourse = $selectedCourse ? "AND ce.fkcourseID='$selectedCourse'" : "";
$studentsQuery = mysqli_query($conn, "
    SELECT u.id as student_id, u.full_name, u.email, ce.progress, ce.enStatus,
    (SELECT MAX(total_score) FROM quiz_result qr JOIN quiz q ON q.id=qr.quiz_id WHERE qr.student_id=u.id AND q.fkcourseID=ce.fkcourseID) as score,
    ce.enrolled_at
    FROM course_enrollments ce
    JOIN users u ON u.id=ce.fkstudentID
    WHERE u.user_type='student' $whereCourse
");

// Build table rows
$students = [];
while($s = mysqli_fetch_assoc($studentsQuery)){
    $status = 'Active';
    if($s['progress'] >= 100) $status = 'Completed';
    elseif($s['progress'] < 50) $status = 'Struggling';

    if($statusFilter != 'all' && strtolower($status) != strtolower($statusFilter)) continue;

    $students[] = [
        'name'=>$s['full_name'],
        'email'=>$s['email'],
        'progress'=>$s['progress'],
        'last_active'=>date('M d, Y', strtotime($s['enrolled_at'])),
        'score'=>$s['score'] ?? 0,
        'status'=>$status
    ];
}

// Compute stats
$totalStudents = count($students);
$avgProgress = $totalStudents ? round(array_sum(array_column($students,'progress'))/$totalStudents) : 0;
$avgScore = $totalStudents ? round(array_sum(array_column($students,'score'))/$totalStudents) : 0;
$atRisk = count(array_filter($students, fn($st)=>$st['status']=='Struggling'));
?>

<!-- Progress Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h6 class="card-title">Total Students</h6>
                <h2 class="mb-0"><?= $totalStudents ?></h2>
                <p class="card-text">In selected course</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6 class="card-title">Avg Progress</h6>
                <h2 class="mb-0"><?= $avgProgress ?>%</h2>
                <p class="card-text">Overall completion</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h6 class="card-title">Avg Score</h6>
                <h2 class="mb-0"><?= $avgScore ?>%</h2>
                <p class="card-text">Quiz performance</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h6 class="card-title">At Risk</h6>
                <h2 class="mb-0"><?= $atRisk ?></h2>
                <p class="card-text">Need attention</p>
            </div>
        </div>
    </div>
</div>

<!-- Student Progress Table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Student Progress Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Progress</th>
                        <th>Last Active</th>
                        <th>Quiz Scores</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($students as $st){ 
                    $progressBar = 'bg-success';
                    $statusBadge = 'bg-success';
                    if($st['progress']<50){ $progressBar='bg-danger'; $statusBadge='bg-danger'; }
                    elseif($st['progress']<80){ $progressBar='bg-warning'; $statusBadge='bg-warning'; }
                ?>
                    <tr class="<?= $statusBadge=='bg-danger' ? 'table-danger' : '' ?>">
                        <td>
                            <strong><?= $st['name'] ?></strong><br>
                            <small><?= $st['email'] ?></small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div style="width: 100px;" class="me-2">
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar <?= $progressBar ?>" style="width: <?= $st['progress'] ?>%"></div>
                                    </div>
                                </div>
                                <span><?= $st['progress'] ?>%</span>
                            </div>
                        </td>
                        <td><?= $st['last_active'] ?></td>
                        <td>
                            <span class="badge <?= $statusBadge ?>"><?= $st['score'] ?>%</span>
                        </td>
                        <td>
                            <span class="badge <?= $statusBadge ?>"><?= $st['status'] ?></span>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Student Engagement -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Student Engagement</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Average Time Spent: <span class="text-success">45 mins/day</span></h6>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Assignment Submission Rate: <span class="text-success">88%</span></h6>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 88%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Quiz Attempt Rate: <span class="text-warning">72%</span></h6>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: 72%"></div>
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
