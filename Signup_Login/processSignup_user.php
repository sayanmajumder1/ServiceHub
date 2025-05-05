<?php
session_start();
include 'connection.php';

// Validate required fields
$required = ['fullName', 'email', 'phone', 'password'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Please fill all required fields");
    }
}

// Store user data in session for OTP verification
$_SESSION['signup_data'] = [
    'name' => $_POST['fullName'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'password' => $_POST['password'],
    'account_type' => 'user'
];

// Generate OTP
$_SESSION['otp'] = rand(100000, 999999);

header("Location: otpVerification.php");
exit();
?>