<?php
session_start();
include_once "db_connect.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    $image = $user['image'] ?? '';
     $displayImage = !empty($image) ? 'assets/images/' . $image : 'assets/images/default_user.png';
}

$userLocation = $_SESSION['user_location'] ?? 'Set location';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Service Finder</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #AD46FF;
            --primary-hover: #9820f7;
        }

        .navbar {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.98);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .nav-link {
            position: relative;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.2s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .active {
            color: var(--primary);
        }

        .active::after {
            width: 100%;
        }

        /* Prevent scrolling when mobile menu is open */
        body.menu-open {
            overflow: hidden;
        }
    </style>
</head>

<body>
    <nav class="navbar fixed top-0 w-full z-50 px-5">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="home.php" class="flex items-center">
                        <img src="assets/images/logo.png" alt="ServiceHub" class="h-24 w-auto">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Desktop Location Selector -->
                    <div class="location-container relative">
                        <div class="location-btn flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-map-marker-alt text-gray-600"></i>
                            <span class="text-gray-800 font-medium"><?php echo htmlspecialchars($userLocation); ?></span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </div>
                        
                        <div class="location-dropdown absolute top-full left-0 w-64 bg-white rounded-lg shadow-lg mt-1 p-4 hidden">
                            <button id="detect-location" class="bg-purple-600 hover:bg-purple-700 w-full py-2 rounded-lg text-white font-medium transition transform hover:-translate-y-1 shadow-md">
                                <i class="fas fa-location-arrow mr-2"></i> Use Current Location
                            </button>
                        </div>
                    </div>

                    <a href="home.php" class="nav-link text-gray-800 font-medium">Home</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cart.php" class="nav-link text-gray-800 font-medium">Bookings</a>
                    <?php endif; ?>
                    <a href="about.php" class="nav-link text-gray-800 font-medium">About</a>
                    <a href="contact.php" class="nav-link text-gray-800 font-medium">Contact</a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="profile.php" class="flex items-center space-x-2">
                            <img src="<?php echo $displayImage; ?>" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm border-2 border-transparent hover:border-purple-500 hover:scale-105 transition">
                        </a>
                    <?php else: ?>
                        <a href="/ServiceHub/Signup_Login/login.php" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-full text-white font-medium transition transform hover:-translate-y-1 shadow-md">
                            Sign In
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-800 focus:outline-none" aria-label="Toggle menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed inset-0 w-full h-screen z-40 pt-16">
            <button id="close-menu" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 focus:outline-none z-50" aria-label="Close menu">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="container mx-auto px-4 h-full overflow-y-auto">
                <div class="flex flex-col h-full py-6">
                    <!-- Mobile Location Selector -->
                    <div class="mb-6 px-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-map-marker-alt text-gray-600"></i>
                            <span class="text-gray-800 font-medium"><?php echo htmlspecialchars($userLocation); ?></span>
                        </div>
                        <button id="mobile-detect-location" class="bg-purple-600 hover:bg-purple-700 w-full py-2 rounded-lg text-white font-medium transition transform hover:-translate-y-1 shadow-md">
                            <i class="fas fa-location-arrow mr-2"></i> Use Current Location
                        </button>
                    </div>

                    <nav class="flex-1 space-y-6">
                        <a href="home.php" class="block nav-link text-gray-800 font-medium text-lg px-4 py-3">Home</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="cart.php" class="block nav-link text-gray-800 font-medium text-lg px-4 py-3">Bookings</a>
                        <?php endif; ?>
                        <a href="about.php" class="block nav-link text-gray-800 font-medium text-lg px-4 py-3">About</a>
                        <a href="contact.php" class="block nav-link text-gray-800 font-medium text-lg px-4 py-3">Contact</a>
                    </nav>

                    <div class="pt-8 border-t border-gray-200 px-4">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="profile.php" class="flex items-center space-x-4 py-4">
                                <img src="<?php echo $displayImage; ?>" alt="Profile" class="w-12 h-12 rounded-full object-cover shadow-sm border-2 border-transparent hover:border-purple-500 hover:scale-105 transition">
                                <span class="font-medium text-gray-800 text-lg">My Profile</span>
                            </a>
                        <?php else: ?>
                            <a href="/ServiceHub/Signup_Login/login.php" class="bg-purple-600 hover:bg-purple-700 block w-full text-center px-4 py-3 rounded-lg text-white font-medium text-lg transition transform hover:-translate-y-1 shadow-md">
                                Sign In
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMenuButton = document.getElementById('close-menu');
            const body = document.body;
            const locationBtn = document.querySelector('.location-btn');
            const locationDropdown = document.querySelector('.location-dropdown');

            // Toggle mobile menu
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.add('open');
                body.classList.add('menu-open');
            });

            // Close menu when clicking close button
            closeMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
                body.classList.remove('menu-open');
            });

            // Toggle location dropdown on desktop
            locationBtn.addEventListener('click', function() {
                locationDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!locationBtn.contains(e.target) && !locationDropdown.contains(e.target)) {
                    locationDropdown.classList.add('hidden');
                }
            });

            // Highlight current page in navigation
            const currentPage = location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                }
            });

            // Location detection function
            function detectLocation(isMobile = false) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                .then(response => response.json())
                                .then(data => {
                                    const locationName = data.address.city || data.address.town || data.address.village || data.address.county;
                                    
                                    // Update UI
                                    const locationElements = isMobile 
                                        ? document.querySelectorAll('#mobile-menu .text-gray-800.font-medium')
                                        : document.querySelectorAll('.location-btn .text-gray-800');
                                    
                                    locationElements.forEach(el => el.textContent = locationName);
                                    
                                    // Save to session
                                    fetch('save_location.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: `name=${encodeURIComponent(locationName)}&lat=${lat}&lng=${lng}`
                                    });
                                });
                        },
                        function(error) {
                            alert('Unable to retrieve your location. Please make sure location access is allowed.');
                        }
                    );
                } else {
                    alert('Geolocation is not supported by your browser.');
                }
            }

            // Event listeners for location buttons
            document.getElementById('detect-location').addEventListener('click', () => detectLocation());
            document.getElementById('mobile-detect-location').addEventListener('click', () => detectLocation(true));
        });
    </script>
</body>
</html>