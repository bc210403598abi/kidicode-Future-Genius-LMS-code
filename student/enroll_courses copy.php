<?php 
require_once 'header.php';
require_once 'db.php';
$student_id = $userid;

// Handle Enrollment
if(isset($_POST['enroll_student'])){
    $course_id = intval($_POST['course_id']);
    $check = mysqli_query($conn,"SELECT * FROM course_enrollments 
                                 WHERE fkstudentID='$student_id' AND fkcourseID='$course_id' AND enStatus='active'");
    if(mysqli_num_rows($check) == 0){
        mysqli_query($conn,"INSERT INTO course_enrollments (fkstudentID,fkcourseID,enStatus) 
                            VALUES ('$student_id','$course_id','active')");
        $msg = "<div class='alert alert-success'>Enrolled successfully.</div>";
    } else {
        $msg = "<div class='alert alert-warning'>You are already enrolled in this course.</div>";
    }
}

// Filters & search
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$level = $_GET['level'] ?? '';

$where = "WHERE c.status='approved' ";
if($search) $where .= " AND c.title LIKE '%".mysqli_real_escape_string($conn,$search)."%' ";
if($category) $where .= " AND c.category='".mysqli_real_escape_string($conn,$category)."' ";
if($level) $where .= " AND c.difficulty='".mysqli_real_escape_string($conn,$level)."' ";

// Fetch courses
$courses = mysqli_query($conn,"SELECT c.*, u.full_name as teacher_name 
                               FROM courses c 
                               LEFT JOIN users u ON c.fkteacherID=u.id 
                               $where 
                               ORDER BY c.created_at DESC");

// Fetch categories & levels dynamically
$categories_res = mysqli_query($conn,"SELECT DISTINCT category FROM courses WHERE status='approved'");
$levels_res = mysqli_query($conn,"SELECT DISTINCT difficulty FROM courses WHERE status='approved'");
$categories = [];
$levels = [];
while($row = mysqli_fetch_assoc($categories_res)) $categories[] = $row['category'];
while($row = mysqli_fetch_assoc($levels_res)) $levels[] = $row['difficulty'];
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Browse & Enroll in Courses</h1>
        <button class="btn btn-primary" onclick="location.href='index.php'">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </button>
    </div>

    <?php if(isset($msg)) echo $msg; ?>

    <!-- Search & Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search courses..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $cat==$category?'selected':'' ?>><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">All Levels</option>
                        <?php foreach($levels as $lvl): ?>
                        <option value="<?= htmlspecialchars($lvl) ?>" <?= $lvl==$level?'selected':'' ?>><?= ucfirst($lvl) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Courses -->
    <div class="row">
        <?php while($c = mysqli_fetch_assoc($courses)):
            $enrolled = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM course_enrollments 
                                                              WHERE fkstudentID='$student_id' 
                                                              AND fkcourseID='".$c['id']."' 
                                                              AND enStatus='active'"));
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <span class="badge bg-warning float-end"><?= $c['price']>0?'Premium':'Free' ?></span>
                    <h5 class="mb-0"><?= htmlspecialchars($c['title']) ?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= htmlspecialchars($c['description']) ?></p>
                    <div class="mb-3">
                        <span class="badge bg-<?= $c['difficulty']=='beginner'?'success':($c['difficulty']=='intermediate'?'warning':'danger') ?>"><?= ucfirst($c['difficulty']) ?></span>
                        <span class="badge bg-info"><?= $c['duration_weeks'] ?> weeks</span>
                        <span class="badge bg-secondary"><?= $c['lessons_count'] ?? 0 ?> lessons</span>
                    </div>
                    <div class="mb-3">
                        <h6>Instructor: <small><?= htmlspecialchars($c['teacher_name']) ?></small></h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-success mb-0"><?= $c['price']>0?'$'.$c['price']:'FREE' ?></h5>
                        <form method="post">
                            <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                            <button type="submit" name="enroll_student" class="btn <?= $c['price']>0?'btn-primary':'btn-success' ?>" <?= $enrolled?'disabled':'' ?>>
                                <?= $enrolled?'Already Enrolled':'Enroll Now' ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</main>
