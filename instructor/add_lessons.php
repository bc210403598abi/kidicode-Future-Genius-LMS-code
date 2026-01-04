<?php
require_once 'header.php';
require_once 'db.php';

// Get all courses for dropdown
$courses = mysqli_query($conn, "SELECT id, title FROM courses WHERE status='approved' and fkteacherID='$userid'");

// Initialize
$selected_course = null;
$lesson_count = 0;
$enrolled_count = 0;
$edit_lesson = null;
$message = '';

// Handle course selection
if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    
    // Fetch selected course
    $result = mysqli_query($conn, "SELECT * FROM courses WHERE id='$course_id'");
    $selected_course = mysqli_fetch_assoc($result);

    // Count lessons
    $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM lessons WHERE fkcourseID='$course_id'");
    $lesson_count = mysqli_fetch_assoc($res)['total'];

    // Count enrolled students
    $res2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM course_enrollments WHERE fkcourseID='$course_id'");
    $enrolled_count = mysqli_fetch_assoc($res2)['total'];
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM lessons WHERE id='$delete_id'");
    header("Location: add_lessons.php?course_id=".$_GET['course_id']);
    exit;
}

// Handle Edit
if (isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM lessons WHERE id='$edit_id'");
    $edit_lesson = mysqli_fetch_assoc($res);
    if ($edit_lesson) {
        $course_id = $edit_lesson['fkcourseID'];
        $result = mysqli_query($conn, "SELECT * FROM courses WHERE id='$course_id'");
        $selected_course = mysqli_fetch_assoc($result);

        $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM lessons WHERE fkcourseID='$course_id'");
        $lesson_count = mysqli_fetch_assoc($res)['total'];
        $res2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM course_enrollments WHERE fkcourseID='$course_id'");
        $enrolled_count = mysqli_fetch_assoc($res2)['total'];
    }
}

// Handle Add/Update Lesson
if (isset($_POST['submit_lesson'])) {
    if (!$selected_course) {
        $message = "<div class='alert alert-warning'>Please select a course before adding a lesson.</div>";
    } else {
        $title = $_POST['title'];
        $duration = $_POST['duration'];
        $description = $_POST['description'];
        $type = $_POST['lesson_type'];
        $content = $_POST['content'] ?? null;
        $video = $edit_lesson['video'] ?? null;
        $attachments_arr = $edit_lesson['attachments'] ? explode(',', $edit_lesson['attachments']) : [];

        if ($type == 'video' && !empty($_FILES['video']['name'])) {
            $video = time().'_'.$_FILES['video']['name'];
            move_uploaded_file($_FILES['video']['tmp_name'], 'uploads/'.$video);
        }

        if (!empty($_FILES['attachments']['name'][0])) {
            foreach ($_FILES['attachments']['name'] as $key => $file) {
                $filename = time().'_'.$file;
                move_uploaded_file($_FILES['attachments']['tmp_name'][$key], 'uploads/'.$filename);
                $attachments_arr[] = $filename;
            }
        }
        $attachments = implode(',', $attachments_arr);

        if ($edit_lesson) {
            $sql = "UPDATE lessons SET title='$title', lesson_type='$type', duration_minutes='$duration', 
                    description='$description', video='$video', content='$content', attachments='$attachments' 
                    WHERE id=".$edit_lesson['id'];
        } else {
            $sql = "INSERT INTO lessons
                    (fkteacherID,fkcourseID, title, lesson_type, duration_minutes, description, video, content, attachments)
                    VALUES ('$userid','$course_id', '$title', '$type', '$duration', '$description', '$video', '$content', '$attachments')";
        }

        if (mysqli_query($conn, $sql)) {
            header("Location: add_lessons.php?course_id=$course_id");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
        }
    }
}

