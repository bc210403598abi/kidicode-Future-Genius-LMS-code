<?php
require_once 'db.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$student_id = $_SESSION['quiz_student_id'] ?? 0;
$course_id  = $_SESSION['quiz_course_id'] ?? 0;

if(!$student_id || !$course_id){
    die("Invalid session data.");
}

// get quiz id
$quiz = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT id, passing_score, title FROM quiz WHERE fkcourseID='$course_id'")
);
$quiz_id = $quiz['id'];
$passing_score = $quiz['passing_score'];

// total correct score
$score = 0;
$res = mysqli_query($conn,"
    SELECT is_correct FROM submit_answer
    WHERE student_id='$student_id' AND quiz_id='$quiz_id'
");

while($r = mysqli_fetch_assoc($res)){
    if($r['is_correct'] == 1){
        $score += 10; // per question marks
    }
}

// total quiz points
$total_q = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM quiz_questions WHERE fkquizID='$quiz_id'")
);
$total_points = $total_q['total'] * 10;

// percentage calculation
$percentage = ($total_points > 0) ? round(($score / $total_points) * 100, 2) : 0;

// pass / fail
$status = ($score >= $passing_score) ? 'pass' : 'fail';

// save quiz result (prevent duplicate)
$exists = mysqli_query($conn,"SELECT id FROM quiz_result WHERE student_id='$student_id' AND quiz_id='$quiz_id'");
if(mysqli_num_rows($exists) == 0){
    mysqli_query($conn,"INSERT INTO quiz_result (student_id, quiz_id, total_score, status)
                        VALUES ('$student_id','$quiz_id','$score','$status')");
}

// UPDATE COURSE PROGRESS
mysqli_query($conn,"UPDATE course_enrollments
    SET progress='$percentage'
    WHERE fkstudentID='$student_id' AND fkcourseID='$course_id'
");

// clear session
unset($_SESSION['take_quiz']);
unset($_SESSION['quiz_course_id']);
unset($_SESSION['quiz_student_id']);
unset($_SESSION['q_index']);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="container mt-5">

  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white text-center">
      <h2>Quiz Finished</h2>
      <h4><?= htmlspecialchars($quiz['title']) ?></h4>
    </div>

    <div class="card-body text-center">
      <h5 class="mb-3">Your Results</h5>

      <div class="row justify-content-center mb-4">
        <div class="col-md-4 mb-3">
          <div class="card text-white bg-info shadow-sm">
            <div class="card-body">
              <h5>Total Score</h5>
              <p class="display-6"><?= $score ?> / <?= $total_points ?></p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card text-white bg-warning shadow-sm">
            <div class="card-body">
              <h5>Percentage</h5>
              <p class="display-6"><?= $percentage ?>%</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card text-white <?= ($status == 'pass') ? 'bg-success' : 'bg-danger' ?> shadow-sm">
            <div class="card-body">
              <h5>Status</h5>
              <span class="badge fs-4 <?= ($status == 'pass') ? 'bg-success' : 'bg-danger' ?>">
                <?= strtoupper($status) ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress bar -->
      <div class="mb-4">
        <h6>Course Progress</h6>
        <div class="progress" style="height: 25px;">
          <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentage ?>%;" 
               aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
            <?= $percentage ?>%
          </div>
        </div>
      </div>

      <a href="http://localhost/final/student/index.php" class="btn btn-lg btn-primary mt-3">
        Back to Dashboard
      </a>
    </div>
  </div>
</div>
</main>
