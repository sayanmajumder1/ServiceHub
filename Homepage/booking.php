<?php

include "navbar.php";
// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }
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
$subservices_query = "SELECT ss.subservice_id, ss.subservice_name, spm.price, ss.image, ss.service_des 
                      FROM subservice ss
                      JOIN subservice_price_map spm ON ss.subservice_id = spm.subservice_id
                      WHERE spm.provider_id = ?";
$stmt = mysqli_prepare($conn, $subservices_query);
mysqli_stmt_bind_param($stmt, "i", $provider_id);
mysqli_stmt_execute($stmt);
$subservices = mysqli_stmt_get_result($stmt);

// Get the selected subservice price if coming from providers.php
$selected_subservice_price = 0;
if (isset($_GET['subservice_id']) && is_numeric($_GET['subservice_id'])) {
    $subservice_id = (int)$_GET['subservice_id'];
    $price_query = "SELECT price FROM subservice_price_map 
                   WHERE provider_id = ? AND subservice_id = ?";
    $stmt = mysqli_prepare($conn, $price_query);
    mysqli_stmt_bind_param($stmt, "ii", $provider_id, $subservice_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $selected_subservice_price = $row['price'];
    }
}

// Check for stored selections in cookies for guest users
$stored_selections = [];
if (!isset($_SESSION['user_id']) && isset($_COOKIE['guest_selections'])) {
    $stored_selections = json_decode($_COOKIE['guest_selections'], true);
    // Validate that stored selections belong to this provider
    if (isset($stored_selections['provider_id']) && $stored_selections['provider_id'] == $provider_id) {
        $selected_subservice_price = 0;
        foreach ($stored_selections['subservice_ids'] as $id) {
            // Get price for each stored subservice
            $price_query = "SELECT price FROM subservice_price_map 
                           WHERE provider_id = ? AND subservice_id = ?";
            $stmt = mysqli_prepare($conn, $price_query);
            mysqli_stmt_bind_param($stmt, "ii", $provider_id, $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $selected_subservice_price += $row['price'];
            }
        }
    }
}

