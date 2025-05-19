<?php
session_start();
include_once "db_connect.php";

if (!isset($_SESSION['current_booking']) || !isset($_GET['booking_id'])) {
    header("Location: service.php");
    exit();
}
$booking_id = (int)$_GET['booking_id'];
$booking = $_SESSION['current_booking'];

// Fetch booking details to verify
$stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking_details = $result->fetch_assoc();

if (!$booking_details) {
    header("Location: service.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .payment-option {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option:hover {
            border-color: #ad67c8;
            background-color: #f9f0ff;
        }
        .payment-option.selected {
            border-color: #ad67c8;
            background-color: #f3e5f5;
        }
    </style>
</head>
<body>
    <!-- Include your navigation if needed -->
    <p>Amount:<?php echo $booking['amount'] ?></p>
    <div class="container payment-container">
        <h2 class="text-center mb-4">Complete Your Booking</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Booking #<?php echo $booking['booking_no']; ?></h5>
                <p class="card-text">Amount to pay: $<?php echo $booking['amount']; ?></p>
            </div>
        </div>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $booking['amount']; ?>">
            
            <h5 class="mb-3">Select Payment Method</h5>
            
            <div class="payment-option" onclick="selectPayment(this, 'card')">
                <input type="radio" name="payment_method" value="card" id="card" style="display: none;">
                <label for="card" style="cursor: pointer;">
                    <i class="bi bi-credit-card"></i> Credit/Debit Card
                </label>
            </div>
            
            <div class="payment-option" onclick="selectPayment(this, 'cash')">
                <input type="radio" name="payment_method" value="cash" id="cash" checked style="display: none;">
                <label for="cash" style="cursor: pointer;">
                    <i class="bi bi-cash"></i> Cash on Service
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Complete Payment</button>
        </form>
    </div>

    <script>
        function selectPayment(element, method) {
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            element.classList.add('selected');
            document.querySelector(`input[value="${method}"]`).checked = true;
        }
    </script>
</body>
</html>