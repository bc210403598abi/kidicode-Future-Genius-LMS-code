<?php
require_once 'header.php';
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$get_course_id = $_GET['course_id'] ?? 0;
$student_id = $userid; // your logged-in student ID

if(!$get_course_id){
    die("Invalid course ID.");
}

// set quiz session
$_SESSION['take_quiz'] = true;
$_SESSION['quiz_course_id'] = $get_course_id;
$_SESSION['quiz_student_id'] = $student_id;

// fetch quiz
$quiz_q = mysqli_query($conn,"SELECT * FROM quiz WHERE fkcourseID='$get_course_id'");
$quiz = mysqli_fetch_assoc($quiz_q);

if(!$quiz){
    die("Quiz not found.");
}

$quiz_id = $quiz['id'];

// initialize question index
if(!isset($_SESSION['q_index'])){
    $_SESSION['q_index'] = 0;
}

// fetch all question IDs
$qids = [];
$qres = mysqli_query($conn,"SELECT id FROM quiz_questions WHERE fkquizID='$quiz_id'");
while($row=mysqli_fetch_assoc($qres)){
    $qids[] = $row['id'];
}

$total_questions = count($qids);

// finish quiz if no more questions
if($_SESSION['q_index'] >= $total_questions){
    header("Location: http://localhost/final/student/finish_quiz.php");
    exit;
}

// current question
$current_qid = $qids[$_SESSION['q_index']];
$q = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM quiz_questions WHERE id='$current_qid'"));

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

<div class="card mb-3">
  <div class="card-body">
    <h3><?= htmlspecialchars($quiz['title']) ?></h3>
    <p><?= htmlspecialchars($quiz['instructions']) ?></p>
    <b>Question <?= $_SESSION['q_index'] + 1 ?> of <?= $total_questions ?></b>
  </div>
</div>

<!-- Absolute URL for form action -->
<form method="post" action="http://localhost/final/student/submit_single_answer.php">

<input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
<input type="hidden" name="question_id" value="<?= $q['id'] ?>">

<div class="card">
  <div class="card-header bg-primary text-white">
    <?= htmlspecialchars($q['question']) ?>
  </div>

  <div class="card-body">
    <?php
    $opts = mysqli_query($conn,"SELECT * FROM option_quiz WHERE fkquestionID='{$q['id']}'");
    while($op = mysqli_fetch_assoc($opts)){
    ?>
      <div class="form-check mb-2">
        <input class="form-check-input" type="radio"
               name="option_id"
               value="<?= $op['id'] ?>" required>
        <label class="form-check-label">
          <?= htmlspecialchars($op['option_answer']) ?>
        </label>
      </div>
    <?php } ?>
  </div>
</div>

<div class="mt-3 text-end">
  <button class="btn btn-success">Submit & Next</button>
</div>

</form>
</main>
