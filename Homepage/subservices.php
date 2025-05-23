<!-- providers.php -->
<!-- This Page Is Not Under The Admin PAnel -->
<?php
session_start(); // Start the session
include 'db_connect.php';


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

?>
<!DOCTYPE html>
<html>

<head>
    <title>Select Sub Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Maintain The  Side Bar  Functionality Java Script     -->

    <!-- SideBar Functionality  Js  Code Integrated Here  -->
    <script src="SideBarFunction.js"></script>



    <!-- Bootstrap JS (for responsive behavior) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


</head>

<body>

    <!-- Custom Nav Bar -->
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
                <a href="home.php"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
                <a href="booking.php"><i class="fa-solid fa-cart-shopping"></i>Bookings</a>
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

            <li class="hideOnMobile nav-link"><a href="home.php">Home</a></li>
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



    <div class="container mt-5 pt-5">
        <?php
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "<h4 class='text-center mt-5 text-danger'>Invalid service selected.</h4>";
            exit;
        }

        $service_id = (int)$_GET['id'];
        $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

        // Validate and safely query for the service
        $service_query = $conn->query("SELECT service_name FROM service WHERE service_id = $service_id");

        if (!$service_query) {
            echo "<h4 class='text-center mt-5 text-danger'>Database query error: " . htmlspecialchars($conn->error) . "</h4>";
            exit;
        }

        $service = $service_query->fetch_assoc();

        if (!$service) {
            echo "<h4 class='text-center mt-5 text-danger'>Service not found.</h4>";
            exit;
        }

        echo "
        <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-heading {
            position: relative;
            display: inline-block;
            animation: fadeInUp 1s ease-in-out;
            color: #ad67c8;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .animated-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            height: 3px;
            width: 100%;
            background-color: #ad67c8;
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: left;
            animation: underlineGrow 1s ease-in-out forwards;
        }

        @keyframes underlineGrow {
            to {
                transform: scaleX(1);
            }
        }
        </style>

        <div class='container text-center mt-5'>
            <h2 class='fw-bold animated-heading mb-5'>
                Select Sub Service For: " . htmlspecialchars($service['service_name']) . "
            </h2>
        </div>";

        ?>
    </div>

    <div class="main w-full flex justify-between items-center p-5">
        <div class="leftimg h-1/2 w-1/2">
            <img src="assets/images/subservices.png" alt="">
        </div>

        <div class="subservices w-full px-15">
            <?php  // Fetch sub-services
            $res = $conn->query('SELECT * FROM subservice WHERE service_id = "' . $_GET['id'] . '"');
            while ($row = mysqli_fetch_array($res)) {
            ?>
                <div class="lg:w-full w-2.5/3 flex justify-between items-center border-2 border-gray-200 p-4 rounded-md shadow-sm transform transition duration-500 hover:scale-103 mb-3">
                    <!-- Left Side -->
                    <div class="flex flex-col space-y-1">
                        <h2 class="font-semibold text-lg"><?php echo $row['subservice_name'] ?></h2>
                        <div class="flex items-center text-sm text-gray-600">
                            <span class="text-purple-600">★</span>
                            <span class="ml-1">4.83</span>
                        </div>
                        <p class="text-sm font-medium">Starts at ₹49</p>
                                                
                            <!-- Change the Book button link to pass subservice_id -->
                            <a href="providers.php?service_id=<?php echo $row['service_id'] ?>&subservice_id=<?php echo $row['subservice_id'] ?>" 
                            class="text-decoration-none text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm text-center mb-2 w-20 p-2">
                            Book <i class="bi bi-arrow-right"></i>
                            </a>
                    </div>

                    <!-- Right Side -->
                    <div class="flex flex-col items-center space-y-2">
                        <img src="/ServiceHub/Admin/img/<?php echo $row['image'] ?>" alt="Switch" class="w-30 h-30 object-contain" />
                    </div>
                </div>


            <?php
            }
            ?>
        </div>

        <div class="rightimg h-1/2 w-1/2">
            <img src="assets/images/brands.png" alt="">
        </div>
    </div>


    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-4 footer-section">
                    <h5>About Us</h5>
                    <p>We provide high-quality home services including cleaning, repair, and painting. Our goal is to make your home beautiful and functional.</p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 footer-section">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="col-md-4 footer-section">
                    <h5>Contact Us</h5>
                    <p>Email: support@example.com</p>
                    <p>Phone: +123 456 7890</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center copyright">
                <p>&copy; 2025 YourCompany. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>