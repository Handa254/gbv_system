<?php include 'public_header.php'; ?>

<div class="container py-5">
  <h2 class="text-center mb-4 text-primary fw-bold">❓ GBV Frequently Asked Questions</h2>
  <p class="text-center text-muted mb-5">Understand your rights, how to report, where to find help, and more.</p>

  <div class="accordion" id="faqAccordion">
    <!-- FAQ 1 -->
    <div class="accordion-item" data-aos="fade-up">
      <h2 class="accordion-header" id="faqOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
          What is Gender-Based Violence (GBV)?
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          GBV refers to harmful acts directed at individuals based on their gender. It includes physical, sexual, emotional, economic, and digital abuse. It disproportionately affects women and girls but can affect all genders.
        </div>
      </div>
    </div>

    <!-- FAQ 2 -->
    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
      <h2 class="accordion-header" id="faqTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
          What are the main types of GBV?
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          <strong>Types include:</strong>
          <ul>
            <li>Physical abuse (e.g., hitting, choking)</li>
            <li>Sexual abuse (e.g., rape, harassment)</li>
            <li>Emotional/psychological abuse (e.g., threats, insults)</li>
            <li>Economic abuse (e.g., controlling finances)</li>
            <li>Digital abuse (e.g., stalking online, revenge porn)</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- FAQ 3 -->
    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
      <h2 class="accordion-header" id="faqThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
          How can I report GBV?
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          You can report GBV through this system, visit the nearest police station, call national helplines, or approach local GBV support centers. Confidentiality and safety are prioritized in handling all cases.
        </div>
      </div>
    </div>

    <!-- FAQ 4 -->
    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
      <h2 class="accordion-header" id="faqFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
          Can men and boys be victims of GBV?
        </button>
      </h2>
      <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Yes. While GBV mostly affects women and girls, men and boys can also be victims. It’s important that all survivors receive support, protection, and justice, regardless of gender.
        </div>
      </div>
    </div>

    <!-- FAQ 5 -->
    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
      <h2 class="accordion-header" id="faqFive">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
          What rights do GBV survivors have?
        </button>
      </h2>
      <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Survivors have the right to safety, privacy, legal support, medical care, and psychological counseling. GBV laws in many countries protect survivors and punish perpetrators.
        </div>
      </div>
    </div>

    <!-- FAQ 6 -->
    <div class="accordion-item" data-aos="fade-up" data-aos-delay="500">
      <h2 class="accordion-header" id="faqSix">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
          Where can I get help or support?
        </button>
      </h2>
      <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Visit our <a href="support.php">Support & Helplines</a> page for a list of organizations, counselors, hospitals, and police stations that provide immediate help for GBV cases.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Optional AOS scroll animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

<?php include 'footer.php'; ?>