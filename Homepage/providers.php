
<!-- providers.php -->
 <!-- This Page Is Not Under The Admin PAnel -->
<?php include 'db_connect.php'; ?>
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
                <a href="profile.php" class="d-inline-block position-relative">
                    <img 
                    src="assets/images/logo2.png" 
                    alt="User profile" 
                    class="img-fluid rounded-circle shadow profile-img-animate"
                    style="width: 80px; height: 80px; object-fit: cover;"
                    />
                </a>
                </li>
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
            <img src="assets/images/logo.png" alt="Service Hub Icon ">
        
            </li>
            <li class="hideOnMobile"><a href="home.php">Home</a></li>
            <li class="hideOnMobile"><a href="#">Service</a></li>
            <li class="hideOnMobile"><a href="cart.php">Cart</a></li>
            <li class="hideOnMobile"><a href="#">About</a></li>
            <li class="hideOnMobile"><a href="#">Contact</a></li>
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

    // Validate and safely query for the service
    $service_query = $conn->query("SELECT service_name FROM service WHERE service_id = $service_id");

    if (!$service_query) {
        echo "<h4 class='text-center mt-5 text-danger'>Database query error: " . $conn->error . "</h4>";
        exit;
    }

    $service = $service_query->fetch_assoc();

    if (!$service) {
        echo "<h4 class='text-center mt-5 text-danger'>Service not found.</h4>";
        exit;
    }

    echo "<h2 class='text-center mt-5'>Providers for: " . htmlspecialchars($service['service_name']) . "</h2>";

    // Fetch service providers
    $provider_result = $conn->query("SELECT * FROM service_providers WHERE service_id = $service_id AND approved_action = 'approved'");

    if (!$provider_result) {
        echo "<p class='text-center text-danger mt-4'>Error fetching providers: " . $conn->error . "</p>";
        exit;
    }

    if ($provider_result->num_rows > 0) {
        
        echo "<div class='container'><div class='row mt-4 g-4'>";
        while ($row = $provider_result->fetch_assoc()) {
          $image_data = '../Signup_Login/uploads/' . htmlspecialchars(trim($row['identityimage']));
          echo '<pre>' . $row['identityimage'] . '</pre>';
            echo '
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow border-0 rounded-4">
                    <img src="' . $image_data . '" 
                         class="card-img-top rounded-top-4" 
                         alt="' . htmlspecialchars($row['provider_name']) . '" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-bold">' . htmlspecialchars($row['provider_name']) . '</h5>
                            <p class="card-text"><strong>Business:</strong> ' . htmlspecialchars($row['businessname']) . '</p>
                            <p class="card-text"><i class="fas fa-envelope"></i> ' . htmlspecialchars($row['email']) . '</p>
                            <p class="card-text"><i class="fas fa-phone"></i> ' . htmlspecialchars($row['phone']) . '</p>
                        </div>
                        <a href="booking.php" class="btn btn-primary mt-3 w-100">Book For Service </a>
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






</body>
</html>
