<?php


session_start(); // Start the session

include_once "db_connect.php";

// Use session safely now
//$user_id = $_SESSION['user_id'] ?? null;
//if (!$user_id) {
  //  header("Location:/ServiceHub/Signup_Login/login.php ");
    //exit();
//}
// In providers.php after getting $subservice_id

 $subservice_id = isset($_GET['subservice_id']) ? (int)$_GET['subservice_id'] : 0;

// Check if provider_id is passed in URL
if (!isset($_GET['provider_id']) || !is_numeric($_GET['provider_id'])) {
    header("Location: service.php");
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
    header("Location: service.php");
    exit();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
      <!-- Font Awesome for Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

   
  <!-- Bootstrap JS (for responsive behavior) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SideBar Functionality  Js  Code Integrated Here  -->
    <script src= "SideBarFunction.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<style> 
  body {
  font-family: 'Poppins', sans-serif;
  background-color: #f9f9f9;
  margin: 0;
  padding: 0;
}

.header-img {
  height: 320px;
  background: center center / cover no-repeat;
  position: relative;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
}

.header-buttons {
  position: absolute;
  top: 20px;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
  z-index: 10;
}

.header-buttons .btn {
  background-color: rgba(255, 255, 255, 0.9);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.detail-title {
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 16px 20px;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
  width: 100%;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
}

.detail-title h4 {
  color: #fff;
  margin: 0;
  font-size: 1.4rem;
}

.tag {
  background-color: #f2e7f6;
  color: #ad67c8;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 13px;
  display: inline-block;
  font-weight: 500;
}

.tabs button {
  border: none;
  background: none;
  font-weight: 600;
  padding: 12px 0;
  color: #6c757d;
  transition: all 0.3s;
  position: relative;
  flex: 1;
}

.tabs button.active {
  color: #ad67c8;
}

.tabs button.active::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  width: 100%;
  background-color: #ad67c8;
  border-radius: 5px;
}

.price-btn {
  background-color: #ad67c8;
  color: white;
  border-radius: 40px;
  padding: 14px;
  font-size: 16px;
  font-weight: 600;
  border: none;
  width: 100%;
  transition: background 0.3s ease-in-out;
}

.price-btn:hover {
  background-color: #974fb3;
}

.container {
  padding: 16px;
}
a.btn:hover {
    background-color: #ad67c8 !important;
    color: white !important;
}
@media (min-width: 768px) {
  .container {
    max-width: 700px;
    margin: auto;
  }

  .header-img {
    height: 420px;
  }

  .detail-title h4 {
    font-size: 1.8rem;
  }

  .price-btn {
    font-size: 18px;
    padding: 16px;
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
           <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>Bookings</a>
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
            <a href="/ServiceHub/Signup_Login/login.php" class="fw-bold" style="text-decoration: none;color: #010913FF;">
                Signup or Login
            </a>
        <?php endif; ?>
                </li>
            <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>


<!-- Header Section -->
<div class="header-img" style="background-image: url('<?php echo '../s_pro/uploads2/' . htmlspecialchars($provider['image'] ?? 'default-service.jpg'); ?>')">
    <div class="header-buttons">
        <button class="btn rounded-circle" onclick="window.history.back()"><i class="bi bi-arrow-left"></i></button>
        <button class="btn rounded-circle"><i class="bi bi-heart"></i></button>
    </div>
    <div class="detail-title">
        <h4><?php echo htmlspecialchars($provider['businessname']); ?></h4>
    </div>
</div>

<!-- Main Content -->
<div class="container my-4 px-3">
    <div class="tag mb-2"><?php echo htmlspecialchars($service['service_name'] ?? 'Service'); ?></div>
    <h5 class="fw-bold"><?php echo htmlspecialchars($provider['businessname']); ?></h5>

    <div class="d-flex align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center text-muted">
            <i class="bi bi-geo-alt me-1"></i>
            <small><?php echo htmlspecialchars($provider['address']); ?></small>
        </div>
        <span class="text-muted">•</span>
        <!-- Not Dynamic Rating -->
        <div class="d-flex align-items-center text-muted">
            <i class="bi bi-star-fill text-warning me-1"></i>
            <small>4.8 (532)</small> <!-- Replace with actual rating if available -->
        </div>
    </div>

    <h6 class="fw-semibold">Description</h6>
    <p class="text-muted">
        <?php 
        $description = $provider['description'] ?? 'No description available';
        if (strlen($description) > 150) {
            echo htmlspecialchars(substr($description, 0, 150)) . '... ';
            echo '<a href="#" class="text-decoration-none text-primary" onclick="showFullDescription(this)">Read More</a>';
            echo '<span style="display:none">' . htmlspecialchars(substr($description, 150)) . '</span>';
        } else {
            echo htmlspecialchars($description);
        }
        ?>
    </p>

    <?php

        $res=mysqli_query($conn,"select * from subservice_price_map where subservice_id=$subservice_id");
        $row=mysqli_fetch_assoc($res);
    ?>
    <!-- Service Options -->
    <div class="tabs d-flex justify-content-left border-bottom mb-3">
       <p>Price: <span style="font-size: 1rem; font-weight: bold;"><?php echo $row['price']; ?></span></p>

    </div>

    

<form method ="POST" action="booking_process.php">

   <input type="hidden" name="provider_id" value="<?php echo $provider['provider_id']; ?>">
    <input type="hidden" name="service_id" value="<?php echo $provider['service_id']; ?>">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    <input type="hidden" name="subservice_id" value="<?php echo $subservice_id; ?>">
    <input type="hidden" name="amount" value="<?php  echo $row['price']; ?>">
   
    <input type="hidden" name="option" value="Standard">

    <!-- Contact/Select Button -->
    <div class="d-flex gap-2">
                    <a href="mailto:<?php echo htmlspecialchars($provider['email']); ?>" 
            class="btn flex-grow-1 fw-semibold d-flex align-items-center justify-content-center"
            style="border: 2px solid #ad67c8; color: #ad67c8; transition: all 0.3s ease;">
            <i class="bi bi-envelope me-2"></i>Contact
            </a>

        <button  type =" submit"  class="price-btn flex-grow-1" onclick="bookService()">
            Book Now
        </button>
    </div>
</div>
      </form>




<script>
function showFullDescription(element) {
    const hiddenText = element.nextElementSibling;
    element.style.display = 'none';
    hiddenText.style.display = 'inline';
}

function bookService() {
    // Get selected option
    const option = document.querySelector('.tabs button.active').textContent;
    
    // Redirect to booking page with provider and service info
    window.location.href = `booking.php?provider_id=<?php echo $provider_id; ?>&service_id=<?php echo $provider['service_id']; ?>&option=${option}`;
}

function selectOption(el, option) {
    document.querySelectorAll('.tabs button').forEach(btn => btn.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('option-detail').innerText = option + ' <?php echo addslashes($provider['businessname']); ?>';
    document.querySelector('.price-btn').innerText = 'Select ' + option + ' ($100)';
     document.getElementById('booking_option').value = option; // Set hidden input value
}


function validateBooking() {
    // Check if address exists in user profile
    fetch('check_address.php')
        .then(response => response.json())
        .then(data => {
            if (data.hasAddress) {
                // Address exists, submit the form
                document.querySelector('form').submit();
            } else {
                // Show popup to add address
                showAddressPopup();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking your address');
        });
}

function showAddressPopup() {
    // Create popup element
    const popup = document.createElement('div');
    popup.style.position = 'fixed';
    popup.style.top = '0';
    popup.style.left = '0';
    popup.style.width = '100%';
    popup.style.height = '100%';
    popup.style.backgroundColor = 'rgba(0,0,0,0.5)';
    popup.style.display = 'flex';
    popup.style.justifyContent = 'center';
    popup.style.alignItems = 'center';
    popup.style.zIndex = '1000';
    
    // Popup content
    popup.innerHTML = `
        <div style="background: white; padding: 20px; border-radius: 10px; max-width: 400px; text-align: center;">
            <h5>Address Required</h5>
            <p>Please add your address to your profile before booking.</p>
            <div style="margin-top: 20px;">
                <a href="profile.php" class="btn btn-primary">Go to Profile</a>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="btn btn-secondary" style="margin-left: 10px;">Cancel</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(popup);
}

// Update the bookService function to use validateBooking
function bookService() {
    event.preventDefault(); // Prevent form submission
    validateBooking();
}



</script>






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