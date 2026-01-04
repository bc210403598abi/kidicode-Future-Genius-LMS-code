<?php
require_once 'header.php';
require_once 'db.php';

$student_id = $userid;
$lesson_id = intval($_GET['lesson_id'] ?? 0);

// fetch lesson + course
$lesson_query = mysqli_query($conn,"
    SELECT l.*, c.title AS course_title
    FROM lessons l
    INNER JOIN courses c ON l.fkcourseID = c.id
    WHERE l.id='$lesson_id'
");

if(mysqli_num_rows($lesson_query) == 0){
    echo "<div class='alert alert-danger'>Lesson not found.</div>";
    exit;
}

$lesson = mysqli_fetch_assoc($lesson_query);

// check enrollment
$enroll_check = mysqli_query($conn,"
    SELECT id FROM course_enrollments
    WHERE fkstudentID='$student_id' AND fkcourseID='{$lesson['fkcourseID']}'
");

if(mysqli_num_rows($enroll_check) == 0){
    echo "<div class='alert alert-danger'>You are not enrolled in this course.</div>";
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3"><?= htmlspecialchars($lesson['title']) ?></h1>
        <p class="text-muted">Course: <?= htmlspecialchars($lesson['course_title']) ?></p>
    </div>

    <div class="card">
        <div class="card-body">

            <?php if($lesson['lesson_type'] == 'video'): ?>
                <video width="100%" controls>
                    <source src="../instructor/uploads/<?= htmlspecialchars($lesson['content']) ?>" type="video/mp4">
                </video>

            <?php elseif($lesson['lesson_type'] == 'pdf'): ?>
                <iframe src="../instructor/uploads/<?= htmlspecialchars($lesson['content']) ?>" 
                        width="100%" height="600"></iframe>

            <?php else: ?>
                <p><?= nl2br(htmlspecialchars($lesson['content'])) ?></p>
            <?php endif; ?>

            <hr>

            <?php if($lesson['attachments']): ?>
                <a href="../instructor/uploads/<?= $lesson['attachments'] ?>" 
                   class="btn btn-outline-primary" download>
                    <i class="bi bi-download"></i> Download Attachments
                </a>
            <?php endif; ?>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
