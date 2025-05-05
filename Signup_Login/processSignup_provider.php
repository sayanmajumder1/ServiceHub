<?php
session_start();
include 'connection.php';

// Validate required fields
$required = ['businessName', 'ownerName', 'email', 'phone', 'password', 'businessAddress', 'service'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Please fill all required fields");
    }
}

// Prepare document data
$documentData = [
    'license_number' => $_POST['licenseNumber'] ?? '',
    'id_number' => $_POST['idNumber'] ?? ''
];

// Store provider data in session for OTP verification
$_SESSION['signup_data'] = [
    'business_name' => $_POST['businessName'],
    'owner' => $_POST['ownerName'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'password' => $_POST['password'],
    'document' => json_encode($documentData),
    'category' => $_POST['service'],
    'address' => $_POST['businessAddress'],
    'account_type' => 'provider'
];

// Generate OTP
$_SESSION['otp'] = rand(100000, 999999);

header("Location: otpVerification.php");
exit();
?>