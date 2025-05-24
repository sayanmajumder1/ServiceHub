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
    $displayImage = !empty($image) ? $image : 'default.jpg';
}
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
        /* Navbar specific styles */
        .original-nav {
            background-color: #ffffff;
        }

        .original-nav-link {
            color: #010913FF;
        }

        .original-nav-link:hover {
            color: #AD46FF;
        }

        .original-sidebar {
            background-color: #ffffff;
        }

        .profile-img-animate {
            transition: all 0.3s ease;
        }

        .profile-img-animate:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Original Navbar -->
    <nav class="original-nav shadow-md sticky top-0 z-50">
        <ul class="sidebar hidden original-sidebar" id="sidebar">
            <li onclick="hideSidebar()" class="navbar-profile-two flex items-center p-4" style="height: 100px;">
                <a href="#" class="text-gray-600 hover:text-gray-900"><i class="fa-solid fa-times"></i></a>
            </li>

            <li class="px-4 py-3 hover:bg-gray-100">
                <a href="home.php" class="original-nav-link hover:text-purple-600"><i class="fas fa-home mr-2"></i> Home</a>
            </li>
            <li class="px-4 py-3 hover:bg-gray-100">
                <a href="cart.php" class="original-nav-link hover:text-purple-600"><i class="fa-solid fa-cart-shopping mr-2"></i>Bookings</a>
            </li>
            <li class="px-4 py-3 hover:bg-gray-100">
                <a href="about.php" class="original-nav-link hover:text-purple-600"><i class="fas fa-info-circle mr-2"></i> About</a>
            </li>
            <li class="px-4 py-3 hover:bg-gray-100">
                <a href="contact.php" class="original-nav-link hover:text-purple-600"><i class="fas fa-envelope mr-2"></i> Contact</a>
            </li>
        </ul>

        <ul class="flex items-center justify-between p-4">
            <li class="logo">
                <img loading="lazy" src="assets/images/logo.png" alt="Service Hub Icon" class="h-10">
            </li>

            <li class="hidden md:block"><a href="home.php" class="px-4 py-2 text-purple-600 font-medium no-underline">Home</a></li>
            <li class="hidden md:block"><a href="cart.php" class="px-4 py-2 original-nav-link hover:text-purple-600 no-underline">Bookings</a></li>
            <li class="hidden md:block"><a href="about.php" class="px-4 py-2 original-nav-link hover:text-purple-600 no-underline">About</a></li>
            <li class="hidden md:block"><a href="contact.php" class="px-4 py-2 original-nav-link hover:text-purple-600 no-underline">Contact</a></li>

            <li class="navbar-profile ml-4" onclick="hideSidebar()">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">
                        <img
                            src="assets/images/<?php echo $displayImage; ?>"
                            alt="User profile"
                            class="rounded-full shadow-md"
                            style="width: 50px; height: 50px; object-fit: cover;" />
                    </a>
                <?php else: ?>
                    <a href="/ServiceHub/Signup_Login/login.php" class="w-20 px-3 py-1 rounded-full bg-[#AD46FF] text-white font-bold no-underline original-nav-link">
                        Signup or Login
                    </a>
                <?php endif; ?>
            </li>

            <li class="menu-icon md:hidden ml-4"><a href="#" onclick="showSidebar()" class="original-nav-link hover:text-purple-600"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>

    <script>
        // Sidebar functionality
        function showSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('fixed', 'top-0', 'left-auto', 'right-0', 'w-64', 'h-full', 'bg-white', 'shadow-lg', 'z-50', 'overflow-y-auto');
        }

        function hideSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'top-0', 'left-0', 'w-64', 'h-full', 'bg-white', 'shadow-lg', 'z-50', 'overflow-y-auto');
        }
    </script>