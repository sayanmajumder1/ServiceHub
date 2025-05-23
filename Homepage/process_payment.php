<?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_SESSION['current_booking'])) {
    header("Location: home.php");
    exit();
}

// Get payment details
$booking_id = (int)$_POST['booking_id'];
$amount = (float)$_POST['amount'];
$payment_method = $_POST['payment_method'];
$user_id = $_SESSION['user_id'];

// Verify booking belongs to user
$stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: home.php");
    exit();
}

// Set payment status and transaction ID
$payment_status = ($payment_method == 'cash') ? 'pending' : 'completed';
$transaction_id = ($payment_method == 'card') ? 'card_' . uniqid() : '';

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Check if we have multiple bookings to update
    if (isset($_SESSION['current_booking']['all_booking_ids'])) {
        $all_booking_ids = $_SESSION['current_booking']['all_booking_ids'];

        // Create placeholders for the IN clause
        $placeholders = implode(',', array_fill(0, count($all_booking_ids), '?'));
        $types = str_repeat('i', count($all_booking_ids));

        $update_sql = "UPDATE booking SET 
                        amount = ?,
                        payment_method = ?,
                        payment_status = ?,
                        transaction_id = ?,
                        booking_status = 'pending'
                       WHERE booking_id IN ($placeholders) AND user_id = ?";

        $stmt = $conn->prepare($update_sql);

        // Prepare parameters - amount, method, status, transaction_id, booking_ids, user_id
        $params = array_merge(
            [$amount, $payment_method, $payment_status, $transaction_id],
            $all_booking_ids,
            [$user_id]
        );

        // Bind parameters dynamically
        $stmt->bind_param("dsss" . $types . "i", ...$params);
    } else {
        // Single booking update
        $update_sql = "UPDATE booking SET 
                        amount = ?,
                        payment_method = ?,
                        payment_status = ?,
                        transaction_id = ?,
                        booking_status = 'pending'
                       WHERE booking_id = ? AND user_id = ?";

        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("dsssii", $amount, $payment_method, $payment_status, $transaction_id, $booking_id, $user_id);
    }

    if (!$stmt->execute()) {
        throw new Exception("Payment processing failed: " . $stmt->error);
    }

    // Commit transaction if all updates succeeded
    mysqli_commit($conn);

    // Payment successful
    unset($_SESSION['current_booking']);

    // Redirect to booking status page
    header("Location: booking_status.php?booking_id=$booking_id");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);

    // Log error (in a real application, you'd want to log this properly)
    error_log("Payment Error: " . $e->getMessage());

    // Set error message and redirect back
    $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
    header("Location: payment_for_booking.php?booking_id=$booking_id");
    exit();
}
