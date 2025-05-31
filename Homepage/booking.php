<?php
session_start();
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
$subservices_query = "SELECT ss.subservice_id, ss.subservice_name, spm.price 
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Services - <?php echo htmlspecialchars($provider['businessname']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap CSS
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
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

        .selected-service {
            border-color: #9f7aea !important;
            background-color: #f5f3ff !important;
        }
    </style>
</head>

<body class="bg-gray-50">
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
            <?php
                
                if(isset($_SESSION['user_id']))
                {
            ?>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <?php
                }
            ?>
            

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Services</h2>

            <!-- Services List -->
            <div class="space-y-3 mb-6">
                <?php $selected_subservice_id = isset($_GET['subservice_id']) ? (int)$_GET['subservice_id'] : 0; ?>

                <!-- // Then in the checkbox loop, add checked attribute if it matches: -->
                <?php while ($subservice = mysqli_fetch_assoc($subservices)): ?>
                    <div class="service-item">
                        <input type="checkbox"
                            id="service-<?php echo $subservice['subservice_id']; ?>"
                            name="subservice_ids[]"
                            value="<?php echo $subservice['subservice_id']; ?>"
                            class="service-checkbox hidden"
                            data-price="<?php echo $subservice['price']; ?>"
                            <?php echo ($subservice['subservice_id'] == $selected_subservice_id) ? 'checked' : ''; ?>>
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
                    <span id="services-count" class="font-medium"><?php echo ($selected_subservice_price > 0) ? '1 selected (₹' . number_format($selected_subservice_price, 2) . ')' : '0 selected'; ?></span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between">
                    <span class="text-gray-800 font-semibold">Total</span>
                    <span id="total" class="text-purple-600 font-bold"><?php echo ($selected_subservice_price > 0) ? '₹' . number_format($selected_subservice_price, 2) : '₹0'; ?></span>
                </div>
            </div>

             
             
            <!-- Submit Button -->
           <!-- <?php
                
                if(isset($_SESSION['user_id']))
                {
            ?>  
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-bolt mr-2"></i> Book Now for Same-Day Service
            </button>
            <?php
                }
                else
                {
            ?>
                <a href="serviceHub/Signup_Login/login.php";
            <?php
                } 
            ?> -->
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
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
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

            document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
                selectedCount++;
                servicesTotal += parseFloat(checkbox.dataset.price);
            });

            document.getElementById('services-count').textContent =
                selectedCount + ' selected (₹' + servicesTotal.toFixed(2) + ')';
            document.getElementById('total').textContent = '₹' + servicesTotal.toFixed(2);

            // Add visual feedback for selected services
            document.querySelectorAll('.service-checkbox').forEach(checkbox => {
                const label = checkbox.closest('.service-item').querySelector('label');
                if (checkbox.checked) {
                    label.classList.add('selected-service');
                } else {
                    label.classList.remove('selected-service');
                }
            });
        }

        // Initialize with selected subservice price if available
        document.addEventListener('DOMContentLoaded', function() {
            const selectedPrice = <?php echo $selected_subservice_price; ?>;
            if (selectedPrice > 0) {
                // Find the checkbox for the selected subservice and trigger change
                const checkboxes = document.querySelectorAll('.service-checkbox');
                checkboxes.forEach(checkbox => {
                    if (parseFloat(checkbox.dataset.price) === selectedPrice) {
                        checkbox.checked = true;
                        checkbox.closest('.service-item').querySelector('label').classList.add('selected-service');
                        // Update summary immediately
                        updateSummary();
                    }
                });
            }
        });
    </script>
</body>

</html>