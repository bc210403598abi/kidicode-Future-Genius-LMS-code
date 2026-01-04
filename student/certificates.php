<?php 
require_once 'header.php'; 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Certificates</h1>
        <button class="btn btn-primary" onclick="location.href='index.php'">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </button>
    </div>

<?php
// Fetch enrolled courses
$qCourses = mysqli_query($conn,"
    SELECT ce.id as enroll_id, ce.progress, c.id as course_id, c.title, c.difficulty
    FROM course_enrollments ce
    JOIN courses c ON c.id = ce.fkcourseID
    WHERE ce.fkstudentID='$userid'
");

// Stats & arrays
$totalEarned = 0;
$totalInProgress = 0;
$earnedCertificates = [];
$upcomingCertificates = [];

while($row = mysqli_fetch_assoc($qCourses)){
    if($row['progress'] >= 100){
        $totalEarned++;

        // Latest quiz score
        $qScore = mysqli_query($conn,"
            SELECT MAX(total_score) as score
            FROM quiz_result qr
            JOIN quiz q ON q.id=qr.quiz_id
            WHERE qr.student_id='$userid' AND q.fkcourseID='{$row['course_id']}'
        ");
        $s = mysqli_fetch_assoc($qScore);
        $score = $s['score'] ?? 0;

        // Certificate ID
        $certID = "CER-" . strtoupper(substr($row['title'],0,3)) . "-" . date('Y') . "-" . str_pad($row['enroll_id'],5,"0",STR_PAD_LEFT);

        $earnedCertificates[] = [
            'title'=>$row['title'],
            'difficulty'=>$row['difficulty'],
            'score'=>$score,
            'certID'=>$certID,
            'date'=>date('F d, Y')
        ];
    } else {
        $totalInProgress++;

        // ✅ UPDATED: added course_id
        $upcomingCertificates[] = [
            'course_id' => $row['course_id'], // ✅ REQUIRED
            'title'=>$row['title'],
            'difficulty'=>$row['difficulty'],
            'progress'=>$row['progress'],
            'requirements'=>['Complete all lessons','Pass all quizzes'],
            'estimatedDate'=>date('F d, Y', strtotime("+1 month"))
        ];
    }
}
?>

<!-- Certificates Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-award display-4 text-success mb-3"></i>
                <h5>Earned</h5>
                <h2 class="text-success"><?= $totalEarned ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-clock display-4 text-warning mb-3"></i>
                <h5>In Progress</h5>
                <h2 class="text-warning"><?= $totalInProgress ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Certificates -->
<div class="card mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Upcoming Certificates</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Certificate</th>
                        <th>Course</th>
                        <th>Progress</th>
                        <th>Requirements</th>
                        <th>Estimated Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($upcomingCertificates as $uc) { ?>
                    <tr>
                        <td>
                            <strong><?= $uc['title'] ?> Certificate</strong><br>
                            <small><?= ucfirst($uc['difficulty']) ?> Level</small>
                        </td>
                        <td><?= $uc['title'] ?></td>
                        <td>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" style="width: <?= $uc['progress'] ?>%"></div>
                            </div>
                            <small><?= $uc['progress'] ?>% complete</small>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <?php foreach($uc['requirements'] as $r) { ?>
                                    <li><i class="bi bi-check text-success"></i> <?= $r ?></li>
                                <?php } ?>
                            </ul>
                        </td>
                        <td><?= $uc['estimatedDate'] ?></td>

                        
                        <td>
                            <a href="view_courses.php?course_id=<?= $uc['course_id'] ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-play-circle"></i> Continue Course
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
