<?php
// awareness.php
session_start();
include 'public_header.php'; // Contains navbar, Bootstrap
?>

<div class="container mt-5">
  <div class="text-center mb-5">
    <h1 class="display-5 fw-bold text-primary">Gender-Based Violence (GBV) Awareness</h1>
    <p class="lead text-muted">Understand the signs, know how to prevent it, and empower your community to speak up and take action.</p>
  </div>

  <!-- Section: GBV Intro + Image side by side -->
  <div class="row align-items-center mb-5">
    <!-- Left: GBV Info -->
    <div class="col-md-6">
      <h3 class="text-primary">What is GBV?</h3>
      <p>Gender-Based Violence includes physical, sexual, emotional, or economic abuse directed at individuals based on their gender or sex.</p>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">🚫 Physical assault or forced sex</li>
        <li class="list-group-item">💬 Verbal threats, humiliation</li>
        <li class="list-group-item">💸 Financial control or exploitation</li>
        <li class="list-group-item">🧠 Emotional manipulation or isolation</li>
      </ul>
    </div>

    <!-- Right: Image -->
    <div class="col-md-6 text-center">
      <img src="banner.jpeg" alt="Supportive Illustration" class="img-fluid fixed-img">
    </div>
  </div>

  <style>
    .fixed-img {
      max-width: 100%;
      width: 300px;
      height: auto;
      border-radius: 12px;
    }
  </style>

  <!-- Section 2: Prevention Tips -->
  <div class="mb-5">
    <h3 class="text-center text-success mb-4">🔐 Prevention & Protection Tips</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col">
        <div class="card border-success h-100">
          <div class="card-body text-center">
            <i class="bi-shield-lock-fill fs-1 text-success"></i>
            <h5 class="card-title mt-3">Know Your Rights</h5>
            <p class="card-text">Understand national laws on GBV and access to justice services. Knowledge is protection.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card border-warning h-100">
          <div class="card-body text-center">
            <i class="bi-chat-square-text-fill fs-1 text-warning"></i>
            <h5 class="card-title mt-3">Speak Out</h5>
            <p class="card-text">Report abuse early. Use trusted hotlines, local help desks, or online reporting tools.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card border-info h-100">
          <div class="card-body text-center">
            <i class="bi-people-fill fs-1 text-info"></i>
            <h5 class="card-title mt-3">Build Safe Communities</h5>
            <p class="card-text">Create peer groups, youth forums, and family dialogues that discourage harmful gender norms.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">