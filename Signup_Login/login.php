<?php
session_start();
require_once "connection.php";
require_once "smtp/PHPMailerAutoload.php"; // Adjust path if needed

$error = "";
$redirect_url = "";

function sendOTP($email, $name = '') {
    $_SESSION['otp'] = rand(100000, 999999); // Generate OTP

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'verify.servicehub@gmail.com'; // Your Gmail
        $mail->Password = 'elyz jwsz ebpx zrsr'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('verify.servicehub@gmail.com', 'ServiceHub');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Code';
        $mail->Body = "<p>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
                      <p>Your OTP is: <strong>" . $_SESSION['otp'] . "</strong></p>
                      <p>Use this to verify your login. This OTP is valid for 5 minutes.</p>";

        $mail->send();
    } catch (Exception $e) {
        $GLOBALS['error'] = "OTP sending failed: " . $mail->ErrorInfo;
    }
}

// Check for booking redirect
if (isset($_GET['provider_id'])) {
    $redirect_url = "booking.php?provider_id=" . (int)$_GET['provider_id'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user table
    $stmt = $conn->prepare("SELECT user_id, name, email FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type'] = 'user';

        sendOTP($user['email'], $user['name']);

        if (isset($_COOKIE['guest_selections'])) {
            $_SESSION['restore_booking'] = true;
            header("Location: otpVerification.php?redirect=payment");
        } else if (!empty($redirect_url)) {
            header("Location: otpVerification.php?redirect=" . urlencode($redirect_url));
        } else {
            header("Location: otpVerification.php");
        }
        exit();
    }

    // Check provider table
    $stmt = $conn->prepare("SELECT provider_id, provider_name, email FROM service_providers WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $provider = $result->fetch_assoc();
        $_SESSION['provider_id'] = $provider['provider_id'];
        $_SESSION['email'] = $provider['email'];
        $_SESSION['user_type'] = 'provider';

        sendOTP($provider['email'], $provider['provider_name']);
        header("Location: otpVerification.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="h-screen overflow-y-auto">
    <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
        <div>
            <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
        </div>
        <a href="./signup.php">
            <button class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">Create new account</button>
        </a>
    </nav>

    <main class="lg:flex max-h-screen w-full">
        <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
            <div class="w-[90%]">
                <img src="./images/6333204.jpg" alt="Illustration" />
            </div>
            <p class="hidden lg:flex lg:justify-center mt-3 text-center text-sm lg:text-lg w-full">
                Login to your existing account
            </p>
        </div>

        <div id="step1" class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
            <h1 class="text-3xl lg:text-5xl font-bold mb-4">Welcome back 👋🏽</h1>
            <h2 class="text-lg font-medium mb-8 lg:mb-15">Login to your account</h2>

            <!-- Display error message -->
            <?php if ($error): ?>
                <div class="text-red-500 font-semibold mb-4"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="email" name="email" id="email" placeholder="Email" required class="border px-4 py-2 rounded mb-3 w-full max-w-md" />
                <input type="password" name="password" id="password" placeholder="Password" required class="border px-4 py-2 rounded mb-3 w-full max-w-md" />

                <p class="text-xs text-gray-500 mb-6 lg:mt-15">
                    This information will be securely saved as per the
                    <span class="font-semibold">Terms of Services</span> and
                    <span class="font-semibold">Privacy Policy</span>
                </p>

                <div class="flex gap-8 justify-center mt-10">
                    <button class="bg-gray-200 px-5 py-2 rounded">Help!</button>
                    <input type="submit" class="bg-purple-500 text-white px-4 py-2 rounded w-full sm:w-auto" value="Login">
                </div>
            </form>
        </div>
    </main>
</body>

</html>