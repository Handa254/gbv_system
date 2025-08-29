<?php
$host = 'localhost';
$db   = 'gbv_reporting_system'; // ✅ Replace this with your actual database name
$user = 'root';
$pass = ''; // Or set your MySQL password here if you use one

// ✅ This includes the database name as 4th parameter
$conn = new mysqli($host, $user, $pass, 'gbv_reporting_system');

// ✅ If DB still not selected, you can also add:
$conn->select_db($db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>