<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password_hashed'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GBV Reporting System - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f8fc;
    }
    .navbar {
      background-color: #5a11b9ff;
    }
    .navbar .navbar-brand,
    .navbar .nav-link {
      color: #fff;
      font-weight: bold;
    }
    .navbar .nav-link:hover {
      color: orange;
    }
    .navbar-brand img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<nav class="navbar navbar-expand-lg shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="gbv_logo.jpg" alt="GBV Logo">
      GBV Support
    </a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLogin" aria-controls="navbarLogin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon bg-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarLogin">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ✅ Login Form Section -->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6 col-xl-5">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h3 class="card-title text-center mb-4 text-primary">Admin Login</h3>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form method="POST" novalidate autocomplete="off">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>

          <p class="mt-4 text-center">
            Don’t have an account? <a href="signup.php" class="text-decoration-none">Sign up</a>
          </p>
          <p class="text-center"><a href="password_reset.php" class="text-decoration-none">Forgot Password?</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Scripts -->
<script>
function togglePassword(id) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>
</body>
</html>