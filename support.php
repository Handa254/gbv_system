<?php include 'public_header.php'; ?>

<div class="container my-5">
  <h2 class="text-center text-primary fw-bold mb-4"><i class="bi bi-telephone-fill"></i> Support & Helplines</h2>
  <p class="text-center text-muted mb-4">If you or someone you know is experiencing Gender-Based Violence, reach out confidentially to the support centers below.</p>

  <!-- Support Centers Grid -->
  <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    <!-- Center 1: Nairobi Women’s Hospital - GVRC -->
    <div class="col">
      <div class="card border-primary h-100 shadow">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-hospital"></i> Nairobi Women’s Hospital – GVRC</h5>
          <p class="card-text">
            Malik Heights, Ngong’ Road, Hurlingham<br>
            <strong>Phone:</strong> +254 709 667000<br>
            <strong>Email:</strong> gvrc@nwch.co.ke
          </p>
          <a href="https://www.google.com/maps?q=Nairobi+Women%27s+Hospital+Hurlingham,+Nairobi" target="_blank" class="btn btn-outline-primary btn-sm">View on Map</a>
        </div>
      </div>
    </div>

    <!-- Center 2: Childline Kenya -->
    <div class="col">
      <div class="card border-success h-100 shadow">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-shield-lock-fill"></i> Childline Kenya</h5>
          <p class="card-text">
            Lower Kabete Road, Nairobi<br>
            <strong>Helpline:</strong> 116 / 0724 555 251<br>
            <strong>Email:</strong> 116@childlinekenya.co.ke
          </p>
          <a href="https://www.google.com/maps?q=Childline+Kenya+Lower+Kabete+Road,Nairobi" target="_blank" class="btn btn-outline-success btn-sm">View on Map</a>
        </div>
      </div>
    </div>

    <!-- Center 3: Gender Violence Recovery Centre (GVRC-NWH) -->
    <div class="col">
      <div class="card border-danger h-100 shadow">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-chat-square-dots"></i> GVRC (Nairobi Women’s Hospital)</h5>
          <p class="card-text">
            Malik Heights, Ngong’ Road, Hurlingham<br>
            <strong>Phone:</strong> 0800 720 565<br>
            <strong>Email:</strong> gvrc@nwch.co.ke
          </p>
          <a href="https://www.google.com/maps?q=Gender+Violence+Recovery+Centre+Malik+Heights+Hurlingham+Nairobi" target="_blank" class="btn btn-outline-danger btn-sm">View on Map</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Location Finder -->
  
  <div id="map-section" class="d-none">
    <h5 class="text-success text-center">Directions to Nairobi Women’s Hospital:</h5>
    <div class="ratio ratio-16x9 shadow-sm rounded mb-3">
      <iframe id="userMap" width="600" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
    </div>
    <p class="text-center">
      <a id="directionsLink" href="#" target="_blank" class="btn btn-success">Get Directions on Google Maps</a>
    </p>
  </div>
</div>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-danger shadow-sm">
        <div class="card-header bg-danger text-white">
          <h5 class="mb-0"><i class="bi bi-shield-lock-fill"></i> Report GBV Anonymously</h5>
        </div>
        <div class="card-body">
          <p class="card-text">
            If you or someone you know has experienced any form of Gender-Based Violence (GBV), you can submit an anonymous report. No personal information is required.
            Your courage in reporting helps others and creates a safer community.
          </p>
          <a href="report-anonymous.php" class="btn btn-outline-danger">
            <i class="bi bi-pencil-square"></i> Submit Anonymous Report
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Geolocation Script -->
<script>
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showMap, showError);
    } else {
      alert("Geolocation is not supported by your browser.");
    }
  }

  function showMap(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;
    const destination = encodeURIComponent("Nairobi Women's Hospital Hurlingham Nairobi");

    document.getElementById("userMap").src =
      https://www.google.com/maps/embed/v1/directions?key=YOUR_API_KEY&origin=${lat},${lon}&destination=${destination}&zoom=14;
    document.getElementById("directionsLink").href =
      https://www.google.com/maps/dir/?api=1&origin=${lat},${lon}&destination=${destination};

    document.getElementById("map-section").classList.remove("d-none");
  }

  function showError() {
    alert("Unable to retrieve your location. Please allow permission.");
  }
</script>

<?php include 'footer.php'; ?>