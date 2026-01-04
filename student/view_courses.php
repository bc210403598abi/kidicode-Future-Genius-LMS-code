<?php
require_once 'header.php';
require_once 'db.php';

$student_id = $userid;

// Fetch only courses the student is enrolled in
$enrolled_courses = mysqli_query($conn,"
    SELECT c.id, c.title, c.category, ce.enStatus
    FROM course_enrollments ce
    INNER JOIN courses c ON ce.fkcourseID = c.id
    WHERE ce.fkstudentID = '$student_id'
    ORDER BY ce.enrolled_at DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Enrolled Courses</h1>
        <a href="enroll_courses.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Enroll New Course
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($enrolled_courses) > 0): ?>
                    <?php while($course = mysqli_fetch_assoc($enrolled_courses)): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['title']) ?></td>
                        <td><?= htmlspecialchars($course['category']) ?></td>
                        <td>
                            <span class="badge bg-<?= $course['enStatus']=='active'?'success':'warning' ?>">
                                <?= ucfirst($course['enStatus']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="my_courses.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No enrolled courses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
