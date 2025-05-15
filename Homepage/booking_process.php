<?php
session_start(); // You need to start the session to use $_SESSION
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (!isset($_POST['user_id']) || !isset($_POST['provider_id']) || !isset($_POST['service_id'])) {
        die("Error: Missing required fields");
    }

    $user_id = (int)$_POST['user_id'];
    $provider_id = (int)$_POST['provider_id'];
    $service_id = (int)$_POST['service_id'];
    
    // Set default values
    $amount = 0; // Will be updated in payment process
    $payment_method = 'pending';
    $booking_status = "pending";
    $payment_status = "pending";
    $booking_no = strtoupper(uniqid('BOOK'));
    $created_at = date('Y-m-d H:i:s');

    // Prepare SQL statement with correct parameters
    $sql = "INSERT INTO booking (user_id, service_id, provider_id, booking_status, booking_time, amount, payment_method, payment_status, created_at, booking_no) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters - note we have 10 parameters now
    $stmt->bind_param(
        "iiissdssss",  // Notice the correct type specification:
                       // i - integer, s - string, d - double
        $user_id, 
        $service_id, 
        $provider_id, 
        $booking_status, 
        $created_at, 
        $amount, 
        $payment_method, 
        $payment_status, 
        $created_at, 
        $booking_no
    );

    if ($stmt->execute()) {
        $booking_id = $conn->insert_id;
        $_SESSION['current_booking'] = [
            'booking_id' => $booking_id,
            'booking_no' => $booking_no,
            'amount' => 100 // Default amount
        ];
        header("Location: payment_for_booking.php?booking_id=$booking_id");
        exit();
    } else {
        $_SESSION['booking_error'] = "Failed to create booking. Please try again.";
        header("Location: booking.php?provider_id=$provider_id");
        exit();
    }
} else {
    // Not a POST request
    header("Location: service.php");
    exit();
}
?>