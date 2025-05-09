<?php
// Set session cookie parameters BEFORE starting the session
$lifetime = 60 * 60 * 24 * 7; // 7 days
ini_set('session.gc_maxlifetime', $lifetime);
ini_set('session.cookie_lifetime', $lifetime);

session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/',
    'domain' => '', 
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start(); // Start the session

include_once "db_connect.php";

// Use session safely now
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location:/ServiceHub/Signup_Login/login.php ");
    exit();
}
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Service Page </title>
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
     <!-- Maintain The  Side Bar  Functionality Java Script     -->
     <script src ="SideBarFunction.js"></script>

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
                <a href="profile.php" class="d-inline-block position-relative">
                    <img 
                    src="assets/images/<?php echo $displayImage; ?>"
                    alt="User profile" 
                    class="img-fluid rounded-circle shadow profile-img-animate"
                    style="width: 80px; height: 80px; object-fit: cover;"
                    />
                </a>
                </li>
        <li>
         <a href="home.php"><i class="fas fa-home"></i> Home</a>
        </li>
            <li>
              <a href="service.php"><i class="fas fa-concierge-bell"></i>Service</a>
            </li>
            <li>
           <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>Cart</a>
           </li>
            <li>
              <a href="#"><i class="fas fa-info-circle"></i> About</a>
            </li>
            <li>
               <a href="#"><i class="fas fa-envelope"></i> Contact</a>
            </li>
   </ul>
       <!-- Nav  Bar Section-->      
        <ul>
            <li class="logo">
            <img src="assets/images/logo.png" alt="Electricity">
            </li>
            <li class="hideOnMobile nav-link"><a href="home.php">Home</a></li>
            <li class="hideOnMobile nav-link"><a href="#">Service</a></li>
            <li class="hideOnMobile nav-link"><a href="cart.php">Cart</a></li>
            <li class="hideOnMobile nav-link"><a href="#">About</a></li>
            <li class="hideOnMobile nav-link"><a href="#">Contact</a></li>
            <li class="navbar-profile" onclick="hideSidebar()">
                <a href="profile.php">
                    <img 
                    src="assets/images/<?php echo $displayImage; ?>" 
                    alt="User profile" 
                    class="img-fluid rounded-circle shadow" 
                    style="width: 50px; height: 50px; object-fit: cover;"
                    />
                </a>
                </li>
            <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>
    
            <!-- Title -->
            <div class ="container mt-5 pt-5 ">
            <h3 class="section-title-three">Services Category</h3>
            </div>

      <!-- Service Categories Section -->
      <div class="container mt-5 ">
                <div class="row text-center">
                    <?php
                    include 'db_connect.php'; // adjust path if needed
                    $sql = "SELECT * FROM service";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // Useing While Loops To Show The Cards Category
                        while ($row = $result->fetch_assoc()) {
                            $image_data = '../Admin/img/' . $row['image']; 
                            echo '
                            <div class="col-4 col-md-4 col-lg-4 mb-3">
                                <a href="providers.php?id=' . $row['service_id'] . '" class="text-decoration-none text-dark">
                                    <div class="service-box">
                                        <img src="' .trim( $image_data) . '" alt="' . htmlspecialchars($row['service_name']) . '" class="img-fluid">
                                        <p>' . htmlspecialchars($row['service_name']) . '</p>
                                    </div>
                                </a>
                            </div>';
                        }
                          // <img src="data:image/jpeg;base64,' . $image_data . '" alt="' . htmlspecialchars($row['service_name']) . '" class="img-fluid">
                          // This Fetched  The    Image And Category name From Service Table.
                          // <a href="providers.php?id=' . $row['id'] . '" class="text-decoration-none text-dark">
                          // This Line  Jump A another  Page Which Name Is providers.php , where the service providers are show .. 
                    } else {
                        echo '<p class="text-center">No services available</p>';
                    }
                    $conn->close();
                    ?>
                </div>
            </div>

    
    
    
    
    
    
   


<!-- Fotter Section --->
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