<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php?error=" . urlencode("Missing or invalid report ID"));
    exit;
}

$report_id = intval($_GET['id']);

// Fetch the anonymous report that hasn't been converted yet
$stmt = $conn->prepare("SELECT * FROM anonymous_reports WHERE report_id = ? AND converted_to_case = 0");
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php?error=" . urlencode("Report not found or already converted"));
    exit;
}

$report = $result->fetch_assoc();
$incident_type = trim($report['incident_type']);

// Map incident_type from report to case_type_id
$type_stmt = $conn->prepare("SELECT case_type_id FROM case_types WHERE type_name = ?");
$type_stmt->bind_param("s", $incident_type);
$type_stmt->execute();
$type_result = $type_stmt->get_result();

if ($type_result->num_rows === 0) {
    header("Location: dashboard.php?error=" . urlencode("Invalid incident type: '$incident_type'. Please add it to 'case_types' first."));
    exit;
}

$case_type_row = $type_result->fetch_assoc();
$case_type_id = $case_type_row['case_type_id'];

// Insert new case
$insert = $conn->prepare("INSERT INTO cases (case_type_id, location, description, case_date, reported_by, status)
                          VALUES (?, ?, ?, ?, ?, ?)");

$location     = $report['location'];
$description  = $report['description'];  // full text used
$case_date    = $report['date_of_incident'];
$reported_by  = $_SESSION['user_id'];    // current admin user
$status       = 'Pending';

$insert->bind_param("isssss", $case_type_id, $location, $description, $case_date, $reported_by, $status);
$insert->execute();

// Mark the report as converted
$update = $conn->prepare("UPDATE anonymous_reports SET converted_to_case = 1 WHERE report_id = ?");
$update->bind_param("i", $report_id);
$update->execute();

header("Location: dashboard.php?success=" . urlencode("Anonymous report converted into a case successfully."));
exit;