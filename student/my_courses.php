<?php
require_once 'header.php';
require_once 'db.php';

$student_id = $userid;
$course_id = intval($_GET['course_id']);

// Fetch enrolled course info
$course_query = mysqli_query($conn, "
    SELECT c.*, u.full_name as teacher_name, ce.progress, ce.enrolled_at
    FROM courses c
    INNER JOIN course_enrollments ce ON ce.fkcourseID = c.id
    LEFT JOIN users u ON c.fkteacherID = u.id
    WHERE c.id='$course_id' AND ce.fkstudentID='$student_id'
");

if(mysqli_num_rows($course_query) == 0){
    echo "<div class='alert alert-danger'>You are not enrolled in this course.</div>";
    exit;
}

$course = mysqli_fetch_assoc($course_query);

// Fetch all lessons for this course
$lessons_query = mysqli_query($conn, "
    SELECT * FROM lessons 
    WHERE fkcourseID='$course_id'
    ORDER BY id ASC
");

// get quiz id for this course
$quiz_check = mysqli_query($conn,"
    SELECT id FROM quiz WHERE fkcourseID='$course_id'
");
$quiz_data = mysqli_fetch_assoc($quiz_check);
$quiz_id = $quiz_data['id'] ?? 0;

// check if student already attempted quiz
$attempt_check = mysqli_query($conn,"
    SELECT id FROM quiz_result 
    WHERE student_id='$student_id' AND quiz_id='$quiz_id'
");
$already_attempted = mysqli_num_rows($attempt_check) > 0;
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= htmlspecialchars($course['title']) ?></h1>
        <a href="enroll_courses.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Enroll New Course
        </a>
    </div>

    <div class="card mb-4">
        <div class="row g-0">
            <!-- Course Thumbnail -->
            <div class="col-md-4">
                <?php if($course['thumbnail']): ?>
                <img src="../instructor/uploads/<?= htmlspecialchars($course['thumbnail']) ?>"
                    class="img-fluid rounded-start" alt="Course Thumbnail">
                <?php endif; ?>
                <?php if($course['intro_video']): ?>
                <video width="100%" controls class="mt-2">
                    <source src="../instructor/uploads/<?= htmlspecialchars($course['intro_video']) ?>"
                        type="video/mp4">
                </video>
                <?php endif; ?>
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                    <p><strong>Instructor:</strong> <?= htmlspecialchars($course['teacher_name'] ?? 'N/A') ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($course['category']) ?></p>
                    <p><strong>Difficulty:</strong>
                        <span
                            class="badge bg-<?= $course['difficulty']=='beginner'?'success':($course['difficulty']=='intermediate'?'warning':'info') ?>">
                            <?= ucfirst($course['difficulty']) ?>
                        </span>
                    </p>
                    <p><strong>Price:</strong> $<?= $course['price'] ?></p>
                    <p><strong>Duration:</strong> <?= $course['duration_weeks'] ?> weeks</p>
                    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                    <p><strong>Learning
                            Objectives:</strong><br><?= nl2br(htmlspecialchars($course['learning_objectives'] ?? 'N/A')) ?>
                    </p>
                    <p><strong>SCORM Enabled:</strong> <?= $course['scorm_enabled'] ? 'Yes' : 'No' ?></p>
                    <p><strong>Enrolled At:</strong> <?= $course['enrolled_at'] ?></p>
                    <p><strong>Progress:</strong> <?= $course['progress'] ?>%</p>

                    <hr>
                    <h6>Lessons</h6>
                    <div class="list-group mb-3">
                        <?php while($lesson = mysqli_fetch_assoc($lessons_query)): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong><?= htmlspecialchars($lesson['title']) ?></strong>
                                    (<?= ucfirst($lesson['lesson_type']) ?>)
                                    <br>
                                    <small><?= htmlspecialchars($lesson['description'] ?? '') ?></small>
                                    <br>
                                    <small>Duration: <?= $lesson['duration_minutes'] ?? 'N/A' ?> min | Created at:
                                        <?= $lesson['created_at'] ?></small>
                                    <br>
                                    <?php if($lesson['attachments']): ?>
                                    <small>Attachments: <a href="../instructor/uploads/<?= $lesson['attachments'] ?>"
                                            download>Download</a></small>
                                    <?php endif; ?>
                                </div>
                                <a href="lesson_view.php?lesson_id=<?= $lesson['id'] ?>" class="btn btn-success btn-sm">
                                    <i class="bi bi-play-circle"></i> Start
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <h6>Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <?php if($course['materials']): ?>
                        <a href="../instructor/uploads/<?= $course['materials'] ?>" class="btn btn-outline-primary"
                            download>
                            <i class="bi bi-download"></i> Download Materials
                        </a>
                        <?php endif; ?>
                        <?php if($quiz_id): ?>

                        <?php if($already_attempted): ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="bi bi-check-circle"></i> Quiz Attempted
                        </button>
                        <?php else: ?>
                        <a href="take_quiz.php?course_id=<?= $course['id'] ?>" class="btn btn-outline-info">
                            <i class="bi bi-clock-history"></i> Take Quiz
                        </a>
                        <?php endif; ?>

                        <?php else: ?>
                        <button class="btn btn-warning" disabled>
                            Quiz Not Available
                        </button>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>