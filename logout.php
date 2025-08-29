<?php
session_start();
session_unset();     // Unset all session variables
session_destroy();   // Destroy the session

// Optional: Destroy session cookie for security
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the public home page
header("Location: index.php");
exit();
?>