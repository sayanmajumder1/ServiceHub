<?php
session_start();
include "navbar.php";

// Validate service_id parameter
if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id'])) {
    header("Location: services.php");
    exit();
}

$service_id = (int)$_GET['service_id'];
$user_id = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Providers | ServiceHub</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        secondary: '#7c3aed',
                        accent: '#a78bfa',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-in-out',
                        'fade-in-up': 'fadeInUp 0.6s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style type="text/tailwindcss">
        @layer components {
            .provider-card {
                @apply transition-all duration-300 hover:shadow-lg hover:-translate-y-1;
            }
            .booking-btn {
                @apply w-full py-2 px-4 rounded-lg font-medium transition-all duration-300;
            }
            .booking-btn-primary {
                @apply bg-gradient-to-r from-primary to-secondary text-white hover:from-secondary hover:to-primary;
            }
            .booking-btn-success {
                @apply bg-green-500 text-white hover:bg-green-600;
            }
            .booking-btn-warning {
                @apply bg-amber-500 text-white hover:bg-amber-600;
            }
            .booking-btn-disabled {
                @apply bg-gray-300 text-gray-600 cursor-not-allowed;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="container mx-auto px-4 py-8">
        <?php
        // Prepare and execute service query safely
        $stmt = $conn->prepare("SELECT * FROM service WHERE service_id = ?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $service_result = $stmt->get_result();

        if ($service_result->num_rows === 0) {
            echo '<div class="text-center py-12">
                    <h2 class="text-2xl font-bold text-red-500 mb-4">Service not found</h2>
                    <a href="services.php" class="text-primary hover:underline">Browse available services</a>
                  </div>';
            exit;
        }

        $service = $service_result->fetch_assoc();
        ?>

        <!-- Service Header -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-3xl md:text-4xl font-bold text-dark mb-3 relative pb-2 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-20 after:h-1 after:bg-gradient-to-r after:from-primary after:to-secondary">
                Providers for <?= htmlspecialchars($service['service_name']) ?>
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Choose from our trusted professionals</p>
        </div>

        <!-- Providers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Prepare and execute provider query safely
            $stmt = $conn->prepare("SELECT * FROM service_providers WHERE service_id = ?");
            $stmt->bind_param("i", $service_id);
            $stmt->execute();
            $provider_result = $stmt->get_result();

            if ($provider_result->num_rows > 0) {
                while ($row = $provider_result->fetch_assoc()) {
                    $image_path = !empty($row['image']) ? '../s_pro/uploads2/' . htmlspecialchars($row['image']) : 'assets/default-provider.jpg';
                    $provider_id = $row['provider_id'];

                    // Initialize booking variables
                    $booking_id = null;
                    $booking_status = null;
                    $button_class = 'booking-btn-primary';
                    $button_text = 'Book For Service';
                    $target_page = 'booking.php?provider_id=' . $provider_id;

                    // Check for existing bookings if user is logged in
                    if ($user_id) {
                        $booking_stmt = $conn->prepare("SELECT booking_id, booking_status FROM booking WHERE user_id = ? AND provider_id = ? ORDER BY created_at DESC LIMIT 1");
                        $booking_stmt->bind_param("ii", $user_id, $provider_id);
                        $booking_stmt->execute();
                        $booking_result = $booking_stmt->get_result();

                        if ($booking_result->num_rows > 0) {
                            $booking = $booking_result->fetch_assoc();
                            $booking_id = $booking['booking_id'] ?? null;
                            $booking_status = strtolower($booking['booking_status'] ?? '');

                            // Determine button style based on booking status
                            switch ($booking_status) {
                                case 'accepted':
                                case 'approved':
                                    $button_class = 'booking-btn-success';
                                    $button_text = 'View Booking';
                                    $target_page = 'booking_status.php?id=' . $booking_id;
                                    break;
                                case 'pending':
                                    $button_class = 'booking-btn-warning';
                                    $button_text = 'Pending';
                                    $target_page = 'booking_status.php?id=' . $booking_id;
                                    break;
                                case 'rejected':
                                    $button_text = 'Book For Service';
                                    break;
                                case 'completed':
                                    $button_text = 'Book For Service';
                                    break;
                                default:
                                    $button_class = 'booking-btn-primary';
                                    $button_text = 'Book For Service';
                            }
                        }
                    } else {
                        $button_class = 'booking-btn-disabled';
                        $button_text = 'Login to Book';
                        $target_page = 'login.php';
                    }
            ?>

                    <div class="provider-card bg-white rounded-xl shadow-md overflow-hidden animate-fade-in-up">
                        <img src="<?= $image_path ?>"
                            alt="<?= htmlspecialchars($row['provider_name']) ?>"
                            class="w-full h-48 object-cover">

                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-dark mb-1"><?= htmlspecialchars($row['provider_name']) ?></h3>
                                    <p class="text-gray-500 text-sm mb-3"><?= htmlspecialchars($row['businessname']) ?></p>

                                    <!-- Rating Badge -->
                                    <div class="inline-flex items-center bg-amber-50 text-amber-800 px-2 py-1 rounded-full text-xs font-medium mb-3">
                                        <i class="fas fa-star mr-1"></i>
                                        <span>4.8 (120 reviews)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 my-4">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-envelope text-primary mr-3 w-5"></i>
                                    <span class="text-sm"><?= htmlspecialchars($row['email']) ?></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-phone text-primary mr-3 w-5"></i>
                                    <span class="text-sm"><?= htmlspecialchars($row['phone']) ?></span>
                                </div>
                                <div class="flex items-start text-gray-600">
                                    <i class="fas fa-map-marker-alt text-primary mr-3 mt-1 w-5"></i>
                                    <span class="text-sm"><?= htmlspecialchars($row['address']) ?></span>
                                </div>
                            </div>

                            <a href="<?= $target_page ?>"
                                class="<?= $button_class ?> mt-4 inline-flex items-center justify-center rounded-full px-4 py-2">
                                <?= $button_text ?>
                            </a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col-span-full text-center py-12">
                        <div class="bg-gray-100 rounded-xl p-8 max-w-md mx-auto">
                            <i class="fas fa-hard-hat text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-medium text-gray-700 mb-2">No providers available</h3>
                            <p class="text-gray-500 mb-4">We currently don\'t have providers for this service in your area.</p>
                            <a href="services.php" class="inline-flex items-center text-primary hover:underline">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Browse other services
                            </a>
                        </div>
                      </div>';
            }
            ?>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>