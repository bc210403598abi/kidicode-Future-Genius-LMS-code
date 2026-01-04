<?php
require_once 'header.php';
include 'db.php';
$messages = '';

// Handle Add / Update
if (isset($_POST['submit'])) {
    $course_id = $_POST['course_id'] ?? 0;
    $title      = $_POST['title'];
    $category   = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $price      = $_POST['price'];
    $duration   = $_POST['duration'];
    $description = $_POST['description'];
    $objectives  = $_POST['objectives'];
    $scorm      = isset($_POST['scorm']) ? 1 : 0;

    // Thumbnail
    $thumbnail = $_POST['existing_thumbnail'] ?? null;
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnail = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "uploads/" . $thumbnail);
    }

    // Intro Video
    $intro_video = $_POST['existing_intro'] ?? null;
    if (!empty($_FILES['intro_video']['name'])) {
        $intro_video = time() . "_" . $_FILES['intro_video']['name'];
        move_uploaded_file($_FILES['intro_video']['tmp_name'], "uploads/" . $intro_video);
    }

    // Materials
    $materials_arr = [];
    if (!empty($_FILES['materials']['name'][0])) {
        foreach ($_FILES['materials']['name'] as $key => $file) {
            $file_name = time() . "_" . $file;
            move_uploaded_file($_FILES['materials']['tmp_name'][$key], "uploads/" . $file_name);
            $materials_arr[] = $file_name;
        }
    }
    $materials = implode(",", $materials_arr);
    if (!empty($_POST['existing_materials'])) {
        $materials = trim($_POST['existing_materials'] . ',' . $materials, ',');
    }

    if ($course_id > 0) {
        // Update
        $sql = "UPDATE courses SET
                    title='$title',
                    category='$category',
                    difficulty='$difficulty',
                    price='$price',
                    duration_weeks='$duration',
                    description='$description',
                    learning_objectives='$objectives',
                    thumbnail='$thumbnail',
                    intro_video='$intro_video',
                    materials='$materials',
                    scorm_enabled='$scorm'
                WHERE id='$course_id'";
        mysqli_query($conn, $sql);
        $messages = "<div class='alert alert-success'>Course updated successfully</div>";
    } else {
        // Insert
        $sql = "INSERT INTO courses
                (fkteacherID,title, category, difficulty, price, duration_weeks, description,
                 learning_objectives, thumbnail, intro_video, materials, scorm_enabled)
                VALUES
                ('$userid','$title','$category','$difficulty','$price','$duration','$description',
                 '$objectives','$thumbnail','$intro_video','$materials','$scorm')";
        mysqli_query($conn, $sql);
        $messages = "<div class='alert alert-success'>Course submitted for approval</div>";
    }
}

// Delete
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM courses WHERE id='$del_id'");
    header("Location: courses.php");
    exit();
}

