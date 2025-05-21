<?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required_fields = ['user_id', 'provider_id', 'service_id', 'subservice_ids'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("Error: Missing required field '$field'");
        }
    }

    // Sanitize inputs
    $user_id = (int)$_POST['user_id'];
    $provider_id = (int)$_POST['provider_id'];
    $service_id = (int)$_POST['service_id'];
    $subservice_ids = $_POST['subservice_ids'];

    // Calculate total amount (sum of selected subservices)
    $total_amount = 0.00;
    foreach ($subservice_ids as $subservice_id) {
        $subservice_id = (int)$subservice_id;
        $price_query = "SELECT price FROM subservice_price_map 
                   WHERE provider_id = ? AND subservice_id = ?";
        $stmt = mysqli_prepare($conn, $price_query);
        mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $price = mysqli_fetch_assoc($result)['price'];
        $total_amount += $price;
    }

    // Create booking record (using current datetime for booking_time)
    $booking_no = strtoupper(uniqid('BOOK'));
    $created_at = date('Y-m-d H:i:s');
    $booking_time = $created_at; // Same-day service uses current time
    $booking_status = "pending";
    $payment_status = "pending";
    $payment_method = 'pending';
    $transaction_id = '';
    $reason = '';

    // For simplicity, we'll create one booking per subservice as per your table structure
    foreach ($subservice_ids as $subservice_id) {
        $subservice_id = (int)$subservice_id;

        // Get the price for this specific subservice
        $price_query = "SELECT price FROM subservice_price_map 
                       WHERE provider_id = ? AND subservice_id = ?";
        $stmt = mysqli_prepare($conn, $price_query);
        mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $subservice_price = mysqli_fetch_assoc($result)['price'];

        $amount = $subservice_price;

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
            $amount,
            $payment_method,
            $created_at,
            $booking_no,
            $booking_time,
            $transaction_id,
            $reason
        );

        if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['booking_error'] = "Failed to create booking: " . mysqli_error($conn);
            header("Location: booking.php?provider_id=$provider_id");
            exit();
        }

        $booking_id = mysqli_insert_id($conn);
    }

    // Store the first booking ID in session for payment page
    $_SESSION['current_booking'] = [
        'booking_id' => $booking_id,
        'booking_no' => $booking_no,
        'provider_id' => $provider_id,
        'amount' => $total_amount
    ];

    header("Location: payment_for_booking.php?booking_id=$booking_id");
    exit();
} else {
    header("Location: booking.php?provider_id=$provider_id");
    exit();
}
