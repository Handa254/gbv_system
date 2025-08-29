<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';
include 'header.php';

$role = $_SESSION['role'];
$full_name = $_SESSION['full_name'];
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - GBV Support </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h3 class="mb-3 text-primary"><?= ucfirst($role) ?> Dashboard</h3>

  <!-- Paragraph introduction based on role -->
  <div class="mb-4">
    <?php if ($role === 'admin'): ?>
      <p class="text-muted">
        Welcome to the administrative dashboard of the Gender-Based Violence (GBV) Reporting System. As an administrator, your role is critical in ensuring all submitted reports are managed effectively. This platform allows you to view and convert anonymous reports into actionable cases, manage users, and oversee the entire system’s performance.
      </p>
      <p class="text-muted">
        Below you’ll find real-time summaries of all cases, survivors registered in the system, system users, and pending anonymous reports awaiting administrative review. Be sure to regularly convert verified anonymous reports to trackable cases for effective follow-up.
      </p>
    <?php elseif ($role === 'case_worker'): ?>
      <p class="text-muted">
        As a case worker, your primary responsibility is to manage assigned GBV cases, offer survivor support, and track follow-ups. This dashboard provides a quick overview of recent cases allocated to you and helps ensure timely intervention and documentation of progress.
      </p>
      <p class="text-muted">
        Please remain proactive in updating the case statuses, documenting survivor needs, and coordinating with other stakeholders for improved case resolution outcomes.
      </p>
    <?php elseif ($role === 'report_viewer'): ?>
      <p class="text-muted">
        This dashboard grants you access to generated reports and statistical data from the GBV Reporting System. Your role involves analyzing trends, monitoring reported incidents, and helping improve advocacy strategies and policy formation through data interpretation.
      </p>
      <p class="text-muted">
        Please navigate to the <strong>Reports</strong> section for full summaries of cases, survivors, perpetrators, and follow-up statuses. Real-time insights can be exported and shared with decision-makers and partners.
      </p>
    <?php endif; ?>
  </div>

  <!-- Summary Cards -->
  <div class="row mb-4">
    <?php
    $query = "SELECT case_id AS id FROM cases UNION ALL SELECT report_id AS id FROM anonymous_reports WHERE converted_to_case = 0";
    $result = $conn->query($query);
    $totalCases = $result ? $result->num_rows : 0;

    $anonCount = $conn->query("SELECT COUNT(*) FROM anonymous_reports WHERE converted_to_case = 0")->fetch_row()[0];
    $totalSurvivors = $conn->query("SELECT COUNT(*) FROM survivors")->fetch_row()[0];
    $totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
    ?>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm border-left-primary">
        <h6>Total Cases</h6>
        <h3><?= $totalCases ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm border-left-warning">
        <h6>Anonymous Reports</h6>
        <h3><?= $anonCount ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm border-left-success">
        <h6>Survivors</h6>
        <h3><?= $totalSurvivors ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm border-left-info">
        <h6>System Users</h6>
        <h3><?= $totalUsers ?></h3>
      </div>
    </div>
  </div>

  <!-- Alerts -->
  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
  <?php endif; ?>
  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>

  <!-- Admin View -->
  <?php if ($role == 'admin'): ?>
    <div class="card shadow-sm mb-4 p-4">
      <h5 class="mb-3 text-secondary">Pending Anonymous Reports</h5>
      <?php
      $query = "SELECT * FROM anonymous_reports ORDER BY date_of_incident DESC";
      $result = $conn->query($query);
      if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Incident Type</th>
                <th>Location</th>
                <th>Date of Incident</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $count++ ?></td>
                  <td><?= htmlspecialchars($row['incident_type']) ?></td>
                  <td><?= htmlspecialchars($row['location']) ?></td>
                  <td><?= htmlspecialchars($row['date_of_incident']) ?></td>
                  <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                  <td>
                    <?= $row['converted_to_case'] == 1
                      ? '<span class="badge bg-success">Converted</span>'
                      : '<span class="badge bg-warning text-dark">Pending</span>' ?>
                  </td>
                  <td>
                    <?php if ($row['converted_to_case'] == 0): ?>
                      <a href="convert_anonymous.php?id=<?= $row['report_id'] ?>" class="btn btn-sm btn-success">Convert</a>
                    <?php else: ?>
                      <button class="btn btn-sm btn-secondary" disabled>Converted</button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">No anonymous reports available.</div>
      <?php endif; ?>
    </div>

  <!-- Case Worker View -->
  <?php elseif ($role == 'case_worker'): ?>
    <div class="card mt-4 p-4 shadow-sm">
      <h4 class="text-secondary">Recent Cases Assigned</h4>
      <?php
      $stmt = $conn->prepare("SELECT * FROM cases WHERE reported_by = ? ORDER BY case_date DESC LIMIT 5");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows > 0): ?>
        <ul class="list-group">
          <?php while ($row = $res->fetch_assoc()): ?>
            <li class="list-group-item">
              <?= htmlspecialchars($row['location']) ?> (<?= htmlspecialchars($row['status']) ?>) - <?= $row['case_date'] ?>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p class="text-muted">No cases assigned to you yet.</p>
      <?php endif; ?>
    </div>

  <!-- Report Viewer View -->
  <?php elseif ($role == 'report_viewer'): ?>
    <div class="alert alert-info mt-4">
      You can access and view all generated reports and analytics under the <strong>Reports</strong> section in the navigation menu.
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>