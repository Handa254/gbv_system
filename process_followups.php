<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'auth.php';
requireLogin();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_id = trim($_POST['case_id'] ?? '');
    $followup_date = trim($_POST['followup_date'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $feedback = trim($_POST['feedback'] ?? '');
    $next_date = trim($_POST['next_followup_date'] ?? '');

    // Basic validation
    if (!$case_id || !$followup_date || !$status || !$feedback) {
        header("Location: followups.php?error=missing_fields");
        exit;
    }

    // Use MySQLi
    $stmt = $conn->prepare("INSERT INTO followups (case_id, followup_date, status, feedback, next_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $case_id, $followup_date, $status, $feedback, $next_date);

    if ($stmt->execute()) {
        header("Location: followups.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
        exit;
    }
}
?>