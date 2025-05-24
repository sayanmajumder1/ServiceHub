<?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['booking_error'] = "Invalid request method";
    header("Location: booking.php?provider_id=" . ($_POST['provider_id'] ?? ''));
    exit();
}

// Validate required fields
$required_fields = ['user_id', 'provider_id', 'service_id', 'subservice_ids'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['booking_error'] = "Missing required field: $field";
        header("Location: booking.php?provider_id=" . ($_POST['provider_id'] ?? ''));
        exit();
    }
}

// Sanitize inputs
$user_id = (int)$_POST['user_id'];
$provider_id = (int)$_POST['provider_id'];
$service_id = (int)$_POST['service_id'];
$subservice_ids = is_array($_POST['subservice_ids']) ? 
    array_map('intval', $_POST['subservice_ids']) : [];

// Calculate total amount and collect subservice details
$total_amount = 0.00;
$subservices = [];

foreach ($subservice_ids as $subservice_id) {
    $price_query = "SELECT ss.subservice_id, ss.subservice_name, spm.price 
                   FROM subservice ss
                   JOIN subservice_price_map spm ON ss.subservice_id = spm.subservice_id
                   WHERE spm.provider_id = ? AND spm.subservice_id = ?";
    $stmt = mysqli_prepare($conn, $price_query);
    mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $subservice = mysqli_fetch_assoc($result);
    
    if ($subservice) {
        $subservices[] = [
            'id' => $subservice['subservice_id'],
            'name' => $subservice['subservice_name'],
            'price' => $subservice['price']
        ];
        $total_amount += $subservice['price'];
    }
}

// Generate booking reference
$booking_no = strtoupper(uniqid('BOOK'));

// Store all booking data in session
$_SESSION['current_booking'] = [
    'user_id' => $user_id,
    'provider_id' => $provider_id,
    'service_id' => $service_id,
    'subservices' => $subservices,
    'booking_no' => $booking_no,
    'total_amount' => $total_amount,
    'created_at' => date('Y-m-d H:i:s')
];

// Redirect to payment page
header("Location: payment_for_booking.php");
exit();