<?php
session_start();
include 'config.php';
include 'public_header.php';
?>

<!-- AOS animation library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold text-danger">Educational Articles on GBV</h1>
    <p class="lead">Explore deeply researched articles to understand Gender-Based Violence and how to respond effectively.</p>
  </div>

  <div class="row g-4">
    <!-- Article 1 -->
    <div class="col-md-6" data-aos="fade-up">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-primary">Understanding Gender-Based Violence</h5>
          <p class="card-text">
            Gender-Based Violence (GBV) is any harmful act directed at an individual based on their gender. It includes physical, sexual, emotional, economic, and digital abuse. GBV is rooted in inequality, power imbalance, and cultural beliefs that justify such acts.
          </p>
          <p class="small text-muted">Source: UN Women, WHO</p>
        </div>
      </div>
    </div>

    <!-- Article 2 -->
    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-success">Recognizing Signs of Emotional Abuse</h5>
          <p class="card-text">
            Emotional abuse can be subtle but deeply damaging. Signs include constant criticism, threats, isolation, humiliation, and gaslighting. Victims may lose confidence, become withdrawn, or experience anxiety and depression.
          </p>
          <p class="small text-muted">Source: Psychology Today, Mental Health UK</p>
        </div>
      </div>
    </div>

    <!-- Article 3 -->
    <div class="col-md-6" data-aos="fade-up">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-warning">Legal Rights of GBV Survivors in Kenya</h5>
          <p class="card-text">
            The Kenyan constitution protects all individuals against GBV. Survivors have the right to report, receive medical attention, legal representation, and psychosocial support. The Sexual Offenses Act and Protection Against Domestic Violence Act are key legal frameworks.
          </p>
          <p class="small text-muted">Source: FIDA Kenya, Kenya Law Reports</p>
        </div>
      </div>
    </div>

    <!-- Article 4 -->
    <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-danger">The Role of Communities in Ending GBV</h5>
          <p class="card-text">
            Communities play a vital role by raising awareness, challenging harmful norms, supporting survivors, and holding perpetrators accountable. Schools, religious institutions, and local leaders must promote equality and safe spaces for all.
          </p>
          <p class="small text-muted">Source: UNDP, Amnesty International</p>
        </div>
      </div>
    </div>

    <!-- Article 5 -->
    <div class="col-md-6" data-aos="fade-up">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-dark">Digital Safety and GBV in the Online Space</h5>
          <p class="card-text">
            With technology, GBV has extended online — through cyberbullying, revenge porn, doxing, and stalking. Practicing digital hygiene, strong privacy settings, and reporting mechanisms is crucial to staying safe.
          </p>
          <p class="small text-muted">Source: Equality Now, Access Now</p>
        </div>
      </div>
    </div>

    <!-- Article 6 -->
    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title text-info">Healing After Abuse: Mental Health & Recovery</h5>
          <p class="card-text">
            Recovery from GBV involves counseling, support groups, therapy, and rebuilding self-esteem. Trauma-informed care is essential. Survivors should be empowered to regain control over their lives at their own pace.
          </p>
          <p class="small text-muted">Source: WHO, BetterHelp, Talkspace</p>
        </div>
      </div>
    </div>
  </div>

  
</div>

<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    once: true
  });
</script>

<?php include 'footer.php'; ?>