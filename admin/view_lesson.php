<?php
require_once 'header.php';
require_once 'db.php';

// Handle Approve / Reject
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    if($_GET['action']=='approve'){
        mysqli_query($conn,"UPDATE courses SET status='approved' WHERE id='$id'");
    } elseif($_GET['action']=='reject'){
        mysqli_query($conn,"UPDATE courses SET status='rejected' WHERE id='$id'");
    }
    header("Location: view_courses.php");
    exit;
}

// Handle lesson status update
if(isset($_POST['update_lesson_status'])){
    $lesson_id = intval($_POST['lesson_id']);
    $status = $_POST['lessstatus'] === 'published' ? 'published' : 'draft';
    mysqli_query($conn,"UPDATE lessons SET lessstatus='$status' WHERE id='$lesson_id'");
    header("Location: view_courses.php");
    exit;
}

// Fetch all courses with teacher name
$courses = mysqli_query($conn,"
    SELECT c.*, u.full_name as teacher_name 
    FROM courses c 
    LEFT JOIN users u ON c.fkteacherID=u.id
    ORDER BY c.created_at DESC
");

// Count totals
$total_courses = mysqli_num_rows($courses);

// Pending / Approved counts
$pending_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM courses WHERE status='pending'"));
$approved_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM courses WHERE status='approved'"));
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Course Approval Management</h1>
        <span class="badge bg-primary"><?= $total_courses ?> Courses Total</span>
    </div>

    <!-- Courses Table -->
    <div class="card mb-4">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Instructor</th>
                        <th>Difficulty</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $count=0;
                mysqli_data_seek($courses,0); // reset pointer
                while($c=mysqli_fetch_assoc($courses)){ 
                    $count++;
                    $course_id = $c['id'];

                    // Fetch lessons for this course
                    $lessons = mysqli_query($conn,"SELECT * FROM lessons WHERE fkcourseID='$course_id' ORDER BY created_at ASC");
                    ?>
                    <tr class="<?= $c['status']=='pending'?'table-warning':'' ?>">
                        <td>#C<?= $count ?></td>
                        <td><?= htmlspecialchars($c['title']) ?></td>
                        <td><?= htmlspecialchars($c['teacher_name'] ?? 'N/A') ?></td>
                        <td><span class="badge bg-<?= $c['difficulty']=='beginner'?'success':($c['difficulty']=='intermediate'?'warning':'info') ?>"><?= ucfirst($c['difficulty']) ?></span></td>
                        <td><span class="badge bg-<?= $c['status']=='approved'?'success':($c['status']=='pending'?'warning':'danger') ?>"><?= ucfirst($c['status']) ?></span></td>
                        <td>
                            <?php if($c['status']=='pending'){ ?>
                                <a href="?action=approve&id=<?= $c['id'] ?>" class="btn btn-sm btn-success">Approve</a>
                                <a href="?action=reject&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger">Reject</a>
                            <?php } else { ?>
                                <span class="btn btn-sm btn-secondary disabled">No Actions</span>
                            <?php } ?>
                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#courseDetails<?= $course_id ?>">View</button>
                        </td>
                    </tr>

                    <!-- Collapsible Row with Lessons first -->
                    <tr class="collapse" id="courseDetails<?= $course_id ?>">
                        <td colspan="6">
                            <div class="card card-body">
                                <h5>Lessons for <?= htmlspecialchars($c['title']) ?></h5>
                                <?php if(mysqli_num_rows($lessons) > 0){ ?>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Duration (min)</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $lesson_count=0; while($l=mysqli_fetch_assoc($lessons)){ $lesson_count++; ?>
                                            <tr>
                                                <td><?= $lesson_count ?></td>
                                                <td><?= htmlspecialchars($l['title']) ?></td>
                                                <td><?= ucfirst($l['lesson_type']) ?></td>
                                                <td><?= $l['duration_minutes'] ?? '-' ?></td>
                                                <td><?= ucfirst($l['lessstatus']) ?></td>
                                                <td>
                                                    <form method="post" class="d-flex gap-1">
                                                        <input type="hidden" name="lesson_id" value="<?= $l['id'] ?>">
                                                        <select name="lessstatus" class="form-select form-select-sm">
                                                            <option value="draft" <?= $l['lessstatus']=='draft'?'selected':'' ?>>Draft</option>
                                                            <option value="published" <?= $l['lessstatus']=='published'?'selected':'' ?>>Published</option>
                                                        </select>
                                                        <button type="submit" name="update_lesson_status" class="btn btn-sm btn-primary">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>No lessons added yet.</p>
                                <?php } ?>

                                <hr>
                                <!-- Course Details after lessons -->
                                <h5>Course Details</h5>
                                <p><strong>Category:</strong> <?= htmlspecialchars($c['category']) ?></p>
                                <p><strong>Difficulty:</strong> <?= ucfirst($c['difficulty']) ?></p>
                                <p><strong>Price:</strong> $<?= $c['price'] ?></p>
                                <p><strong>Duration (weeks):</strong> <?= $c['duration_weeks'] ?></p>
                                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($c['description'])) ?></p>
                                <p><strong>Learning Objectives:</strong> <?= nl2br(htmlspecialchars($c['learning_objectives'] ?? 'N/A')) ?></p>
                                <p><strong>SCORM Enabled:</strong> <?= $c['scorm_enabled'] ? 'Yes' : 'No' ?></p>
                                <?php if($c['thumbnail']){ ?>
                                    <p><strong>Thumbnail:</strong><br><img src="../instructor/uploads/<?= htmlspecialchars($c['thumbnail']) ?>" alt="Thumbnail" style="max-width:200px"></p>
                                <?php } ?>
                                <?php if($c['intro_video']){ ?>
                                    <p><strong>Intro Video:</strong><br>
                                        <video width="320" height="240" controls>
                                            <source src="../instructor/uploads/<?= htmlspecialchars($c['intro_video']) ?>" type="video/mp4">
                                        </video>
                                    </p>
                                <?php } ?>
                                <p><strong>Materials:</strong> <?= nl2br(htmlspecialchars($c['materials'] ?? 'N/A')) ?></p>
                                <p><strong>Instructor:</strong> <?= htmlspecialchars($c['teacher_name'] ?? 'N/A') ?></p>
                                <p><strong>Created At:</strong> <?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></p>
                                <?php 
                                    $enrolled = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM course_enrollments WHERE fkcourseID='$course_id'"))['total'];
                                ?>
                                <p><strong>Enrolled Students:</strong> <?= $enrolled ?></p>

                            </div>
                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
