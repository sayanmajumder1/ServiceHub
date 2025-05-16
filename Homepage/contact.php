<?php

session_start(); // Start the session
include_once "db_connect.php";
// Use session safely now
//$user_id = $_SESSION['user_id'] ?? null;
//if (!$user_id) {
  //  header("Location:/ServiceHub/Signup_Login/login.php ");
    //exit();
//}
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
$displayImage = !empty($image) ? $image : 'default.jpg';}
?>
<!DOCTYPE html>
< lang="en">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
      <!-- Font Awesome for Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
<!-- SideBar Functionality  Js  Code Integrated Here  -->
    <script src= "SideBarFunction.js"></script>
    <style>
.contact-section {
  margin-top: 100px;
  padding: 40px 20px;
  background-color: #f3eaff;
  font-family: 'Arial', sans-serif;
}
.contact-container {
  max-width: 1100px;
  margin: auto;
  display: flex;
  flex-wrap: wrap;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.contact-info {
  flex: 1;
  padding: 30px;
  background: #ece3ff;
}

.contact-info h2 {
  color: #6a1b9a;
  margin-bottom: 20px;
}

.contact-info p {
  color: #333;
  margin: 12px 0;
  font-size: 15px;
  display: flex;
  align-items: center;
}

.contact-info i {
  color: #fff;
  margin-right: 3px;
  font-size: 18px;
}

.social-icons {
  margin-top: 10px;
}

.social-icons a {
  display: inline-block;
  color: #fff;
  background: #ad67c8;
  width: 35px;
  height: 35px;
  line-height: 35px;
  text-align: center;
  margin-right: 8px;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.social-icons a:hover {
  background: #8b4ea7;
}


.contact-form {
  flex: 1;
  padding: 30px;
}

.contact-form h2 {
  color: #ad67c8;
  margin-bottom: 20px;
}

.contact-form input,
.contact-form textarea {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
}

.contact-form textarea {
  min-height: 100px;
  resize: vertical;
}

.contact-form button {
  background:rgb(154, 27, 150);
  color: white;
  padding: 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
}

.contact-form button:hover {
  background:rgb(126, 20, 140);
}

@media screen and (max-width: 768px) {
  .contact-container {
    flex-direction: column;
  }
}
</style>
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
           <a href="service.php"><i class="fas fa-concierge-bell"></i>Service</a>
        </li>
        <li>
           <a href="booking.php"><i class="fa-solid fa-cart-shopping"></i>Cart</a>
           </li>
        <li>
           <a href="about.php"><i class="fas fa-info-circle"></i>About</a>
        </li>
        <li>
           <a href="contact.php"><i class="fas fa-envelope"></i>Contact</a>
        </li>
    </ul>
       <!-- Nav  Bar Section-->      
        <ul>
            <li class="logo">
            <img src="assets/images/logo.png" alt="Electricity">
         
            </li>
            <li class="hideOnMobile nav-link"><a href="home.php">Home</a></li>
            <li class="hideOnMobile nav-link"><a href="service.php">Service</a></li>
            <li class="hideOnMobile nav-link"><a href="cart.php">Cart</a></li>
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
            <a href="/ServiceHub/Signup_Login/login.php" class="fw-bold" style="text-decoration: none;color: #010913FF;">
                Signup or Login
            </a>
        <?php endif; ?>
                </li>
            <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>
    <!--Contact Section-->
   <section class="contact-section">
  <div class="contact-container">
    <div class="contact-info">
      <h2>Get In Touch</h2>
      <p><i class="fas fa-envelope"></i> support@example.com</p>
      <p><i class="fas fa-phone"></i> +123 456 7890</p>
      <p><i class="fas fa-map-marker-alt"></i> 123 Main St, Your City</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>
    <div class="contact-form">
      <h2>Contact Us</h2>
      <form>
        <input type="text" placeholder="Your Name" required>
        <input type="email" placeholder="Your Email" required>
        <textarea placeholder="Message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </div>
</section>



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