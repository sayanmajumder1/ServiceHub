<!-- providers.php -->
 <!-- This Page Is Not Under The Admin PAnel -->
<?php 
session_start(); // Start the session
include 'db_connect.php'; 


// In providers.php after getting $subservice_id
if ($subservice_id > 0) {
    $check = $conn->query("SELECT 1 FROM subservice WHERE subservice_id = $subservice_id AND service_id = $service_id");
    if ($check->num_rows == 0) {
        $subservice_id = 0; // or handle error
    }
}

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
    <title>Service Providers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
      <!-- Font Awesome for Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
      <!-- Maintain The  Side Bar  Functionality Java Script     -->

<!-- SideBar Functionality  Js  Code Integrated Here  -->
<script src="SideBarFunction.js"></script>



 <!-- Bootstrap JS (for responsive behavior) -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  

</head>
<body>

<!-- Custom Nav Bar -->
    <nav>
                <!-- Side Bar Section-->
    <ul class="sidebar" id="sidebar">
        <li onclick="hideSidebar()" class="navbar-profile-two d-flex  align-items-center padding-top-bottom" onclick="showSidebar()" style="height: 100px;">
           <a href="#"  ><i class="fa-solid fa-times"></i></a>
           <?php if (isset($_SESSION['user_id'])): ?>
           <a href="profile.php" class="d-inline-block position-relative">
            <img 
            src="assets/images/<?php echo $displayImage; ?>" 
            alt="User profile" 
            class="img-fluid rounded-circle shadow profile-img-animate"
            style="width: 80px; height: 80px; object-fit: cover;"
            />

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
            <img  loading = "lazy "src="assets/images/logo.png" alt="Service Hub Icon ">
           <!-- <span>Service Hub</span>-->
            </li>
            
            <li class="hideOnMobile nav-link"><a href="home.php"  >Home</a></li>
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
                    style="width: 50px; height: 50px; object-fit: cover;"
                    />
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
    if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id']))  {
        echo "<h4 class='text-center mt-5 text-danger'>Invalid service selected.</h4>";
        exit;
    }

    $service_id = (int)$_GET['service_id'];
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

            // Get SubserviceID 
            // At the top, get subservice_id
            $subservice_id = isset($_GET['subservice_id']) ? (int)$_GET['subservice_id'] : 0;



    // Validate and safely query for the service
    $service_query = $conn->query("SELECT subservice_name FROM subservice WHERE subservice_id = $subservice_id");

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
        <h2 class='fw-bold animated-heading'>
            Providers For: " . htmlspecialchars($service['subservice_name']) . "
        </h2>
    </div>";
    // Fetch service providers
    $provider_result = $conn->query("SELECT service_providers.* FROM service_providers INNER JOIN subservice_price_map ON 
    service_providers.service_id = subservice_price_map.service_id WHERE service_providers.service_id = $service_id AND 
    subservice_price_map.subservice_id = $subservice_id AND service_providers.approved_action = 'approved'");

    if ($provider_result === false) {
        echo "<p class='text-center text-danger mt-4'>Error fetching providers: " . htmlspecialchars($conn->error) . "</p>";
        exit;
    }

    if ($provider_result->num_rows > 0) {
        echo "<div class='container'><div class='row mt-4 g-4'>";
        while ($row = $provider_result->fetch_assoc()) {
            $image_data = '../s_pro/uploads2/' . htmlspecialchars(trim($row['image']));
            $provider_id = $row['provider_id'];
            
            // Check if this user has any bookings with this provider
            $booking_check = $conn->query("SELECT * FROM booking WHERE user_id = $user_id AND provider_id = $provider_id AND subservice_id = $subservice_id ORDER BY created_at DESC LIMIT 1   ");
            
            // Initialize default values
            $has_booking = false;
            $button_class = 'btn-primary';
            $button_text = 'Book For Service';
            $base_booking_url = 'booking.php?provider_id=' . urlencode($row['provider_id']) . 
                   '&subservice_id=' . urlencode($subservice_id);
            $target_page = $base_booking_url;

                        if ($booking_check !== false && $booking_check->num_rows > 0) {
                    $booking = $booking_check->fetch_assoc();
                    $booking_status = strtolower($booking['booking_status'] ?? '');
                    
                    switch ($booking_status) {
                        case 'accepted':
                        case 'approved':
                            $button_class = 'btn-success';
                            $button_text = 'Booked';
                            $target_page = 'booking_status.php?id=' . $booking['booking_id'];
                            break;
                        case 'pending':
                            $button_class = 'btn-warning';
                            $button_text = 'Pending';
                            $target_page = 'booking_status.php?id=' . $booking['booking_id'];
                            break;
                        case 'rejected':
                            $button_class = 'btn-primary';
                            $button_text = 'Book Again';
                            $target_page = $base_booking_url;
                            break;
                        case 'completed':
                            $button_class = 'btn-primary';
                            $button_text = 'Book For Service';
                            $target_page = $base_booking_url;
                            break;
                        default:
                            $button_class = 'btn-primary';
                            $button_text = 'Book For Service';
                            $target_page = $base_booking_url;
                    }
                }
                        
                                    
            echo '
            <div class="col-sm-12 col-md-6 col-lg-4   provider-card ">
                <div class="card h-100 shadow border-0 rounded-4">
                    <img src="' . $image_data . '" 
                         class="card-img-top rounded-top-4" 
                         alt="' . htmlspecialchars($row['provider_name']) . '" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="card-title">
                            <h5 class="card-title fw-bold">' . htmlspecialchars($row['provider_name']) . '</h5>
                            <p class="card-text"><strong>Business:</strong> ' . htmlspecialchars($row['businessname']) . '</p>
                            <p class="card-text"><i class="fas fa-envelope"></i> ' . htmlspecialchars($row['email']) . '</p>
                            <p class="card-text"><i class="fas fa-phone"></i> ' . htmlspecialchars($row['phone']) . '</p>
                        </div>
                      <a href="' . $target_page . '" 
                           class="btn ' . $button_class . ' mt-3 w-100">' . $button_text . '</a>
                    </div>
                </div>
            </div>';
        }
        echo "</div></div>";
    } else {
        echo "<p class='text-center mt-4'>No approved providers available for this service.</p>";
    }
    ?>
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
