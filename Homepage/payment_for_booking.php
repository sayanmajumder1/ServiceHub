<?php
session_start();
include_once "db_connect.php";

if (!isset($_SESSION['current_booking'])) {
    header("Location: home.php");
    exit();
}

$booking = $_SESSION['current_booking'];

// Check if user needs to provide address
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT address FROM users WHERE user_id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);
$needs_address = empty($user_data['address']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | ServiceHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
        :root {
            --primary: #6e00ff;
            --primary-light: #f0e6ff;
            --text: #333;
            --text-light: #6c757d;
            --border: #e0e0e0;
            --card-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: #f8f9fa;
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }

        .payment-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-header h2 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-light);
        }

        .booking-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .booking-card h5 {
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .booking-card p {
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-options {
            margin: 1.5rem 0;
        }

        .payment-option {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-option:hover {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }

        .payment-option.selected {
            border-color: var(--primary);
            background-color: var(--primary-light);
            box-shadow: 0 0 0 1px var(--primary);
        }

        .payment-option .icon {
            font-size: 1.25rem;
            color: var(--primary);
        }

        .payment-option .content h6 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .payment-option .content small {
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .address-field {
            margin: 1.5rem 0;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .address-field h5 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid var(--border);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(110, 0, 255, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 500;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #5a00d6;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        @media (max-width: 576px) {
            .payment-container {
                padding: 1.5rem;
                margin: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="page-header">
            <h2><i class="bi bi-credit-card"></i> Complete Payment</h2>
            <p>Choose your preferred payment method</p>
        </div>

        <div class="booking-card">
            <h5><i class="bi bi-ticket"></i> Booking #<?php echo $booking['booking_no']; ?></h5>
            <p><i class="bi bi-currency-rupee"></i> Amount to pay: <strong>₹<?php echo $booking['total_amount']; ?></strong></p>
        </div>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="amount" value="<?php echo $booking['total_amount']; ?>">

            <div class="payment-options">
                <h5 class="mb-3">Payment Method</h5>

               <!-- <div class="payment-option inactive" onclick="selectPayment(this, 'card')">
                    <div class="icon"><i class="bi bi-credit-card-2-front"></i></div>
                    <div class="content">
                        <h6>Credit/Debit Card</h6>
                        <small>Pay securely with your card</small>
                    </div>
                    <input type="radio" name="payment_method" value="card" id="card" style="display: none;">
                </div> -->
                <div class="payment-option inactive" onclick="return false;" style="pointer-events: none; opacity: 0.6;">
    <div class="icon"><i class="bi bi-credit-card-2-front"></i></div>
    <div class="content">
        <h6>Credit/Debit Card</h6>
        <small>Pay securely with your card</small>
    </div>
    <input type="radio" name="payment_method" value="card" id="card" style="display: none;" disabled>
</div>

                <div class="payment-option selected" onclick="selectPayment(this, 'cash')">
                    <div class="icon"><i class="bi bi-cash"></i></div>
                    <div class="content">
                        <h6>Cash on Service</h6>
                        <small>Pay when service is completed</small>
                    </div>
                    <input type="radio" name="payment_method" value="cash" id="cash" checked style="display: none;">
                </div>

            
            </div>

            <?php if ($needs_address): ?>
            <div class="address-field">
                <h5><i class="bi bi-house-door"></i> Service Address</h5>
                <div class="mb-3">
                    <label for="address" class="form-label">Where should we provide the service?</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-lock-fill me-2"></i> Book Service
            </button>
        </form>
    </div>

    <script>
        function selectPayment(element, method) {
            // Remove selected class from all options
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Add to clicked option
            element.classList.add('selected');

            // Update radio button
            document.querySelector(`input[value="${method}"]`).checked = true;
        }
    </script>
</body>
</html>