<?php
require_once 'auth.php';
requireLogin();

if (!in_array($_SESSION['role'], ['admin', 'case_worker'])) {
    header('Location: dashboard.php');
    exit;
}

require_once 'config.php';

// Handle form submission
$submitSuccess = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_id = trim($_POST['case_id'] ?? '');
    $followup_date = trim($_POST['followup_date'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $feedback = trim($_POST['feedback'] ?? '');
    $next_date = trim($_POST['next_followup_date'] ?? '');

    if (!$case_id || !$followup_date || !$status || !$feedback) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO followups (case_id, followup_date, status, feedback, next_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $case_id, $followup_date, $status, $feedback, $next_date);

        if ($stmt->execute()) {
            $submitSuccess = true;
        } else {
            $errorMessage = "Database error: " . $stmt->error;
        }
    }
}

// Fetch all existing cases
$caseIds = [];
$result = $conn->query("SELECT case_id FROM cases ORDER BY case_id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $caseIds[] = $row['case_id'];
    }
}

// Fetch all follow-ups
$followups = [];
$result = $conn->query("SELECT case_id, followup_date, status, feedback, next_date FROM followups ORDER BY followup_date DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $followups[] = $row;
    }
}

$pageTitle = "Case Follow-Ups";
include 'header.php';
?>

<div class="container mt-5">
  <div class="row">
    <!-- Follow-Up Form -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <strong>Record New Follow-Up</strong>
        </div>
        <div class="card-body">
          <?php if ($submitSuccess): ?>
            <div class="alert alert-success">Follow-up recorded successfully.</div>
          <?php elseif (!empty($errorMessage)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label for="case_id" class="form-label">Select Case</label>
              <select name="case_id" id="case_id" class="form-select" required>
                <option value="" disabled selected>-- Choose Case ID --</option>
                <?php foreach ($caseIds as $id): ?>
                  <option value="<?= htmlspecialchars($id) ?>">Case #<?= htmlspecialchars($id) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="followup_date" class="form-label">Date of Follow-Up</label>
              <input type="date" class="form-control" name="followup_date" required>
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Current Status</label>
              <select name="status" id="status" class="form-select" required>
                <option value="" disabled selected>-- Select Status --</option>
                <option value="Ongoing Support">Ongoing Support</option>
                <option value="Resolved">Resolved</option>
                <option value="Pending Court Action">Pending Court Action</option>
                <option value="Referral Given">Referral Given</option>
                <option value="Medical Treatment Provided">Medical Treatment Provided</option>
                <option value="Under Investigation">Under Investigation</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="feedback" class="form-label">Follow-Up Notes</label>
              <textarea name="feedback" id="feedback" rows="4" class="form-control" placeholder="Enter feedback notes" required></textarea>
            </div>

            <div class="mb-3">
              <label for="next_followup_date" class="form-label">Next Follow-Up Date (optional)</label>
              <input type="date" class="form-control" name="next_followup_date">
            </div>

            <button type="submit" class="btn btn-success w-100">Submit Follow-Up</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Follow-Up History -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
          <strong>Follow-Up History</strong>
        </div>
        <div class="card-body table-responsive">
          <?php if (count($followups) > 0): ?>
            <table class="table table-bordered table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th>Case ID</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Feedback</th>
                  <th>Next Follow-Up</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($followups as $f): ?>
                  <tr>
                    <td><?= htmlspecialchars($f['case_id']) ?></td>
                    <td><?= htmlspecialchars($f['followup_date']) ?></td>
                    <td><?= htmlspecialchars($f['status']) ?></td>
                    <td><?= nl2br(htmlspecialchars($f['feedback'])) ?></td>
                    <td><?= $f['next_date'] ? htmlspecialchars($f['next_date']) : 'N/A' ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <div class="alert alert-info">No follow-up records available yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>