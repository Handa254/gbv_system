<?php  
session_start();  
require_once 'config.php';  
include 'public_header.php';  
  
$successMsg = '';  
$trackingCode = '';  
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $incident_type = trim($_POST['incident_type']);  
    $description = trim($_POST['description']);  
    $location = trim($_POST['location']);  
    $date_of_incident = $_POST['date_of_incident'];  
    $contact_info = trim($_POST['contact_info']);  
    $survivor_details = trim($_POST['survivor_details']);  
    $perpetrator_details = trim($_POST['perpetrator_details']);  
    $timestamp = date('Y-m-d H:i:s');  
  
    // Handle optional evidence upload  
    $evidence_path = '';  
    if (!empty($_FILES['evidence']['name'])) {  
        $targetDir = "uploads/evidence/";  
        if (!is_dir($targetDir)) {  
            mkdir($targetDir, 0777, true);  
        }  
  
        $filename = basename($_FILES['evidence']['name']);  
        $targetFile = $targetDir . time() . "_" . $filename;  
  
        if (move_uploaded_file($_FILES["evidence"]["tmp_name"], $targetFile)) {  
            $evidence_path = $targetFile;  
        } else {  
            echo '<div class="alert alert-danger">❌ File upload failed. Please try again.</div>';  
        }  
    }  
  
    // Insert anonymous report  
    $stmt = $conn->prepare("INSERT INTO anonymous_reports   
        (incident_type, description, location, date_of_incident, contact_info, survivor_details, perpetrator_details, evidence_file, submitted_at)  
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");  
    $stmt->bind_param("sssssssss", $incident_type, $description, $location, $date_of_incident, $contact_info, $survivor_details, $perpetrator_details, $evidence_path, $timestamp);  
  
    if ($stmt->execute()) {  
        $lastId = $stmt->insert_id;  
        $trackingCode = 'ANON-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);  
        $successMsg = "✅ Your anonymous report was submitted successfully on <strong>$timestamp</strong>.  
        Your tracking code is <strong>$trackingCode</strong>.";  
  
        // Notify Admins  
        $adminQuery = $conn->query("SELECT user_id FROM users WHERE role = 'Admin'");  
        if ($adminQuery && $adminQuery->num_rows > 0) {  
            while ($admin = $adminQuery->fetch_assoc()) {  
                $admin_id = $admin['user_id'];  
                $nTitle = "New Anonymous Report";  
                $nMessage = "A new anonymous report has been submitted. Tracking Code: $trackingCode";  
                $nType = "alert";  
  
                $notif = $conn->prepare("INSERT INTO notifications (user_id, title, message, type, created_at) VALUES (?, ?, ?, ?, NOW())");  
                $notif->bind_param("isss", $admin_id, $nTitle, $nMessage, $nType);  
                $notif->execute();  
                $notif->close();  
            }  
        }  
    } else {  
        echo '<div class="alert alert-danger">❌ Something went wrong while submitting the report.</div>';  
    }  
  
    $stmt->close();  
}  
?>  
  
<div class="container py-5">  
  <div class="row justify-content-center">  
    <div class="col-lg-8">  
      <h2 class="mb-4 text-center text-primary">  
        <i class="bi bi-shield-lock-fill me-2"></i>Submit an Anonymous Report  
      </h2>  
  
      <div class="alert alert-info">  
        <strong>🔒 Confidential:</strong> No login required. Your submission is secure and anonymous. Optional details can help but are not required.  
      </div>  
  
      <?php if (!empty($successMsg)): ?>  
        <div class="alert alert-success"><?= $successMsg ?></div>  
      <?php else: ?>  
        <form method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">  
          <div class="mb-3">  
            <label for="incident_type" class="form-label">Type of Incident</label>  
            <select name="incident_type" id="incident_type" class="form-select" required>  
              <option value="">Select type</option>  
              <option>Physical Abuse</option>  
              <option>Sexual Harassment</option>  
              <option>Emotional Abuse</option>  
              <option>Neglect</option>  
              <option>Other</option>  
            </select>  
          </div>  
  
          <div class="mb-3">  
            <label for="description" class="form-label">Description / Details</label>  
            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>  
          </div>  
  
          <div class="mb-3">  
            <label for="location" class="form-label">Location of Incident</label>  
            <input type="text" name="location" id="location" class="form-control" required>  
          </div>  
  
          <div class="mb-3">  
            <label for="date_of_incident" class="form-label">Date of Incident</label>  
            <input type="date" name="date_of_incident" id="date_of_incident" class="form-control" required>  
          </div>  
  
          <div class="mb-3">  
            <label for="evidence" class="form-label">Upload Evidence (Optional)</label>  
            <input type="file" name="evidence" id="evidence" class="form-control">  
          </div>  
  
          <div class="mb-3">  
            <label for="contact_info" class="form-label">Optional Contact Info</label>  
            <input type="text" name="contact_info" id="contact_info" class="form-control">  
          </div>  
  
          <div class="mb-3">  
            <label for="survivor_details" class="form-label">Survivor Details (Optional)</label>  
            <textarea name="survivor_details" id="survivor_details" rows="2" class="form-control" placeholder="e.g. Female, Age 16, Student at ABC School"></textarea>  
          </div>  
  
          <div class="mb-3">  
            <label for="perpetrator_details" class="form-label">Perpetrator Details (Optional)</label>  
            <textarea name="perpetrator_details" id="perpetrator_details" rows="2" class="form-control" placeholder="e.g. Male teacher at ABC School, 40s, lives near Nyeri market"></textarea>  
          </div>  
  
          <div class="text-center">  
            <button type="submit" class="btn btn-danger">  
              <i class="bi bi-send-fill me-1"></i> Submit Anonymous Report  
            </button>  
          </div>  
        </form>  
      <?php endif; ?>  
    </div>  
  </div>  
</div>  
  
<?php include 'footer.php'; ?>