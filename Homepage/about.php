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
  $displayImage = !empty($image) ? $image : 'default.jpg';
}
?>
<!DOCTYPE html>
<html lang="en">
<>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">

  <!-- SideBar Functionality  Js  Code Integrated Here  -->
  <script src="SideBarFunction.js"></script>
  <style>
    .a-container {
      width: 90%;
      max-width: 1100px;
      margin: auto;
      padding: 40px 0;
    }

    h1,
    h2 {
      color: rgb(145, 11, 129);
    }

    .about-intro {
      background-color: #f0f6ff;
      text-align: center;
      padding: 60px 20px;
    }

    .about-intro img {
      width: 100%;
      margin-top: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .mission-story {
      background-color: rgb(255, 255, 255);
      padding: 60px 20px;
    }

    .row1 {
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    .row1.reverse {
      flex-direction: row-reverse;
    }

    .text {
      flex: 1;
    }

    .row1 img {
      flex: 1;
      max-width: 35%;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .numbers {
      background-color: #f0f6ff;
      text-align: center;
      padding: 60px 20px;
    }

    .stats {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .stats div {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      width: 220px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .stats h3 {
      font-size: 2rem;
      color: rgb(145, 11, 107);
      margin-bottom: 10px;
    }

    .stats p {
      font-weight: bold;
      margin: 0;
    }

    .about-section {
      padding: 60px 20px;
      max-width: 1200px;
      margin: auto;
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
    }

    .about-section .about-title {
      text-align: center;
      font-size: 36px;
      margin-bottom: 20px;
      color: #333;
    }

    .about-section .about-subtitle {
      text-align: center;
      font-size: 18px;
      color: #777;
      margin-bottom: 50px;
    }

    .about-section .about-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .about-section .about-box {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      transition: 0.4s ease;
      width: 300px;
      overflow: hidden;
      text-align: center;
      cursor: pointer;
    }

    .about-section .about-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .about-section .about-box img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .about-section .about-box h4 {
      margin: 20px 0 10px;
      font-size: 22px;
      color: #444;
    }

    .about-section .about-box p {
      padding: 0 20px 20px;
      color: #666;
      font-size: 15px;
    }

    .about-section {
      padding: 60px 20px;
    }

    .about-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      max-width: 1200px;
      margin: auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 60px;
      overflow: hidden;
    }

    .about-container.reverse {
      flex-direction: row-reverse;
    }

    .about-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
      background-color: #f0f4ff;
    }

    .about-image,
    .about-text {
      flex: 1;
      min-width: 300px;
      padding: 30px;
    }

    .about-image img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .about-text h2 {
      font-size: 30px;
      color: #333;
      margin-bottom: 15px;
    }

    .about-text p {
      font-size: 17px;
      color: #555;
      line-height: 1.7;
    }

    @media screen and (max-width: 768px) {
      .about-container.reverse {
        flex-direction: column;
      }

      .about-container {
        flex-direction: column;
      }

      .about-text,
      .about-image {
        padding: 20px;
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
        <li class="hideOnMobile nav-link"><a href="booking.php">Bookings</a></li>
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
            <a href="/ServiceHub/Signup_Login/login.php" class="fw-bold" style="text-decoration: none;color: #010913FF;">
              Signup or Login
            </a>
          <?php endif; ?>
        </li>
        <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
      </ul>
    </nav>
    <!-- About Intro -->
    <section class="about-intro">
      <div class="a-container">
        <h1>About Us</h1>
        <p>We believe in delivering exceptional home services with a personal touch. Your satisfaction is our mission.</p>
        <img src="assets/images/i1.jpg" alt="Team photo">
      </div>
    </section>

    <!-- Mission and Story -->
    <!-- HTML Content for About Page Body -->
    <section class="about-section">
      <div class="about-container">
        <div class="about-image">
          <img src="assets/images/i2.jpg" alt="Our Founding">
        </div>
        <div class="about-text">
          <h2>Our Founding</h2>
          <p>We began with a single goal: to bring professional, high-quality home services to families everywhere. What started as a small team of experts has grown into a trusted brand committed to making your home better every day.</p>
        </div>
      </div>

      <div class="about-container reverse">
        <div class="about-image">
          <img src="assets/images/i5.jpg" alt="Early Growth">
        </div>
        <div class="about-text">
          <h2>Early Growth</h2>
          <p>With increasing demand, we expanded our reach, serving new cities and improving our services. Our team grew, and so did our commitment to customer satisfaction, turning challenges into stepping stones for success.</p>
        </div>
      </div>

      <div class="about-container">
        <div class="about-image">
          <img src="assets/images/i8.jpg" alt="Series B Funding">
        </div>
        <div class="about-text">
          <h2>Series B Funding</h2>
          <p>We secured major funding to grow even faster. It helped us modernize our technology, streamline our services, and reach even more households looking for reliable home solutions.</p>
        </div>
      </div>

      <div class="about-container reverse">
        <div class="about-image">
          <img src="assets/images/i6.jpg" alt="A New Leaf">
        </div>
        <div class="about-text">
          <h2>A New Leaf</h2>
          <p>Today, we continue to innovate and adapt, always staying focused on what matters most—our customers. With every new home we enter, we bring excellence, care, and a promise of better living.</p>
        </div>
      </div>
    </section>

    <section class="about-section">
      <div class="about-grid">
        <div class="about-box">
          <img src="assets/images/i3.jpg" alt="Mission">
          <h4><i class="fas fa-bullseye"></i> Our Mission</h4>
          <p>We aim to simplify home maintenance by connecting users with top professionals for cleaning, repairs, painting, and more.</p>
        </div>

        <div class="about-box">
          <img src="assets/images/i4.jpg" alt="Why Choose Us">
          <h4><i class="fas fa-thumbs-up"></i> Why Choose Us</h4>
          <p>Verified professionals, transparent pricing, and 24/7 support make us the preferred choice for home services.</p>
        </div>

        <div class="about-box">
          <img src="assets/images/i7.jpg" alt="Vision">
          <h4><i class="fas fa-eye"></i> Our Vision</h4>
          <p>To be the most trusted home service platform across the country, improving lives through quality and convenience.</p>
        </div>
      </div>
      <div class="text-center mt-4">
        <a href="home.php" class="btn btn-primary btn-lg px-5">Explore Our Services</a>
      </div>
    </section>
    <br>


    <!-- By the Numbers -->
    <section class="numbers">
      <div class="container">
        <h2>By the Numbers</h2>
        <div class="stats">
          <div>
            <h3>500+</h3>
            <p>Homes Serviced</p>
          </div>
          <div>
            <h3>100+</h3>
            <p>Expert Staff</p>
          </div>
          <div>
            <h3>4.9/5</h3>
            <p>Customer Rating</p>
          </div>
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