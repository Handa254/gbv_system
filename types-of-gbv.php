<?php
session_start();
require_once 'auth.php';
include 'public_header.php';
require 'config.php';

?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="text-danger fw-bold" data-aos="fade-down">Types of Gender-Based Violence</h1>
    <p class="lead" data-aos="fade-up">Click on each card to read real-life survivor stories and understand the impact of different forms of abuse.</p>
  </div>

  <div class="row g-4">
    <!-- Physical Abuse -->
    <div class="col-md-6" data-aos="fade-right">
      <div class="card shadow h-100" data-bs-toggle="modal" data-bs-target="#physicalModal" style="cursor:pointer;">
        <div class="card-body">
          <h4 class="text-primary"><i class="bi bi-person-fill-slash"></i> Physical Abuse</h4>
          <p>Acts that cause physical harm like hitting, slapping, or choking.</p>
        </div>
      </div>
    </div>

    <!-- Emotional Abuse -->
    <div class="col-md-6" data-aos="fade-left">
      <div class="card shadow h-100" data-bs-toggle="modal" data-bs-target="#emotionalModal" style="cursor:pointer;">
        <div class="card-body">
          <h4 class="text-success"><i class="bi bi-emoji-frown-fill"></i> Emotional/Psychological Abuse</h4>
          <p>Words or actions that damage emotional wellbeing or mental health.</p>
        </div>
      </div>
    </div>

    <!-- Sexual Abuse -->
    <div class="col-md-6" data-aos="fade-up-right">
      <div class="card shadow h-100" data-bs-toggle="modal" data-bs-target="#sexualModal" style="cursor:pointer;">
        <div class="card-body">
          <h4 class="text-warning"><i class="bi bi-gender-female"></i> Sexual Abuse</h4>
          <p>Non-consensual sexual contact, threats, or exploitation.</p>
        </div>
      </div>
    </div>

    <!-- Economic Abuse -->
    <div class="col-md-6" data-aos="fade-up-left">
      <div class="card shadow h-100" data-bs-toggle="modal" data-bs-target="#economicModal" style="cursor:pointer;">
        <div class="card-body">
          <h4 class="text-info"><i class="bi bi-cash-stack"></i> Economic Abuse</h4>
          <p>Controlling someone’s financial resources or independence.</p>
        </div>
      </div>
    </div>

    <!-- Digital Abuse -->
    <div class="col-md-6" data-aos="zoom-in">
      <div class="card shadow h-100" data-bs-toggle="modal" data-bs-target="#digitalModal" style="cursor:pointer;">
        <div class="card-body">
          <h4 class="text-dark"><i class="bi bi-phone-fill"></i> Digital/Online Abuse</h4>
          <p>Using technology to stalk, harass or intimidate someone online.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center mt-5" data-aos="fade-up">
    <a href="awareness.php" class="btn btn-outline-primary me-2">← Back to Awareness Home</a>
    <a href="support.php" class="btn btn-danger">Need Help? Visit Support Page</a>
  </div>
</div>

<!-- Modals for Real-Life Stories -->

<!-- Physical Abuse Modal -->
<div class="modal fade" id="physicalModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Physical Abuse – Survivor's Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>“I suffered bruises and broken ribs from someone I loved. I was too afraid to speak out. The day I reported, I saved my life.”</strong></p>
        <p>This form of abuse includes slapping, pushing, beating, or using objects to cause pain. If you're experiencing any of these signs, seek help immediately.</p>
      </div>
    </div>
  </div>
</div>

<!-- Emotional Abuse Modal -->
<div class="modal fade" id="emotionalModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Emotional Abuse – Survivor's Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>“He never hit me, but the constant insults and isolation made me feel worthless. I lost my confidence.”</strong></p>
        <p>Emotional abuse often goes unseen but can be deeply damaging. It involves manipulation, threats, and control that affect mental health.</p>
      </div>
    </div>
  </div>
</div>

<!-- Sexual Abuse Modal -->
<div class="modal fade" id="sexualModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Sexual Abuse – Survivor's Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>“I was forced into acts I never consented to. I lived in silence, ashamed of something that wasn’t my fault.”</strong></p>
        <p>Sexual abuse can happen in relationships or outside them. It’s a crime and should always be reported.</p>
      </div>
    </div>
  </div>
</div>

<!-- Economic Abuse Modal -->
<div class="modal fade" id="economicModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Economic Abuse – Survivor's Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>“He took my ATM card, controlled all my earnings, and forbade me from working. I had nothing of my own.”</strong></p>
        <p>Economic abuse limits a person's ability to support themselves financially, keeping them trapped in abuse.</p>
      </div>
    </div>
  </div>
</div>

<!-- Digital Abuse Modal -->
<div class="modal fade" id="digitalModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Digital Abuse – Survivor's Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>“He constantly tracked my phone, read my messages, and threatened to leak my private photos.”</strong></p>
        <p>Digital abuse invades privacy and is a growing form of GBV. Know your digital rights and report harassment.</p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>