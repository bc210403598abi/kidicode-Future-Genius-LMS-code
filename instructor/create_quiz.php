<?php
require_once 'header.php';
require_once 'db.php';

$teacher_id = $userid; // logged-in teacher

// Fetch courses
$courses = mysqli_query($conn, "SELECT id,title FROM courses WHERE fkteacherID='$teacher_id'");

// Handle Quiz Submission
$message = '';
if(isset($_POST['create_quiz'])){
    $course_id = intval($_POST['course_id']);
    $quiz_title = mysqli_real_escape_string($conn,$_POST['quiz_title']);
    $time_limit = intval($_POST['time_limit']);
    $total_points = intval($_POST['total_points']);
    $passing_score = intval($_POST['passing_score']);
    $instructions = mysqli_real_escape_string($conn,$_POST['instructions']);
    $num_questions = intval($_POST['num_questions']);
    $created_at = date('Y-m-d H:i:s');

    if(!$course_id){
        $message = "<div class='alert alert-danger'>Please select a course first.</div>";
    } else {
        // Insert into quiz table
        $sql_quiz = "INSERT INTO quiz (fkcourseID, fkteacherID, title, time_limit, total_points, passing_score, instructions, created_at)
                     VALUES ('$course_id','$teacher_id','$quiz_title','$time_limit','$total_points','$passing_score','$instructions','$created_at')";
        if(mysqli_query($conn,$sql_quiz)){
            $quiz_id = mysqli_insert_id($conn);

            // Insert Questions
            for($i=1;$i<=$num_questions;$i++){
                $q_text = mysqli_real_escape_string($conn,$_POST["question_$i"]);
                $points = intval($_POST["points_$i"]);

                // Insert question
                mysqli_query($conn,"INSERT INTO quiz_questions (fkquizID, question, points) VALUES ('$quiz_id','$q_text','$points')");
                $question_id = mysqli_insert_id($conn);

                // Insert options
                for($j=1;$j<=4;$j++){
                    $option_answer = mysqli_real_escape_string($conn,$_POST["q{$i}_option_$j"]);
                    $is_correct = ($_POST["q{$i}_correct"]==$j)?1:0;

                    mysqli_query($conn,"INSERT INTO option_quiz (fkquestionID, option_answer, is_correct) 
                                        VALUES ('$question_id','$option_answer','$is_correct')");
                }
            }

            $message = "<div class='alert alert-success'>Quiz created successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
        }
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h1 class="h2 mb-3">Create Quiz</h1>

    <?php if($message!='') echo $message; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Select Course *</label>
                        <select class="form-select" name="course_id" required>
                            <option value="">-- Select Course --</option>
                            <?php while($c=mysqli_fetch_assoc($courses)){ ?>
                                <option value="<?= $c['id'] ?>"><?= $c['title'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quiz Title *</label>
                        <input type="text" name="quiz_title" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Time Limit (minutes)</label>
                        <input type="number" name="time_limit" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total Points</label>
                        <input type="number" name="total_points" class="form-control" value="100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Passing Score (%)</label>
                        <input type="number" name="passing_score" class="form-control" value="70">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Number of Questions</label>
                        <input type="number" name="num_questions" id="num_questions" class="form-control" min="1" value="1">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quiz Instructions</label>
                    <textarea name="instructions" class="form-control" rows="3"></textarea>
                </div>

                <button type="button" class="btn btn-info mb-3" id="generateQuestions">Generate Questions</button>

                <div id="questionsContainer"></div>

                <button type="submit" name="create_quiz" class="btn btn-success mt-3">Create Quiz</button>
            </form>
        </div>
    </div>
</main>

<script>
document.getElementById('generateQuestions').addEventListener('click', function(){
    let num = document.getElementById('num_questions').value;
    let container = document.getElementById('questionsContainer');
    container.innerHTML = '';
    for(let i=1;i<=num;i++){
        let html = `
        <div class="card mb-3 p-3">
            <h5>Question ${i}</h5>
            <div class="mb-2">
                <label>Question *</label>
                <textarea class="form-control" name="question_${i}" required></textarea>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Option A *</label>
                    <input type="text" class="form-control" name="q${i}_option_1" required>
                </div>
                <div class="col-md-6">
                    <label>Option B *</label>
                    <input type="text" class="form-control" name="q${i}_option_2" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Option C *</label>
                    <input type="text" class="form-control" name="q${i}_option_3" required>
                </div>
                <div class="col-md-6">
                    <label>Option D *</label>
                    <input type="text" class="form-control" name="q${i}_option_4" required>
                </div>
            </div>
            <div class="mb-2">
                <label>Correct Option *</label>
                <select class="form-select" name="q${i}_correct">
                    <option value="1">Option A</option>
                    <option value="2">Option B</option>
                    <option value="3">Option C</option>
                    <option value="4">Option D</option>
                </select>
            </div>
            <div class="mb-2">
                <label>Points</label>
                <input type="number" name="points_${i}" class="form-control" value="10">
            </div>
        </div>
        `;
        container.innerHTML += html;
    }
});
</script>
