<?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required_fields = ['user_id', 'provider_id', 'service_id', 'subservice_id', 'option'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Error: Missing required field '$field'");
        }
    }

    // Sanitize inputs
    $user_id = (int)$_POST['user_id'];
    $provider_id = (int)$_POST['provider_id'];
    $service_id = (int)$_POST['service_id'];
    $subservice_id = (int)$_POST['subservice_id'];
    $amount=(int)$_POST['amount'];
    $booking_option = htmlspecialchars(trim($_POST['option']));

    // Check for existing pending booking
    $check_sql = "SELECT booking_id FROM booking 
                 WHERE user_id = ? 
                 AND provider_id = ?
                 AND subservice_id = ?
                 AND booking_status = 'pending'
                 LIMIT 1";
    
    $check_stmt = $conn->prepare($check_sql);
    if (!$check_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $check_stmt->bind_param("iii", $user_id, $provider_id, $subservice_id);
    $check_stmt->execute();
    $existing_booking = $check_stmt->get_result()->fetch_assoc();

    if ($existing_booking) {
        // Update existing booking
        $update_sql = "UPDATE booking 
                      SET booking_option = ?,
                          updated_at = NOW() 
                      WHERE booking_id = ?";
        
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        
        $update_stmt->bind_param("si", $booking_option, $existing_booking['booking_id']);
        
        if ($update_stmt->execute()) {
            $booking_id = $existing_booking['booking_id'];
        } else {
            $_SESSION['booking_error'] = "Failed to update booking: " . $conn->error;
            header("Location: booking.php?provider_id=$provider_id&subservice_id=$subservice_id");
            exit();
        }
    } else {
       // Create new booking
$booking_no = strtoupper(uniqid('BOOK'));
$created_at = date('Y-m-d H:i:s');
$booking_time = date('Y-m-d H:i:s'); // Add booking_time
$booking_status = "pending";
$payment_status = "pending";
$amount = $amount;
$payment_method = 'pending';
$transaction_id = ''; // Initialize empty transaction ID
$reason = ''; // Initialize empty reason

$insert_sql = "INSERT INTO booking (
              user_id, provider_id, service_id, subservice_id, 
              booking_status, payment_status, 
              amount, payment_method, created_at, booking_no,
              booking_time, transaction_id, reason
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insert_stmt = $conn->prepare($insert_sql);
if (!$insert_stmt) {
    die("Prepare failed: " . $conn->error);
}

$bind_result = $insert_stmt->bind_param(
    "iiiissdssssss", // Updated type string (13 parameters)
    $user_id,
    $provider_id,
    $service_id,
    $subservice_id,
    $booking_status,
    $payment_status,
    $amount,
    $payment_method,
    $created_at,
    $booking_no,
    $booking_time,
    $transaction_id,
    $reason
);
        if (!$bind_result) {
            die("Bind failed: " . $insert_stmt->error);
        }

        if ($insert_stmt->execute()) {
            $booking_id = $conn->insert_id;
        } else {
            $_SESSION['booking_error'] = "Failed to create booking: " . $conn->error;
            header("Location: booking.php?provider_id=$provider_id&subservice_id=$subservice_id");
            exit();
        }
    }

    // Store booking info in session
    $_SESSION['current_booking'] = [
        'booking_id' => $booking_id,
        'booking_no' => $booking_no ?? '',
        'subservice_id' => $subservice_id,
        'provider_id' => $provider_id,
        'amount' => $amount
    ];

    header("Location: payment_for_booking.php?booking_id=$booking_id");
    exit();

} else {
    header("Location: service.php");
    exit();
}
?>