<?php
session_start();
include 'public_header.php'; // This should include the Bootstrap navbar and scripts
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome | GBV Support Platform</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background-color: #fff;
      color: #333;
      font-family: 'Segoe UI', sans-serif;
    }

    .hero-section {
      padding: 70px 0;
    }

    .hero-img {
      width: 100%;
      max-width: 500px;
      border-radius: 12px;
    }

    .hero-text h1 {
      font-size: 2.4rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: #007bff;
    }

    .hero-text p {
      font-size: 1.1rem;
      color: #555;
    }

    .btn-custom {
      min-width: 120px;
      font-weight: 500;
    }

    .benefits {
      background-color: #fafafa;
      padding: 50px 0;
    }

    .benefit-card i {
      font-size: 2rem;
      color: #007bff;
    }

    footer {
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
      color: #888;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text -->
      <div class="col-md-6 hero-text">
        <h1>Welcome to the GBV Support & Reporting Platform</h1>
        <p>
          This platform empowers individuals and communities to speak up, find help, and take action against Gender-Based Violence in a safe and supportive environment.<br><br>
          We believe that safety is a fundamental right for everyone.<br>
          Through confidential channels and verified resources, we help survivors find their voice and justice.
        </p>
        <a href="login.php" class="btn btn-outline-primary mt-3 btn-lg">Sign In (Admin Only)</a>
      </div>
      <!-- Image -->
      <div class="col-md-6 text-center">
        <img src="gbv-awareness.png" alt="Supportive Illustration" class="hero-img">
      </div>
    </div>
  </div>
</section>

<!-- Why Use This Platform -->
<section class="benefits">
  <div class="container">
    <h3 class="text-center mb-5">Why Use This Platform?</h3>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card text-center benefit-card p-3 h-100 shadow-sm">
          <i class="fas fa-shield-alt mb-3"></i>
          <h6>Confidential & Secure</h6>
          <p class="small">Report GBV cases anonymously and securely with encryption.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card text-center benefit-card p-3 h-100 shadow-sm">
          <i class="fas fa-hand-holding-medical mb-3"></i>
          <h6>Access Support Services</h6>
          <p class="small">Connect to medical, legal and psychological professionals easily.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card text-center benefit-card p-3 h-100 shadow-sm">
          <i class="fas fa-bell mb-3"></i>
          <h6>Real-time Updates</h6>
          <p class="small">Track your case status and get updates from officials securely.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card text-center benefit-card p-3 h-100 shadow-sm">
          <i class="fas fa-users mb-3"></i>
          <h6>Community Empowerment</h6>
          <p class="small">Access GBV awareness materials, workshops, and peer support.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  &copy; <?= date('Y') ?> GBV Support Platform. All Rights Reserved.
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>