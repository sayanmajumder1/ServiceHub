<?php
session_start();
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
// Redirect to login page
header("Location: /ServiceHub/Signup_Login/login.php");
exit(); // Don't forget to call exit() after header() to stop further execution
?>
