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

// Calculate total amount
$total_amount = 0.00;
foreach ($subservice_ids as $subservice_id) {
    $price_query = "SELECT price FROM subservice_price_map 
                   WHERE provider_id = ? AND subservice_id = ?";
    $stmt = mysqli_prepare($conn, $price_query);
    mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $price = mysqli_fetch_assoc($result)['price'] ?? 0;
    $total_amount += $price;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    $booking_no = strtoupper(uniqid('BOOK'));
    $created_at = date('Y-m-d H:i:s');
    $booking_time = $created_at;
    $booking_status = "pending";
    $payment_status = "pending";
    $payment_method = 'pending';
    $transaction_id = '';
    $reason = '';

    $booking_ids = [];

    foreach ($subservice_ids as $subservice_id) {
        $price_query = "SELECT price FROM subservice_price_map 
                       WHERE provider_id = ? AND subservice_id = ?";
        $stmt = mysqli_prepare($conn, $price_query);
        mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $subservice_price = mysqli_fetch_assoc($result)['price'] ?? 0;

        $insert_sql = "INSERT INTO booking (
                      user_id, provider_id, service_id, subservice_id,
                      booking_status, payment_status, 
                      amount, payment_method, created_at, booking_no,
                      booking_time, transaction_id, reason
                      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param(
            $stmt,
            "iiiissdssssss",
            $user_id,
            $provider_id,
            $service_id,
            $subservice_id,
            $booking_status,
            $payment_status,
            $subservice_price,
            $payment_method,
            $created_at,
            $booking_no,
            $booking_time,
            $transaction_id,
            $reason
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to create booking: " . mysqli_error($conn));
        }

        $booking_ids[] = mysqli_insert_id($conn);
    }

    // Commit transaction
    mysqli_commit($conn);

    // Store booking info in session
    $_SESSION['current_booking'] = [
        'booking_id' => $booking_ids[0], // First booking ID
        'booking_no' => $booking_no,
        'provider_id' => $provider_id,
        'amount' => $total_amount,
        'all_booking_ids' => $booking_ids // All related booking IDs
    ];

    // Redirect to payment page
    header("Location: payment_for_booking.php?booking_id=" . $booking_ids[0]);
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);

    $_SESSION['booking_error'] = "Booking failed: " . $e->getMessage();
    error_log("Booking Error: " . $e->getMessage());

    header("Location: booking.php?provider_id=$provider_id");
    exit();
}
