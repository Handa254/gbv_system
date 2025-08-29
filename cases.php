<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Add new case
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_case'])) {
    $survivor_id = $_POST['survivor_id'];
    $perpetrator_id = $_POST['perpetrator_id'];
    $case_type_id = $_POST['case_type_id'];
    $case_date = $_POST['case_date'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $reported_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO cases (survivor_id, perpetrator_id, case_type_id, case_date, description, location, reported_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$survivor_id, $perpetrator_id, $case_type_id, $case_date, $description, $location, $reported_by]);

    $message = "New GBV case reported successfully.";
}

// Fetch lists
$survivors = [];
$perpetrators = [];
$case_types = [];
$cases = [];

// Fetch survivors
$result = $conn->query("SELECT survivor_id, full_name FROM survivors");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $survivors[] = $row;
    }
}

// Fetch perpetrators
$result = $conn->query("SELECT perpetrator_id, full_name FROM perpetrators");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $perpetrators[] = $row;
    }
}

// Fetch case types
$result = $conn->query("SELECT case_type_id, type_name FROM case_types");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $case_types[] = $row;
    }
}

// Fetch all cases with joins
$query = "SELECT cases.*, 
                s.full_name AS survivor_name, 
                p.full_name AS perpetrator_name, 
                ct.type_name, 
                u.full_name AS reporter_name 
          FROM cases 
          LEFT JOIN survivors s ON cases.survivor_id = s.survivor_id 
          LEFT JOIN perpetrators p ON cases.perpetrator_id = p.perpetrator_id 
          LEFT JOIN case_types ct ON cases.case_type_id = ct.case_type_id 
          LEFT JOIN users u ON cases.reported_by = u.user_id 
          ORDER BY cases.created_at DESC";

$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cases[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GBV Cases Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container my-4">
    <h2 class="mb-4">GBV Cases Management</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Report New Case
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Survivor</label>
                            <select name="survivor_id" class="form-select" required>
                                <option value="">-- Select Survivor --</option>
                                <?php foreach ($survivors as $s): ?>
                                    <option value="<?= $s['survivor_id'] ?>"><?= htmlspecialchars($s['full_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Perpetrator</label>
                            <select name="perpetrator_id" class="form-select" required>
                                <option value="">-- Select Perpetrator --</option>
                                <?php foreach ($perpetrators as $p): ?>
                                    <option value="<?= $p['perpetrator_id'] ?>"><?= htmlspecialchars($p['full_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Case Type</label>
                            <select name="case_type_id" class="form-select" required>
                                <option value="">-- Select Case Type --</option>
                                <?php foreach ($case_types as $ct): ?>
                                    <option value="<?= $ct['case_type_id'] ?>"><?= htmlspecialchars($ct['type_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Case Date</label>
                            <input type="date" name="case_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>

                        <button type="submit" name="add_case" class="btn btn-primary">Submit Case</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Case List -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Reported Cases
                </div>
                <div class="card-body p-0">
                    <?php if (count($cases) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Survivor</th>
                                        <th>Perpetrator</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cases as $c): ?>
                                    <tr>
                                        <td><?= $c['case_id'] ?></td>
                                        <td><?= htmlspecialchars($c['survivor_name']) ?></td>
                                        <td><?= htmlspecialchars($c['perpetrator_name']) ?></td>
                                        <td><?= htmlspecialchars($c['type_name']) ?></td>
                                        <td><?= $c['case_date'] ?></td>
                                        <td><?= ucfirst($c['status']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="p-3">No cases reported yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="card my-4">
        <div class="card-body">
            <h5>Why Register GBV Cases?</h5>
            <p>
                Case documentation allows for timely legal, medical, and psychosocial responses for survivors. 
                It also aids in tracking trends, strengthening community safety mechanisms, and providing credible data for advocacy and policy-making.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>