<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensure a user is logged in. If not, redirect to login.
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Check if the current user is an admin
 */
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Check if the current user is a case worker
 */
function isCaseWorker() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'case_worker';
}

/**
 * Check if the current user is a report viewer
 */
function isReportViewer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'report_viewer';
}
?>
