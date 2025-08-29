<?php
// Folder structure assumed:
// - index.php (dashboard)
// - login.php
// - logout.php
// - users.php
// - survivors.php
// - perpetrators.php
// - case_types.php
// - cases.php
// - follow_ups.php
// - db.php (database connection)
// - auth.php (auth middleware)
// - header.php / footer.php (layout)

// This file: db.php
$host = 'localhost';
$db = 'gbv_reporting_system';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
require 'auth.php';
require 'db.php';

if (!isAdmin() && !isReportViewer()) {
    die("Access denied. Only report viewers and admins can access this page.");
}
?>
