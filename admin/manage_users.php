<?php
require_once 'header.php';
require_once 'db.php';

// Handle Add User
$message = '';
if(isset($_POST['add_user'])){
    $name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $role = $_POST['role']; // student or instructor
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO users (full_name, email, password, user_type, status, created_at) 
            VALUES ('$name','$email','$password','$role','active','$created_at')";
    if(mysqli_query($conn,$sql)){
        $message = "<div class='alert alert-success'>User added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

// Handle Delete
if(isset($_GET['delete_id'])){
    $id = intval($_GET['delete_id']);
    mysqli_query($conn,"DELETE FROM users WHERE id='$id'");
    header("Location: manage_users.php");
    exit;
}

// Handle Update
if(isset($_POST['update_user'])){
    $id = intval($_POST['user_id']);
    $name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $role = $_POST['role'];
    $status = $_POST['status'];

    $sql = "UPDATE users SET full_name='$name', email='$email', user_type='$role', status='$status' WHERE id='$id'";
    if(mysqli_query($conn,$sql)){
        $message = "<div class='alert alert-success'>User updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

// Fetch all users
$users = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Users</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle"></i> ADD USER
        </button>
    </div>

    <?php if($message!='') echo $message; ?>

    <!-- User Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $count=0;
                while($u=mysqli_fetch_assoc($users)){
                    $count++;
                    ?>
                    <?php if($u['user_type']!='admin'){ // only show student & teacher ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><?= htmlspecialchars($u['full_name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="badge bg-<?= $u['user_type']=='student'?'success':'info' ?>"><?= ucfirst($u['user_type']) ?></span></td>
                        <td><span class="badge bg-<?= $u['status']=='active'?'success':'secondary' ?>"><?= ucfirst($u['status']) ?></span></td>
                        <td><?= date('Y-m-d', strtotime($u['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $u['id'] ?>">Edit</button>
                            <a href="?delete_id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal<?= $u['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($u['full_name']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select class="form-select" name="role" required>
                                                <option value="student" <?= $u['user_type']=='student'?'selected':'' ?>>Student</option>
                                                <option value="instructor" <?= $u['user_type']=='instructor'?'selected':'' ?>>Instructor</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="active" <?= $u['status']=='active'?'selected':'' ?>>Active</option>
                                                <option value="inactive" <?= $u['status']=='inactive'?'selected':'' ?>>Inactive</option>
                                                <option value="blocked" <?= $u['status']=='blocked'?'selected':'' ?>>Blocked</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="update_user" class="btn btn-success">Update User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
