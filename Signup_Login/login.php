<?php
session_start();
require_once "connection.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for user
    $user_stmt = $conn->prepare("SELECT user_id, email FROM users WHERE email = ? AND password = ?");
    $user_stmt->bind_param("ss", $email, $password);
    $user_stmt->execute();
    $result_user = $user_stmt->get_result();
    $user = $result_user->fetch_assoc();

    // Check for provider
    $provider_stmt = $conn->prepare("SELECT provider_id, email FROM service_providers WHERE email = ? AND password = ?");
    $provider_stmt->bind_param("ss", $email, $password);
    $provider_stmt->execute();
    $result_provider = $provider_stmt->get_result();
    $provider = $result_provider->fetch_assoc();

    if ($user) {
        $_SESSION['auth_type'] = 'login';
        $_SESSION['user_type'] = 'user';
        $_SESSION['otp'] = rand(100000, 999999);
        $_SESSION['user_data'] = $user;
        header("Location: otpVerification.php");
        exit();
    } elseif ($provider) {
        $_SESSION['auth_type'] = 'login';
        $_SESSION['user_type'] = 'provider';
        $_SESSION['otp'] = rand(100000, 999999);
        $_SESSION['user_data'] = $provider;
        header("Location: otpVerification.php");
        exit();
    } else {
        $error = "Invalid credentials.";
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