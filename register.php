<?php
require_once 'auth.php';
requireLogin();

if (!isAdmin()) {
    die('<div class="alert alert-danger">Access Denied. Only administrators can register users.</div>');
}

include 'header.php';
require 'config.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Attempt to insert into DB
        try {
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $password_hash, $role]);
            $success = "User registered successfully!";
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $error = "Email already exists.";
            } else {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Register New User</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" novalidate>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" id="full_name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">User Role</label>
                    <select name="role" class="form-select" id="role" required>
                        <option value="case_worker">Case Worker</option>
                        <option value="report_viewer">Report Viewer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register User</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>