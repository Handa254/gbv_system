<?php
session_start();
require 'config.php'; // Ensure this file connects to your DB ($pdo)

$step = 'request'; // Step: request → reset_form → done
$message = '';
$error = '';
$token = $_GET['token'] ?? '';
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

// STEP 1: Request reset link
if ($submitted && isset($_POST['request_reset'])) {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $pdo->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE user_id = ?")
            ->execute([$token, $expiry, $user['user_id']]);

        // Simulated email link
        $link = "http://localhost/gbv_reporting_system/password_reset.php?token=$token";
        $message = "A password reset link has been generated:<br><a href='$link'>$link</a>";
    } else {
        $error = "No account found with that email.";
    }
}

// STEP 2: Show reset form if token is valid
if ($token && !$submitted) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $step = 'reset_form';
    } else {
        $error = "Invalid or expired token.";
    }
}

// STEP 3: Update password
if ($submitted && isset($_POST['update_password'])) {
    $token = $_POST['token'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $error = "Passwords do not match.";
        $step = 'reset_form';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, token_expiry = NULL WHERE user_id = ?")
                ->execute([$hash, $user['user_id']]);

            $message = "Password successfully updated. <a href='login.php'>Log in now</a>.";
            $step = 'done';
        } else {
            $error = "Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Reset | GBV Reporting</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-6 offset-md-3">
    <div class="card shadow-sm p-4">

      <h3 class="text-center mb-4">Password Reset</h3>

      <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <?php if ($step === 'request'): ?>
        <form method="POST">
          <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <button type="submit" name="request_reset" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <div class="text-center mt-3">
          <a href="login.php">Back to Login</a>
        </div>

      <?php elseif ($step === 'reset_form'): ?>
        <form method="POST">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
          <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button type="submit" name="update_password" class="btn btn-success w-100">Update Password</button>
        </form>

      <?php elseif ($step === 'done'): ?>
        <div class="text-center">
          <p class="mb-3">Password has been changed successfully.</p>
          <a href="login.php" class="btn btn-primary">Go to Login</a>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
</body>
</html>
