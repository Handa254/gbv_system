<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GBV Reporting System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .navbar {
     background-color: #5a11b9ff;
    }
    .navbar .nav-link,
    .navbar .navbar-brand {
      color: #fff;
      font-weight: bold;
    }
    .navbar .nav-link:hover {
      color: orange;
    }
  </style>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">GBV System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon bg-light"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <?php if (!isset($_SESSION['user_id'])): ?>
          <!-- Public Navigation -->
          


        <?php else: ?>
          <!-- Authenticated Users Navigation -->
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>

          <?php if (strcasecmp($role, 'Admin') === 0): ?>
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register User</a></li>
            <li class="nav-item"><a class="nav-link" href="cases.php">Cases</a></li>
            <li class="nav-item"><a class="nav-link" href="survivors.php">Survivors</a></li>
            <li class="nav-item"><a class="nav-link" href="perpetrators.php">Perpetrators</a></li>
            <li class="nav-item"><a class="nav-link" href="followups.php">Follow-Ups</a></li>
            <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>

          <?php elseif (strcasecmp($role, 'Case Worker') === 0): ?>
            <li class="nav-item"><a class="nav-link" href="cases.php">Manage Cases</a></li>
            <li class="nav-item"><a class="nav-link" href="followups.php">Follow-Ups</a></li>

          <?php elseif (strcasecmp($role, 'Report Viewer') === 0): ?>
            <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>

        <?php endif; ?>
      </ul>

      <?php if (isset($_SESSION['full_name'])): ?>
        <span class="navbar-text text-white me-3">
          Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?> (<?= htmlspecialchars($role) ?>)
        </span>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container mt-4">