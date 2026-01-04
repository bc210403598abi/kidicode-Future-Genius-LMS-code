<?php
require_once 'db.php';
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure quiz session is active
if(!isset($_SESSION['take_quiz'])){
    header("Location: http://localhost/final/student/index.php");
    exit;
}

// Collect POST data safely
$student_id = $_SESSION['quiz_student_id'];
$quiz_id = $_POST['quiz_id'] ?? 0;
$question_id = $_POST['question_id'] ?? 0;
$option_id = $_POST['option_id'] ?? 0;

// Validate input
if(!$quiz_id || !$question_id || !$option_id){
    die("Invalid data submitted.");
}

// Get is_correct from DB
$res = mysqli_query($conn,"SELECT is_correct FROM option_quiz WHERE id='$option_id'");
if(!$res || mysqli_num_rows($res) == 0){
    die("Option not found.");
}
$is_correct = (int)mysqli_fetch_assoc($res)['is_correct'];

// Save answer
$save = mysqli_query($conn,"INSERT INTO submit_answer
(student_id, quiz_id, question_id, option_id, is_correct)
VALUES
('$student_id','$quiz_id','$question_id','$option_id','$is_correct')");

if(!$save){
    die("Error saving answer: " . mysqli_error($conn));
}

// Move to next question
$_SESSION['q_index']++;

// Redirect to next question or finish
header("Location: http://localhost/final/student/take_quiz.php?course_id=".$_SESSION['quiz_course_id']);
exit;
