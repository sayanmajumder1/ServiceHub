                                                                                                                                                                                                                                                                        <?php
session_start();
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_SESSION['current_booking'])) {
    header("Location: service.php");
    exit();
}

$booking_id = (int)$_POST['booking_id'];
$amount = (float)$_POST['amount'];
$payment_method = $_POST['payment_method'];

// Verify booking belongs to user
$stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']); 
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: service.php");
    exit();
}
// Update booking with payment details
$payment_status = $payment_method == 'cash' ? 'pending' : 'completed';
$transaction_id = $payment_method == 'card' ? 'card_' . uniqid() : '';

$update_sql = "UPDATE booking SET 
                amount = ?,
                payment_method = ?,
                payment_status = ?,
                transaction_id = ?,
                booking_status = 'pending'
               WHERE booking_id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("dsssi", $amount, $payment_method, $payment_status, $transaction_id, $booking_id);
                                                                                                                 
if ($stmt->execute()) {
    // Payment successful
    unset($_SESSION['current_booking']);
    header("Location: booking_status.php?booking_id=$booking_id");
    exit();
} else {
    // Payment failed
    $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
    header("Location: payment.php?booking_id=$booking_id");
    exit();
}
?>