// Fetch existing lessons
$lessons = [];
if ($selected_course) {
    $res = mysqli_query($conn, "SELECT * FROM lessons WHERE fkcourseID='$course_id'");
    while ($row = mysqli_fetch_assoc($res)) {
        $lessons[] = $row;
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Lessons to Courses</h1>
        <a href="index.php" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>

    <!-- Course Selection -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select" name="course_id" onchange="this.form.submit()">
                            <option value="">-- Select a course --</option>
                            <?php while ($c = mysqli_fetch_assoc($courses)) { ?>
                                <option value="<?= $c['id'] ?>" <?php if ($selected_course && $selected_course['id']==$c['id']) echo 'selected'; ?>>
                                    <?= $c['title'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <?php
                        if ($selected_course) {
                            echo "<div class='alert alert-info'>";
                            echo "<strong>Selected:</strong> " . $selected_course['title'] . "<br>";
                            echo "<small>" . $lesson_count . " lessons • " . $enrolled_count . " students enrolled</small>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if ($message != '') echo $message; ?>

    <!-- Add/Edit Lesson Form -->
    <div class="card mb-4">
        <div class="card-header <?= $edit_lesson ? 'bg-warning' : 'bg-primary' ?> text-white">
            <?= $edit_lesson ? 'Edit Lesson' : 'Add New Lesson' ?>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label>Lesson Title *</label>
                        <input type="text" class="form-control" name="title" value="<?= $edit_lesson['title'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label>Duration (minutes) *</label>
                        <input type="number" class="form-control" name="duration" value="<?= $edit_lesson['duration_minutes'] ?? '' ?>" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="3"><?= $edit_lesson['description'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Lesson Type *</label>
                    <select class="form-select" name="lesson_type" id="lessonType">
                        <option value="video" <?= ($edit_lesson['lesson_type'] ?? '')=='video'?'selected':'' ?>>Video</option>
                        <option value="reading" <?= ($edit_lesson['lesson_type'] ?? '')=='reading'?'selected':'' ?>>Reading</option>
                        <option value="quiz" <?= ($edit_lesson['lesson_type'] ?? '')=='quiz'?'selected':'' ?>>Quiz</option>
                        <option value="assignment" <?= ($edit_lesson['lesson_type'] ?? '')=='assignment'?'selected':'' ?>>Assignment</option>
                    </select>
                </div>

                <div class="mb-3" id="videoSection" style="<?= ($edit_lesson['lesson_type'] ?? '')=='video'?'display:block':'display:block' ?>">
                    <label>Upload Video <?= $edit_lesson ? '(Leave empty to keep current)' : '*' ?></label>
                    <input type="file" class="form-control" name="video" accept="video/*">
                </div>

                <div class="mb-3" id="contentSection" style="<?= in_array(($edit_lesson['lesson_type'] ?? ''), ['reading','quiz','assignment'])?'display:block':'display:none' ?>">
                    <label>Lesson Content *</label>
                    <textarea class="form-control" name="content" rows="5"><?= $edit_lesson['content'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Attachments (Optional)</label>
                    <input type="file" class="form-control" name="attachments[]" multiple>
                </div>

                <button type="submit" name="submit_lesson" class="btn btn-success"><?= $edit_lesson ? 'Update Lesson' : 'Add Lesson' ?></button>
            </form>
        </div>
    </div>

    <!-- Existing Lessons Table -->
    <div class="card">
        <div class="card-header">Existing Lessons <?= $selected_course ? "(".$selected_course['title'].")" : "" ?></div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($selected_course && count($lessons) > 0) {
                        foreach($lessons as $idx => $lesson) {
                            echo "<tr>";
                            echo "<td>".($idx+1)."</td>";
                            echo "<td>".$lesson['title']."</td>";
                            echo "<td><span class='badge bg-primary'>".ucfirst($lesson['lesson_type'])."</span></td>";
                            echo "<td>".$lesson['duration_minutes']." min</td>";
                          echo "<td><span class='badge bg-secondary'>".ucfirst($lesson['status'] ?? 'draft')."</span></td>";

                            echo "<td>
                                    <a href='add_lessons.php?id=".$lesson['id']."' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='add_lessons.php?delete_id=".$lesson['id']."&course_id=".$course_id."' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this lesson?\")'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No lessons added yet or no course selected.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
const lessonType = document.getElementById('lessonType');
const videoSection = document.getElementById('videoSection');
const contentSection = document.getElementById('contentSection');

lessonType.addEventListener('change', function(){
    if(this.value === 'video'){
        videoSection.style.display = 'block';
        contentSection.style.display = 'none';
    } else {
        videoSection.style.display = 'none';
        contentSection.style.display = 'block';
    }
});
</script>
