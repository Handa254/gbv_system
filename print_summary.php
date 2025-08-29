<?php
require_once 'auth.php';
requireLogin();
require 'config.php';

if (!isReportViewer() && !isAdmin()) {
    echo "<div class='container mt-5 alert alert-danger'>Access Denied.</div>";
    exit;
}

$filter_type = $_GET['case_type'] ?? '';
$whereClause = '';
$types = '';
$params = [];

if (!empty($filter_type)) {
    $whereClause = "WHERE c.case_type_id = ?";
    $types = 'i';
    $params[] = $filter_type;
}

$sql = "SELECT c.*, 
               s.full_name AS survivor_name, s.gender AS survivor_gender, s.date_of_birth, s.address AS survivor_address, s.phone AS survivor_phone,
               TIMESTAMPDIFF(YEAR, s.date_of_birth, CURDATE()) AS survivor_age,
               p.full_name AS perpetrator_name, p.gender AS perpetrator_gender, p.relationship_to_survivor AS perpetrator_relation,
               ct.type_name AS case_type, u.full_name AS reporter_name
        FROM cases c
        LEFT JOIN survivors s ON c.survivor_id = s.survivor_id
        LEFT JOIN perpetrators p ON c.perpetrator_id = p.perpetrator_id
        LEFT JOIN case_types ct ON c.case_type_id = ct.case_type_id
        LEFT JOIN users u ON c.reported_by = u.user_id
        $whereClause
        ORDER BY c.case_date DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$cases = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>GBV Case Summary Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 15px; }
        @media print { .no-print { display: none; } }
        .section-title { font-weight: bold; color: #444; margin-top: 20px; }
    </style>
</head>
<body onload="window.print()">
<div class="container mt-4">
    <div class="text-center mb-4">
        <h3 class="text-primary">Gender-Based Violence Case Summary Report</h3>
        <small><?= date("F j, Y, g:i a") ?></small>
    </div>

    <?php if (count($cases) > 0): ?>
        <?php foreach ($cases as $index => $c): ?>
            <div class="border p-4 rounded mb-5">
                <h5 class="mb-3 text-secondary">Case #<?= $index + 1 ?> — <?= htmlspecialchars($c['case_type']) ?></h5>

                <p><strong>Date Reported:</strong> <?= htmlspecialchars($c['case_date']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($c['location']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($c['status']) ?></p>
                <p><strong>Handled By:</strong> <?= htmlspecialchars($c['reporter_name'] ?? 'Anonymous') ?></p>

                <div class="section-title">Survivor Information</div>
                <ul>
                    <li><strong>Name:</strong> <?= htmlspecialchars($c['survivor_name']) ?></li>
                    <li><strong>Gender:</strong> <?= htmlspecialchars($c['survivor_gender']) ?></li>
                    <li><strong>Age:</strong> <?= $c['survivor_age'] ?> years</li>
                    <li><strong>Address:</strong> <?= htmlspecialchars($c['survivor_address']) ?></li>
                    <li><strong>Phone:</strong> <?= htmlspecialchars($c['survivor_phone']) ?></li>
                </ul>

                <div class="section-title">Perpetrator Information</div>
                <ul>
                    <li><strong>Name:</strong> <?= htmlspecialchars($c['perpetrator_name']) ?></li>
                    <li><strong>Gender:</strong> <?= htmlspecialchars($c['perpetrator_gender']) ?></li>
                    <li><strong>Relation to Survivor:</strong> <?= htmlspecialchars($c['perpetrator_relation']) ?></li>
                </ul>

                <div class="section-title">Case Description</div>
                <p><?= nl2br(htmlspecialchars($c['description'])) ?></p>

                <div class="text-muted mt-4 small">Confidential – For authorized use only.</div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">No case data available for this filter.</div>
    <?php endif; ?>
</div>
</body>
</html>