<<<<<<< HEAD:LSF/Homepage/home.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Service Finder</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
     <!-- Maintain The  Side Bar  Functionality Java Script    -->
     <script src="SideBarFunction.js"> </script>

   <!-- Bootstrap JS (for responsive behavior) -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<body>


    <!-- Custom Nav Bar -->
    <nav>
                <!-- Side Bar Section-->
    <ul class="sidebar" id="sidebar">
        <li onclick="hideSidebar()">
           <a href="#"><i class="fa-solid fa-times"></i></a>
        </li>
       <li>
          <a href="#"><i class="fas fa-home"></i> Home</a>
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
            <span>Service Hub</span>
            </li>
            <li class="hideOnMobile"><a href="service.php">Service</a></li>
            <li class="hideOnMobile"><a href="cart.php">Cart</a></li>
            <li class="hideOnMobile"><a href="#">About</a></li>
            <li class="hideOnMobile"><a href="#">Contact</a></li>
            
            <li class="menu-icon" onclick="showSidebar()"><a href="#"><i class="fa-solid fa-bars"></i></a></li>
        </ul>
    </nav>







    <!-- Hero Section (Main Heading & Search Bar) -->
<!--pt-5 padding-top:48px-->
    <section class="text-center mt-5 pt-5"> <!-- Adjusted Margin to Avoid Overlapping with Navbar -->
        <h1>Find Home 
            <span class="text-primary-custom">Service/Repair</span> 
            Near You</h1>
        <p class="text-muted">Explore Best Home Service & Repair near you</p>
    
        <!-- Search Bar -->
        <div class="search-bar d-flex justify-content-center mt-3">
            <input type="text" class="form-control w-50   search-input" placeholder="Search">
            <!--ms-2	Medium left margin (8px)-->
            <button class="btn btn-primary ms-2"><i class="fas fa-search"></i></button>
        </div>
    </section>


            <!-- Title -->
            <div class ="container mt-5 pt-5 ">
                        <h3 class="section-title-three">Services Category</h3>
                        </div>

            <!-- Service Categories Section -->
            <div class="container mt-5">
                <div class="row text-center">
                    <?php
                    include 'db_connect.php'; // adjust path if needed
                    $sql = "SELECT * FROM service";
                    // Added Query To Select the Categories From Service table 
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $image_data ='../Admin/img/' . $row['image']; 
                            echo '
                            <div class="col-4 col-md-4 col-lg-4 mb-3">
                                <a href="providers.php?id=' . $row['s_id'] . '" class="text-decoration-none text-dark">
                                    <div class="service-box">
                                        <img src="' .trim( $image_data) . '" alt="' . htmlspecialchars($row['s_name']) . '" class="img-fluid">
                                        
                                        <p>' . htmlspecialchars($row['s_name']) . '</p>
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



    <!-- Popular Business Section -->
    <section class="container mt-5">
        <h3 class="section-title">Popular Business</h3>
        <div class="row">
            <?php
            // Array with service details
            $services = [
                ["House Cleaning", "Jenny Wilson", "New York", "cleaning"],
                ["Washing Clothes", "Emma Potter", "New York", "cleaning"],
                ["House Repairing", "Ronaldo Epric", "New York", "repair"],
                ["Bathroom Cleaning", "Henny Wilson", "NC", "cleaning"],
                ["Floor Cleaning", "Harry Will", "NC", "cleaning"],
                ["Shifting XY Co.", "Jhon Carry", "NC", "shifting"]
            ];

            // Loop to Display Services as Cards
            foreach ($services as $service) {
                echo '
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <div class="card custom-shadow">
                        <div class="card-body">
                            <span class="badge text-uppercase">'.$service[3].'</span>
                            <h5 class="mt-2">'.$service[0].'</h5>
                            <p class="text-muted">'.$service[1].', '.$service[2].'</p>
                            <a href="#" class="btn btn-primary w-100">Book Now</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </section>

 





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

