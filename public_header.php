<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GBV Awareness System</title>

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ AOS (Animate on Scroll) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <!-- ✅ Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

  <!-- ✅ Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- ✅ Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }
    .navbar {
      background-color: #5a11b9ff;
    }
    .navbar .nav-link {
      color: white !important;
      font-weight: bold;
      text-transform: uppercase;
    }
    .navbar .nav-link:hover {
      color: orange !important;
    }
    .navbar-brand {
      display: flex;
      align-items: center;
      color: #fff !important;
      font-weight: bold;
      font-size: 1.1rem;
    }
    .navbar-brand img {
      width: 45px;
      height: 45px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>

<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="gbv_logo.jpg" alt="GBV Logo">
      GBV Support
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic" aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon bg-light"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarPublic">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Public pages -->
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="awareness.php">Awareness</a></li>
        <li class="nav-item"><a class="nav-link" href="articles.php">Articles</a></li>
        <li class="nav-item"><a class="nav-link" href="types-of-gbv.php">Types of GBV</a></li>
        <li class="nav-item"><a class="nav-link" href="gbv_calendar.php">GBV Calendar</a></li>
        <li class="nav-item"><a class="nav-link" href="support.php">Support</a></li>
        <li class="nav-item"><a class="nav-link" href="faq.php">FAQs</a></li>
      </ul>
    </div>
  </div>
</nav>