// Fetch courses
$courses = mysqli_query($conn, "SELECT * FROM courses WHERE fkteacherID='$userid'");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload New Course</h1>
        <button class="btn btn-success" onclick="location.href='index.php'">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </button>
    </div>
    <?php echo $messages; ?>
    <!-- Course Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data" id="courseForm">
                <input type="hidden" name="course_id" id="course_id">
                <input type="hidden" name="existing_thumbnail" id="existing_thumbnail">
                <input type="hidden" name="existing_intro" id="existing_intro">
                <input type="hidden" name="existing_materials" id="existing_materials">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Course Title *</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Category *</label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Select category</option>
                            <option value="programming">Programming</option>
                            <option value="web-development">Web Development</option>
                            <option value="data-science">Data Science</option>
                            <option value="mobile-dev">Mobile Development</option>
                            <option value="design">Design</option>
                            <option value="business">Business</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Difficulty *</label>
                        <select class="form-select" name="difficulty" id="difficulty" required>
                            <option value="">Select level</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Price *</label>
                        <input type="number" class="form-control" name="price" id="price" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Duration (weeks) *</label>
                        <input type="number" class="form-control" name="duration" id="duration" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description *</label>
                    <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Learning Objectives</label>
                    <div class="input-group mb-2">
                        <input type="text" id="objectiveInput" class="form-control" placeholder="Add objective">
                        <button type="button" class="btn btn-outline-primary" id="addObjectiveBtn">Add</button>
                    </div>
                    <ul class="list-group" id="objectivesList"></ul>
                    <input type="hidden" name="objectives" id="objectivesHidden">
                </div>

                <div class="mb-3">
                    <label>Thumbnail *</label>
                    <input type="file" class="form-control" name="thumbnail">
                </div>
                <div class="mb-3">
                    <label>Intro Video</label>
                    <input type="file" class="form-control" name="intro_video">
                </div>
                <div class="mb-3">
                    <label>Materials</label>
                    <input type="file" class="form-control" name="materials[]" multiple>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="scorm" id="scormCheck">
                    <label class="form-check-label" for="scormCheck">SCORM/xAPI tracking</label>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Difficulty</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Intro Video</th>
                        <th>Materials</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($courses)){
                        $materialsArr = explode(',',$row['materials']);
                    ?>
                    <tr>
                        <td><img src="uploads/<?php echo $row['thumbnail']; ?>" width="80"></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['difficulty']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td><?php echo $row['duration_weeks']; ?> wks</td>
                        <td>
                            <?php if($row['intro_video']){ ?>
                            <a href="uploads/<?php echo $row['intro_video']; ?>" target="_blank">View</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php foreach($materialsArr as $m){ ?>
                            <a href="uploads/<?php echo $m; ?>" download><?php echo $m; ?></a><br>
                            <?php } ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning editBtn" data-id="<?php echo $row['id']; ?>"
                                data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                data-category="<?php echo $row['category']; ?>"
                                data-difficulty="<?php echo $row['difficulty']; ?>"
                                data-price="<?php echo $row['price']; ?>"
                                data-duration="<?php echo $row['duration_weeks']; ?>"
                                data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                data-objectives="<?php echo htmlspecialchars($row['learning_objectives']); ?>"
                                data-thumbnail="<?php echo $row['thumbnail']; ?>"
                                data-intro="<?php echo $row['intro_video']; ?>"
                                data-materials="<?php echo $row['materials']; ?>"
                                data-scorm="<?php echo $row['scorm_enabled']; ?>">Edit</button>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
const addBtn = document.getElementById('addObjectiveBtn');
const input = document.getElementById('objectiveInput');
const hidden = document.getElementById('objectivesHidden');
const list = document.getElementById('objectivesList');

function updateObjectivesHidden() {
    const objs = Array.from(list.querySelectorAll('li')).map(li => li.textContent.replace('Remove', '').trim());
    hidden.value = objs.join(',');
}

// Add objective
addBtn.addEventListener('click', () => {
    const val = input.value.trim();
    if (val) {
        const li = document.createElement('li');
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `${val} <button type="button" class="btn btn-sm btn-danger removeBtn">Remove</button>`;
        li.querySelector('.removeBtn').addEventListener('click', () => {
            li.remove();
            updateObjectivesHidden();
        });
        list.appendChild(li);
        input.value = '';
        updateObjectivesHidden();
    }
});

// Edit button
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('course_id').value = btn.dataset.id;
        document.getElementById('title').value = btn.dataset.title;
        document.getElementById('category').value = btn.dataset.category;
        document.getElementById('difficulty').value = btn.dataset.difficulty;
        document.getElementById('price').value = btn.dataset.price;
        document.getElementById('duration').value = btn.dataset.duration;
        document.getElementById('description').value = btn.dataset.description;
        document.getElementById('objectivesHidden').value = btn.dataset.objectives;

        list.innerHTML = '';
        if (btn.dataset.objectives) {
            btn.dataset.objectives.split(',').forEach(obj => {
                const li = document.createElement('li');
                li.className =
                    "list-group-item d-flex justify-content-between align-items-center";
                li.innerHTML =
                    `${obj} <button type="button" class="btn btn-sm btn-danger removeBtn">Remove</button>`;
                li.querySelector('.removeBtn').addEventListener('click', () => {
                    li.remove();
                    updateObjectivesHidden();
                });
                list.appendChild(li);
            });
        }

        document.getElementById('existing_thumbnail').value = btn.dataset.thumbnail;
        document.getElementById('existing_intro').value = btn.dataset.intro;
        document.getElementById('existing_materials').value = btn.dataset.materials;
        document.getElementById('scormCheck').checked = btn.dataset.scorm == '1';
    });
});
</script>