// Error message if no service selected on form submission
$error = '';
if (isset($_GET['error']) && $_GET['error'] == 'no_service') {
    $error = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p>Please select at least one service to continue.</p>
              </div>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Services - <?php echo htmlspecialchars($provider['businessname']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#AD46FF',
                        secondary: '#9820f7',
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap JS (for responsive behavior) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .service-checkbox:checked+.service-card {
            border-color: #9f7aea;
            background-color: #f5f3ff;
            box-shadow: 0 0 0 2px #9f7aea;
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

        .selected-service {
            border-color: #9f7aea !important;
            background-color: #f5f3ff !important;
        }

        .service-image {
            height: 100px;
            object-fit: contain;
            width: 100%;
            border-radius: 0.5rem 0.5rem 0 0;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Provider Header -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 mt-20">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-contain md:w-48 rounded-full ml-5"
                        src="../s_pro/uploads2/<?php echo !empty($provider['image']) ? htmlspecialchars($provider['image']) : 'default_provider.png'; ?>"
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
        <form action="booking_process.php" method="POST" class="bg-white rounded-xl shadow-md p-6" onsubmit="return validateServices()">
            <input type="hidden" name="provider_id" value="<?php echo $provider['provider_id']; ?>">
            <input type="hidden" name="service_id" value="<?php echo $provider['service_id']; ?>">

            <?php if (isset($_SESSION['user_id'])): ?>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <?php endif; ?>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Services</h2>

            <!-- Error message display -->
            <?php echo $error; ?>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <?php
                $selected_subservice_id = isset($_GET['subservice_id']) ? (int)$_GET['subservice_id'] : 0;
                mysqli_data_seek($subservices, 0); // Reset pointer to start
                ?>

                <?php while ($subservice = mysqli_fetch_assoc($subservices)): ?>
                    <div class="service-item">
                        <input type="checkbox"
                            id="service-<?php echo $subservice['subservice_id']; ?>"
                            name="subservice_ids[]"
                            value="<?php echo $subservice['subservice_id']; ?>"
                            class="service-checkbox hidden"
                            data-price="<?php echo $subservice['price']; ?>"
                            <?php
                            // Check if this subservice is in stored selections or GET parameter
                            if ((isset($stored_selections['subservice_ids']) &&
                                    in_array($subservice['subservice_id'], $stored_selections['subservice_ids'])) ||
                                $subservice['subservice_id'] == $selected_subservice_id
                            ) {
                                echo 'checked';
                            }
                            ?>>
                        <label for="service-<?php echo $subservice['subservice_id']; ?>"
                            class="service-card block border rounded-lg overflow-hidden cursor-pointer transition-all hover:shadow-md">
                            <div class="relative">
                                <img src="../Admin/img/<?php echo htmlspecialchars($subservice['image']); ?>"
                                    alt="<?php echo htmlspecialchars($subservice['subservice_name']); ?>"
                                    class="service-image">
                                <div class="absolute top-2 right-2 bg-white p-1">
                                    <span class="text-purple-600 font-bold text-sm">₹<?php echo number_format($subservice['price'], 2); ?></span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-800 mb-1"><?php echo htmlspecialchars($subservice['subservice_name']); ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars($subservice['service_des']); ?></p>
                            </div>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Order Summary</h3>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Services</span>
                    <span id="services-count" class="font-medium"><?php echo ($selected_subservice_price > 0) ? '1 selected (₹' . number_format($selected_subservice_price, 2) . ')' : '0 selected'; ?></span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between">
                    <span class="text-gray-800 font-semibold">Total</span>
                    <span id="total" class="text-purple-600 font-bold"><?php echo ($selected_subservice_price > 0) ? '₹' . number_format($selected_subservice_price, 2) : '₹0'; ?></span>
                </div>
            </div>

            <!-- Submit Button -->
            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <i class="fas fa-bolt mr-2"></i> Book Now for Same-Day Service
                </button>
            <?php
            } else {
            ?>
                <a href="/serviceHub/Signup_Login/login.php"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i> Login to Book Now
                </a>
            <?php
            }
            ?>
        </form>
    </div>

    <?php
    include_once "footer.php";
    ?>

    <script>
        // Calculate total when services are selected
        document.querySelectorAll('.service-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        function updateSummary() {
            let selectedCount = 0;
            let servicesTotal = 0;
            let selectedIds = [];

            document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
                selectedCount++;
                servicesTotal += parseFloat(checkbox.dataset.price);
                selectedIds.push(checkbox.value);
            });

            document.getElementById('services-count').textContent =
                selectedCount + ' selected (₹' + servicesTotal.toFixed(2) + ')';
            document.getElementById('total').textContent = '₹' + servicesTotal.toFixed(2);

            // Add visual feedback for selected services
            document.querySelectorAll('.service-checkbox').forEach(checkbox => {
                const label = checkbox.nextElementSibling;
                if (checkbox.checked) {
                    label.classList.add('selected-service');
                } else {
                    label.classList.remove('selected-service');
                }
            });

            // Store selections in cookie for guest users
            <?php if (!isset($_SESSION['user_id'])): ?>
                const providerId = <?php echo $provider_id; ?>;
                const selections = {
                    provider_id: providerId,
                    subservice_ids: selectedIds
                };
                document.cookie = `guest_selections=${JSON.stringify(selections)}; path=/; max-age=${60 * 60 * 24}`; // 24 hours
            <?php endif; ?>
        }

        // Form validation
        function validateServices() {
            const selectedServices = document.querySelectorAll('.service-checkbox:checked');
            if (selectedServices.length === 0) {
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded';
                errorDiv.innerHTML = `
                    <p>Please select at least one service to continue.</p>
                `;

                // Insert before the form or services grid
                const form = document.querySelector('form');
                const firstChild = form.firstChild;
                form.insertBefore(errorDiv, firstChild);

                // Scroll to error
                errorDiv.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                return false;
            }
            return true;
        }

        // Initialize with selected services
        document.addEventListener('DOMContentLoaded', function() {
            const selectedPrice = <?php echo $selected_subservice_price; ?>;
            if (selectedPrice > 0) {
                updateSummary();
            }

            // Check for stored selections
            <?php if (!empty($stored_selections)): ?>
                updateSummary();
            <?php endif; ?>
        });
    </script>
</body>

</html>