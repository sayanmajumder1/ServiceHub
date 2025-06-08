<?php
session_start();
require_once "connection.php";

$error = '';
$success = "";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = implode('', $_POST['otp_digits'] ?? []);

    if ($enteredOtp == $_SESSION['otp']) {
        // For login flow
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['user_type'] == 'user') {

              // Check if we need to restore a booking after login
                if (isset($_SESSION['restore_booking']) && isset($_COOKIE['guest_selections'])) {
                    unset($_SESSION['restore_booking']);
                    
                    // Get the stored selections from cookie
                    $selections = json_decode($_COOKIE['guest_selections'], true);
                    
                    // Store in session for booking_process.php
                    $_SESSION['pending_booking'] = [
                        'provider_id' => $selections['provider_id'],
                        'subservice_ids' => $selections['subservice_ids']
                    ];
                    
                    // Clear the cookie
                    setcookie('guest_selections', '', time() - 3600, '/');
                    
                    // Redirect to booking process
                    header("Location: /ServiceHub/Homepage/booking_process.php");
                    exit();
                }

                header("Location: /ServiceHub/Homepage/index.php");
                exit();
            }
        } elseif (isset($_SESSION['provider_id'])) {
            header("Location: /ServiceHub/s_pro/index.php");
            exit();
        }









        // For signup flow
        elseif (isset($_SESSION['signup_data'])) {
             $data = $_SESSION['signup_data'];
            if ($data['account_type'] == 'user') {
                $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $data['name'], $data['email'], $data['phone'], $data['password'], $data['image']);

                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $conn->insert_id;
                    $_SESSION['user_type'] = 'user';
                    // Check if new user was trying to book before signing up
                    if (isset($_COOKIE['guest_selections'])) {
                        $selections = json_decode($_COOKIE['guest_selections'], true);
                        $_SESSION['pending_booking'] = [
                            'provider_id' => $selections['provider_id'],
                            'subservice_ids' => $selections['subservice_ids']
                        ];
                        setcookie('guest_selections', '', time() - 3600, '/');
                        header("Location: /ServiceHub/Homepage/booking_process.php");
                        exit();
                    }
                    
                    header("Location: /ServiceHub/Homepage/index.php");
                    exit();
                } else {
                    $error = "User registration failed. Please try again.";
                }
            } else {
                // Provider signup
                $stmt = $conn->prepare("INSERT INTO service_providers 
                    (businessname, provider_name,address, email, phone, service_id, password,lisenceno, identityno, identityimage, approved_action) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?, 'pending')");
                $stmt->bind_param(
                    "ssssssssss",
                    $data['businessname'],
                    $data['provider_name'],
                    $data['address'],
                    $data['email'],
                    $data['phone'],
                    $data['service_id'],
                    $data['password'],
                    $data['lisenceno'],
                    $data['identityno'],
                    $data['identityimage']
                );

                if ($stmt->execute()) {
                    $_SESSION['provider_id'] = $conn->insert_id;
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['user_type'] = 'provider';
                    unset($_SESSION['signup_data'], $_SESSION['otp']);
                    header("Location: /ServiceHub/s_pro/index.php");
                    exit();
                } else {
                    $error = "Provider registration failed: " . mysqli_error($conn);
                }
            }
        }
    } else {
        $error = "Wrong OTP entered. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .otp-input {
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }
    </style>
</head>

<body class="h-screen overflow-y-auto">
    <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
        <div>
            <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
        </div>
    </nav>

    <main class="lg:flex max-h-screen w-full">
        <!-- Left Panel -->
        <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
            <div class="w-[90%]">
                <img src="./images/6333220.jpg" alt="Illustration" />
            </div>
            <p class="mt-3 text-center text-sm lg:text-lg w-full">
                Verify your profile & email via OTP
            </p>
        </div>

        <!-- OTP Verification Panel -->
        <div id="step4Otp" class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
            <p class="text-sm text-gray-500 mb-2 lg:text-base italic">Step 03/03</p>
            <h1 class="text-3xl lg:text-5xl font-bold mb-4">Verify your Email</h1>
            <p class="mb-6 text-base lg:text-lg text-gray-600">
                We've sent a 6-digit code to your email - 
                <span class="text-purple-600 font-medium"><?php echo $_SESSION['email'] ?></span>
            </p>


           

            <form method="POST" action="otpVerification.php">
                <div class="flex gap-2 justify-center">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="text" maxlength="1" name="otp_digits[]"
                            class="otp-input border w-12 h-12 text-center text-xl rounded-lg focus:outline-none"
                            required />
                    <?php endfor; ?>
                </div>

                <!-- Error message -->
                <?php if ($error): ?>
                    <div class="mt-4 text-red-600 text-sm">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <button type="submit" name="verify"
                        class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition">
                        Verify OTP
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                if (index === 0) input.focus();

                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && e.target.value === "" && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
</body>

</html>