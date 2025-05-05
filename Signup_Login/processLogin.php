<?php
session_start();
include 'connection.php';

if (empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['login_error'] = "Please enter both email and password";
    header("Location: login.php");
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

// Check users table first
$query = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['account_type'] = 'user';
        
        // Generate OTP
        $_SESSION['otp'] = rand(100000, 999999);
        header("Location: otpVerification.php");
        exit();
    }
}

// Check providers table if not found in users
$query = "SELECT * FROM service_providers WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $provider = mysqli_fetch_assoc($result);
    if ($password === $provider['password']) {
        $_SESSION['provider_id'] = $provider['provider_id'];
        $_SESSION['email'] = $provider['email'];
        $_SESSION['account_type'] = 'provider';
        
        // Generate OTP
        $_SESSION['otp'] = rand(100000, 999999);
        header("Location: otpVerification.php");
        exit();
    }
}

// If we get here, login failed
$_SESSION['login_error'] = "Invalid email or password";
header("Location: login.php");
exit();
?>