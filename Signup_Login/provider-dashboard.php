<?php
session_start();
if (!isset($_SESSION['provider_id']) || $_SESSION['account_type'] !== 'provider') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-600">ServiceHub Provider</h1>
            <a href="logout.php" class="text-gray-600 hover:text-purple-600">Logout</a>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Welcome, <?php echo $_SESSION['email']; ?></h2>
            <p class="text-gray-600">This is your provider dashboard where you can manage your services.</p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-700">Your Services</h3>
                    <p class="mt-2">Manage your offered services</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-700">Appointments</h3>
                    <p class="mt-2">View and manage bookings</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-700">Profile</h3>
                    <p class="mt-2">Update your business information</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>