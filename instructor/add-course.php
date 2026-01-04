<?php
include 'db.php';
$messages = "";

if (isset($_POST['submit'])) {

    $title      = $_POST['title'];
    $category   = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $price      = $_POST['price'];
    $duration   = $_POST['duration'];
    $description = $_POST['description'];
    $objectives  = $_POST['objectives']; // comma separated
    $scorm      = isset($_POST['scorm']) ? 1 : 0;

    // Thumbnail Upload
    $thumbnail = time() . "_" . $_FILES['thumbnail']['name'];
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], "uploads/" . $thumbnail);

    // Intro Video Upload
    $intro_video = null;
    if (!empty($_FILES['intro_video']['name'])) {
        $intro_video = time() . "_" . $_FILES['intro_video']['name'];
        move_uploaded_file($_FILES['intro_video']['tmp_name'], "uploads/" . $intro_video);
    }

    // Course Materials Upload (Multiple)
    $materials_arr = [];
    if (!empty($_FILES['materials']['name'][0])) {
        foreach ($_FILES['materials']['name'] as $key => $file) {
            $file_name = time() . "_" . $file;
            move_uploaded_file(
                $_FILES['materials']['tmp_name'][$key],
                "uploads/" . $file_name
            );
            $materials_arr[] = $file_name;
        }
    }

    $materials = implode(",", $materials_arr);

    // Insert Query
    $sql = "INSERT INTO courses
        (title, category, difficulty, price, duration_weeks, description,
         learning_objectives, thumbnail, intro_video, materials, scorm_enabled)
        VALUES
        ('$title','$category','$difficulty','$price','$duration','$description',
         '$objectives','$thumbnail','$intro_video','$materials','$scorm')";

    if (mysqli_query($conn, $sql)) {
        $messages = "<div class='alert alert-success'>Course submitted for approval</div>";
    } else {
        $messages = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
