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

<?php
include "navbar.php"
?>

<div class="container mt-5 pt-5 ">
    <?php
    if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id']))  {
        echo "<h4 class='text-center mt-5 text-danger'>Invalid service selected.</h4>";
        exit;
    }

    $service_id = (int)$_GET['service_id'];
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

   
       


    // Validate and safely query for the service
    $service_query = $conn->query("SELECT * FROM service WHERE service_id = '".$_GET['service_id']."'");

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
         /* Added custom spacing for cards */
    .provider-card {
        margin-bottom: 2.5rem; /* Space between card rows */
    }
    .card-body {
        padding-bottom: 1.5rem; /* Extra padding at bottom of card */
    }
    </style>

    <div class='container text-center mt-5'>
        <h2 class='fw-bold animated-heading'>
            Providers For: " . htmlspecialchars($service['service_name']) . "
        </h2>
    </div>";
    // Fetch service providers
    $provider_result = $conn->query("select * from service_providers where service_id='$service_id'");

    if ($provider_result === false) {
        echo "<p class='text-center text-danger mt-4'>Error fetching providers: " . htmlspecialchars($conn->error) . "</p>";
        exit;
    }

    if ($provider_result->num_rows > 0) {
        echo "<div class='container '   ><div class='row mt-4 g-4 '>";
        while ($row = $provider_result->fetch_assoc()) {
            $image_data = '../s_pro/uploads2/' . htmlspecialchars(trim($row['image']));
            $provider_id = $row['provider_id'];
            
            // Check if this user has any bookings with this provider
        $booking_check = $conn->query("SELECT * FROM booking WHERE user_id = $user_id AND provider_id = $provider_id ORDER BY created_at DESC LIMIT 1");

            // Initialize default values
            $has_booking = false;
            $button_class = 'btn-primary';
            $button_text = 'Book For Service';
            $base_booking_url = 'booking.php?provider_id=' . urlencode($row['provider_id']) ; 
        
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
            </div>
            ';
        }
        echo "</div></div>";
    } else {
        echo "<p class='text-center mt-4'>No providers available for this service.</p>";
    }
    ?>
</div>

<?php
include "footer.php"
?>
</body>
</html>
