<?php
session_start();
require_once "connection.php";

// Check if provider is logged in
if (!isset($_SESSION["provider_id"]) || $_SESSION["user_type"] !== 'provider') {
        header("Location: login.php");
        exit;
}

// Get provider details
$provider_id = $_SESSION['provider_id'];
$stmt = $conn->prepare("SELECT * FROM service_providers WHERE provider_id = ?");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$result = $stmt->get_result();
$provider = $result->fetch_assoc();

if (!$provider) {
        die("Provider not found");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Under Review | ServiceHub</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <style>
                .wave {
                        animation: wave 8s linear infinite;
                }

                @keyframes wave {
                        0% {
                                transform: rotate(0deg);
                        }

                        100% {
                                transform: rotate(360deg);
                        }
                }

                .pulse {
                        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }

                @keyframes pulse {

                        0%,
                        100% {
                                opacity: 1;
                        }

                        50% {
                                opacity: 0.5;
                        }
                }
        </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16 items-center">
                                <div class="flex-shrink-0 flex items-center">
                                        <a href="/ServiceHub/Homepage/index.php"><img class="h-20 w-auto" src="./images/logo.png" alt="ServiceHub"></a>
                                </div>
                                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                                        <a href="logout.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 transition-colors bg-purple-500 rounded-xl text-white">Logout</a>
                                </div>
                        </div>
                </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg overflow-hidden animate__animated animate__fadeIn">
                        <div class="md:flex">
                                <div class="md:w-1/3 bg-purple-600 p-8 flex flex-col items-center justify-center">
                                        <div class="relative mb-6">
                                                <svg class="w-32 h-32 text-purple-300 wave" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-white pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                </div>
                                        </div>
                                        <h3 class="text-white text-xl font-semibold text-center">Account Under Review</h3>
                                </div>

                                <div class="md:w-2/3 p-8">
                                        <div class="mb-6">
                                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Hello, <?php echo htmlspecialchars($provider['provider_name']); ?>!</h2>
                                                <p class="text-gray-600">Your provider account is currently being reviewed by our team.</p>
                                        </div>

                                        <div class="space-y-6">
                                                <div class="flex items-start">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                        </div>
                                                        <div class="ml-4">
                                                                <h3 class="text-lg font-medium text-gray-900">Verification Process</h3>
                                                                <p class="mt-1 text-gray-600">We're verifying your business details and documents. This typically takes 24-48 hours.</p>
                                                        </div>
                                                </div>

                                                <div class="flex items-start">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                                </svg>
                                                        </div>
                                                        <div class="ml-4">
                                                                <h3 class="text-lg font-medium text-gray-900">Notification</h3>
                                                                <p class="mt-1 text-gray-600">You'll receive an email notification once your account is approved.</p>
                                                        </div>
                                                </div>

                                                <div class="flex items-start">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                        </div>
                                                        <div class="ml-4">
                                                                <h3 class="text-lg font-medium text-gray-900">What's Next?</h3>
                                                                <p class="mt-1 text-gray-600">After approval, you can set up your service offerings and start receiving bookings.</p>
                                                        </div>
                                                </div>
                                        </div>

                                        <div class="mt-8 border-t border-gray-200 pt-6">
                                                <div class="flex">
                                                        <div class="flex-shrink-0">
                                                                <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                                </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                                <p class="text-sm text-gray-600">
                                                                        Need help? <a href="mailto:support@servicehub.com" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">Contact our support team</a>.
                                                                </p>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <p class="text-center text-gray-500 text-sm">
                                &copy; <?php echo date('Y'); ?> ServiceHub. All rights reserved.
                        </p>
                </div>
        </footer>
</body>

</html>