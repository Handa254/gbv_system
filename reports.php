<?php
require_once 'auth.php';
require_once 'config.php';
include 'header.php';
requireLogin();

echo '<div class="container mt-4">';

// Filter form
echo '
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="case_type" class="form-label">Case Type</label>
                <select name="case_type" id="case_type" class="form-select">
                    <option value="">All</option>';
                    $types = $conn->query("SELECT * FROM case_types");
                    while ($t = $types->fetch_assoc()) {
                        $selected = (isset($_GET['case_type']) && $_GET['case_type'] == $t['case_type_id']) ? 'selected' : '';
                        echo '<option value="' . $t['case_type_id'] . '" ' . $selected . '>' . htmlspecialchars($t['type_name']) . '</option>';
                    }
                echo '</select>
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All</option>
                    <option value="Open" ' . (isset($_GET['status']) && $_GET['status'] == 'Open' ? 'selected' : '') . '>Open</option>
                    <option value="Pending" ' . (isset($_GET['status']) && $_GET['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>
                    <option value="Resolved" ' . (isset($_GET['status']) && $_GET['status'] == 'Resolved' ? 'selected' : '') . '>Resolved</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="' . ($_GET['date'] ?? '') . '">
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-primary">Filter</button>
                <a href="reports.php" class="btn btn-secondary">Reset</a>
                <button onclick="window.print()" class="btn btn-success">Print</button>
            </div>
        </form>
    </div>
</div>';

// Build WHERE conditions
$conditions = [];
if (!empty($_GET['case_type'])) {
    $caseType = intval($_GET['case_type']);
    $conditions[] = "c.case_type_id = $caseType";
}
if (!empty($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $conditions[] = "c.status = '$status'";
}
if (!empty($_GET['date'])) {
    $date = $conn->real_escape_string($_GET['date']);
    $conditions[] = "DATE(c.case_date) = '$date'";
}
$whereSQL = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

// Query with joins
$sql = "
    SELECT 
        c.*, ct.type_name,
        u.full_name AS officer_name,
        s.full_name AS survivor_name, s.age AS survivor_age, s.phone AS survivor_phone, s.address AS survivor_address,
        p.full_name AS perpetrator_name, p.age AS perpetrator_age, p.phone AS perpetrator_phone, p.relationship_to_survivor
    FROM cases c
    LEFT JOIN case_types ct ON c.case_type_id = ct.case_type_id
    LEFT JOIN users u ON c.reported_by = u.user_id
    LEFT JOIN survivors s ON c.survivor_id = s.survivor_id
    LEFT JOIN perpetrators p ON c.perpetrator_id = p.perpetrator_id
    $whereSQL
    ORDER BY c.case_date DESC
";

$result = $conn->query($sql) or die("SQL Error: " . $conn->error);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="card mb-4 p-3" style="page-break-inside: avoid;">
            <h5 class="card-title">Case #' . htmlspecialchars($row['case_id']) . ' - ' . htmlspecialchars($row['type_name']) . '</h5>
            <p><strong>Date Reported:</strong> ' . htmlspecialchars($row['case_date']) . '</p>
            <p><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>
            <p><strong>Case Officer:</strong> ' . htmlspecialchars($row['officer_name']) . '</p>
            <p><strong>Description:</strong><br>' . nl2br(htmlspecialchars($row['description'])) . '</p>';

        if (!empty($row['survivor_name'])) {
            echo '
            <hr>
            <h6>Survivor Details</h6>
            <p><strong>Name:</strong> ' . htmlspecialchars($row['survivor_name']) . '</p>
            <p><strong>Age:</strong> ' . htmlspecialchars($row['survivor_age']) . '</p>
            <p><strong>Phone:</strong> ' . htmlspecialchars($row['survivor_phone']) . '</p>
            <p><strong>Address:</strong> ' . htmlspecialchars($row['survivor_address']) . '</p>';
        } else {
            echo '<p class="text-danger"><strong>Anonymous Report</strong></p>';
        }

        if (!empty($row['perpetrator_name'])) {
            echo '
            <hr>
            <h6>Perpetrator Details</h6>
            <p><strong>Name:</strong> ' . htmlspecialchars($row['perpetrator_name']) . '</p>
            <p><strong>Age:</strong> ' . htmlspecialchars($row['perpetrator_age']) . '</p>
            <p><strong>Phone:</strong> ' . htmlspecialchars($row['perpetrator_phone']) . '</p>
            <p><strong>Relationship to Survivor:</strong> ' . htmlspecialchars($row['relationship_to_survivor']) . '</p>';
        }

        echo '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No matching case records found.</div>';
}

echo '</div>';
include 'footer.php';
?>