<?php
session_start();
include_once "db_connect.php";

// Check if provider_id is passed in URL
if (!isset($_GET['provider_id']) || !is_numeric($_GET['provider_id'])) {
    header("Location: home.php");
    exit();
}

$provider_id = (int)$_GET['provider_id'];

// Fetch provider details
$query = "SELECT * FROM service_providers WHERE provider_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $provider_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$provider = mysqli_fetch_assoc($result);

if (!$provider) {
    header("Location: home.php");
    exit();
}

// Fetch available subservices for this provider with their prices
$subservices_query = "SELECT ss.subservice_id, ss.subservice_name, spm.price 
                      FROM subservice ss
                      JOIN subservice_price_map spm ON ss.subservice_id = spm.subservice_id
                      WHERE spm.provider_id = ?";
$stmt = mysqli_prepare($conn, $subservices_query);
mysqli_stmt_bind_param($stmt, "i", $provider_id);
mysqli_stmt_execute($stmt);
$subservices = mysqli_stmt_get_result($stmt);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Get user details from DB
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Handle profile image
    $image = $user['image'] ?? '';
    $displayImage = !empty($image) ? $image : 'default.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Services - <?php echo htmlspecialchars($provider['businessname']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Maintain The  Side Bar  Functionality Java Script    -->
    <script src="SideBarFunction.js"> </script>

    <!-- Bootstrap JS (for responsive behavior) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .service-checkbox:checked+label {
            border-color: #9f7aea;
            background-color: #f5f3ff;
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation (same as your other pages) -->
    <nav>
        <!-- Side Bar Section-->
        <ul class="sidebar" id="sidebar">
            <li onclick="hideSidebar()" class="navbar-profile-two d-flex  align-items-center padding-top-bottom" onclick="showSidebar()" style="height: 100px;">
                <a href="#"><i class="fa-solid fa-times"></i></a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="d-inline-block position-relative">
                        <img
                            src="assets/images/<?php echo $displayImage; ?>"
                            alt="User profile"
                            class="img-fluid rounded-circle shadow profile-img-animate"
                            style="width: 80px; height: 80px; object-fit: cover;" />

                    </a>
                <?php else: ?>
                    <a href="/ServiceHub/Signup_Login/login.php" class="fw-bold" style="text-decoration: none;color: #010913FF;">
                        Signup or Login
                    </a>
                <?php endif; ?>
            </li>


            <li>
                <a href="#"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>Bookings</a>
            </li>
            <li>
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
            </li>
            <li>
                <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>

            </li>


        </ul>
        <!-- Nav  Bar Section-->
        <ul>
            <li class="logo">
                <img loading="lazy " src="assets/images/logo.png" alt="Service Hub Icon ">
                <!-- <span>Service Hub</span>-->
            </li>

            <li class="hideOnMobile nav-link"><a href="home.php" class="active">Home</a></li>
            <li class="hideOnMobile nav-link"><a href="cart.php">Bookings</a></li>
            <li class="hideOnMobile nav-link"><a href="about.php">About</a></li>
            <li class="hideOnMobile nav-link"><a href="contact.php">Contact</a></li>

            <li class="navbar-profile" onclick="hideSidebar()">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">
                        <img
                            src="assets/images/<?php echo $displayImage; ?>"
                            alt="User profile"
                            class="img-fluid rounded-circle shadow"
                            style="width: 50px; height: 50px; object-fit: cover;" />
                    </a>
                <?php else: ?>
                    <a href="/ServiceHub/Signup_Login/login.php" class=" fw-bold" style="text-decoration: none;color: #010913FF;">
                        Signup or Login
                    </a>
                <?php endif; ?>
            </li>

            <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Provider Header -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 mt-20">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:w-48 rounded-full ml-5"
                        src="../s_pro/uploads2/<?php echo htmlspecialchars($provider['image'] ?? 'default-service.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($provider['businessname']); ?>">
                </div>
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-purple-600 font-semibold">
                        <?php echo htmlspecialchars($provider['service_name'] ?? 'Service Provider'); ?>
                    </div>
                    <h1 class="block mt-1 text-2xl font-medium text-gray-900">
                        <?php echo htmlspecialchars($provider['businessname']); ?>
                    </h1>
                    <div class="mt-2 flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span><?php echo htmlspecialchars($provider['address']); ?></span>
                    </div>
                    <div class="mt-2 flex items-center text-gray-600">
                        <i class="fas fa-star text-yellow-400 mr-2"></i>
                        <span>4.8 (532 reviews)</span>
                    </div>
                    <div class="mt-4 bg-purple-50 p-3 rounded-lg">
                        <div class="flex items-center text-purple-600">
                            <i class="fas fa-bolt mr-2 animate-bounce"></i>
                            <span class="font-medium">Same-day service available!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <form action="booking_process.php" method="POST" class="bg-white rounded-xl shadow-md p-6">
            <input type="hidden" name="provider_id" value="<?php echo $provider['provider_id']; ?>">
            <input type="hidden" name="service_id" value="<?php echo $provider['service_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Services</h2>

            <!-- Services List -->
            <div class="space-y-3 mb-6">
                <?php while ($subservice = mysqli_fetch_assoc($subservices)): ?>
                    <div class="service-item">
                        <input type="checkbox"
                            id="service-<?php echo $subservice['subservice_id']; ?>"
                            name="subservice_ids[]"
                            value="<?php echo $subservice['subservice_id']; ?>"
                            class="service-checkbox hidden"
                            data-price="<?php echo $subservice['price']; ?>">
                        <label for="service-<?php echo $subservice['subservice_id']; ?>"
                            class="flex justify-between items-center p-4 border rounded-lg cursor-pointer transition-colors hover:bg-purple-50">
                            <div>
                                <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($subservice['subservice_name']); ?></h3>
                                <p class="text-sm text-gray-600">Professional service with warranty</p>
                            </div>
                            <span class="font-semibold text-purple-600">₹<?php echo number_format($subservice['price'], 2); ?></span>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Order Summary</h3>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Services</span>
                    <span id="services-count" class="font-medium">0 selected</span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between">
                    <span class="text-gray-800 font-semibold">Total</span>
                    <span id="total" class="text-purple-600 font-bold">₹0</span>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-bolt mr-2"></i> Book Now for Same-Day Service
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12">
        <!-- Your existing footer code here -->
    </footer>

    <script>
        // Calculate total when services are selected
        document.querySelectorAll('.service-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        function updateSummary() {
            let selectedCount = 0;
            let servicesTotal = 0;

            document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
                selectedCount++;
                servicesTotal += parseFloat(checkbox.dataset.price);
            });

            document.getElementById('services-count').textContent = selectedCount + ' selected (₹' + servicesTotal.toFixed(2) + ')';

            document.getElementById('total').textContent = '₹' + servicesTotal.toFixed(2);
        }
    </script>
</body>

</html>