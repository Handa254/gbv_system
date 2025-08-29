<?php
include 'conn.php'; // DB connection
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $question = trim($_POST['question']);

  if (!empty($question)) {
    $stmt = $conn->prepare("INSERT INTO faq_questions (question, created_at) VALUES (?, NOW())");
    $stmt->bind_param("s", $question);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Thank you! Your question has been submitted.'); window.location='faq.php';</script>";
  } else {
    echo "<script>alert('Please enter a valid question.'); window.location='faq.php';</script>";
  }
} else {
  header("Location: faq.php");
  exit;
}
?>