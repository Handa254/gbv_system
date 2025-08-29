<?php
session_start();
require 'config.php';
include 'auth.php';
include 'header.php';

// Only admins can access this page
if ($_SESSION['role'] !== 'admin') {
    echo "<p style='color:red;'>You do not have permission to access this page.</p>";
    include 'footer.php';
    exit();
}

// Handle new user submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Prevent duplicate email
    $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        echo "<p style='color:red;'>Email already exists. Please use a different one.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);

        echo "<p style='color:green;'>User added successfully!</p>";
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Prevent deleting own account
    if ($delete_id == $_SESSION['user_id']) {
        echo "<p style='color:red;'>You cannot delete your own account while logged in.</p>";
    } else {
        $pdo->prepare("DELETE FROM users WHERE user_id = ?")->execute([$delete_id]);
        echo "<p style='color:red;'>User deleted.</p>";
    }
}

// Fetch all users
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<h2>User Management</h2>

<h3>Add New User</h3>
<form method="POST">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="case_worker">Case Worker</option>
        <option value="report_viewer">Report Viewer</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit" name="add_user">Add User</button>
</form>

<hr>

<h3>Existing Users</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['user_id'] ?></td>
        <td><?= htmlspecialchars($user['full_name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= ucfirst($user['role']) ?></td>
        <td><?= $user['created_at'] ?></td>
        <td>
            <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                <a href="?delete=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            <?php else: ?>
                (You)
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
