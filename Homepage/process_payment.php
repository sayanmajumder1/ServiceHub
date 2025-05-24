<?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_SESSION['current_booking'])) {
    header("Location: home.php");
    exit();
}

// Get payment details
$payment_method = $_POST['payment_method'];
$booking_data = $_SESSION['current_booking'];

// Validate payment method
if (!in_array($payment_method, ['cash', 'card'])) {
    $_SESSION['payment_error'] = "Invalid payment method selected";
    header("Location: payment_for_booking.php");
    exit();
}

// Set payment status based on method
$payment_status = ($payment_method == 'cash') ? 'pending' : 'completed';
$transaction_id = ($payment_method == 'card') ? 'card_' . uniqid() : '';
$booking_status = 'pending'; // Define as variable
$reason = ''; // Define as variable

// Start transaction
mysqli_begin_transaction($conn);

try {
    $booking_ids = [];

    foreach ($booking_data['subservices'] as $subservice) {
        $insert_sql = "INSERT INTO booking (
            user_id, provider_id, service_id, subservice_id,
            booking_status, payment_status, amount, 
            payment_method, created_at, booking_no,
            booking_time, transaction_id, reason
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insert_sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }

        // Bind variables instead of literals
        $bind_result = mysqli_stmt_bind_param(
            $stmt,
            "iiiissdssssss",
            $booking_data['user_id'],
            $booking_data['provider_id'],
            $booking_data['service_id'],
            $subservice['id'],
            $booking_status, // Now a variable
            $payment_status,
            $subservice['price'],
            $payment_method,
            $booking_data['created_at'],
            $booking_data['booking_no'],
            $booking_data['created_at'],
            $transaction_id,
            $reason // Now a variable
        );

        if (!$bind_result) {
            throw new Exception("Bind failed: " . mysqli_stmt_error($stmt));
        }

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }

        $booking_ids[] = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
    }

    // Commit transaction
    mysqli_commit($conn);

    // Regenerate session ID for security
    session_regenerate_id(true);

    // Clear session data
    unset($_SESSION['current_booking']);

    // Redirect to success page with first booking ID
    header("Location: cart.php");
    exit();
} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    error_log("Payment Error: " . $e->getMessage());
    $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
    header("Location: payment_for_booking.php");
    exit();
}
