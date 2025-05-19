<?php


session_start(); // Start the session

include_once "db_connect.php";

// Use session safely now
//$user_id = $_SESSION['user_id'] ?? null;
//if (!$user_id) {
//  header("Location:/ServiceHub/Signup_Login/login.php ");
//exit();
//}
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

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Maintain The  Side Bar  Functionality Java Script     -->
  <script src="SideBarFunction.js"></script>
  <!-- Bootstrap JS (for responsive behavior) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <style>
    .search-box-one {
      padding-top: 10px;
      padding-bottom: 10px;
    }

    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .search-box-two {
      position: relative;
      margin-bottom: 20px;

    }

    .search-box-two input.search-box {
      padding: 12px 20px 12px 40px;
      border: 2px solid #ad67c8;
      border-radius: 10px;
      font-size: 16px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .search-box-two input.search-box:focus {
      outline: none;
      border-color: #8d48aa;
      box-shadow: 0 0 0 0.15rem rgba(173, 103, 200, 0.25);
    }

    .search-box-two::before {
      content: "\f002";
      /* FontAwesome search icon */
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #ad67c8;
      font-size: 18px;
    }

    .btn-theme {
      background-color: #ad67c8;
      border-color: #ad67c8;
    }

    .btn-outline-theme {
      color: #ad67c8;
      border-color: #ad67c8;
    }

    .btn-outline-theme:hover {
      background-color: #ad67c8;
      color: white;
    }

    .bg-theme {
      background-color: #ad67c8 !important;
    }

    .text-theme {
      color: #ad67c8;
    }

    .search-box {
      border-radius: 10px;
      padding: 10px 15px;
    }

    .booking-card {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(173, 103, 200, 0.1);
    }

    .card-body {
      padding: 1rem;
    }

    .badge {
      font-size: 0.75rem;
      padding: 5px 10px;
      border-radius: 10px;
    }

    .filter-btn {
      border: 1px solid #ad67c8;
      color: #ad67c8;
    }

    .filter-btn.active {
      background-color: #ad67c8;
      color: white;
    }

    .card-custom {
      border: 1px solid #e0e0e0;
      border-radius: 15px;
      margin-bottom: 20px;
    }

    .status-btn {
      border-radius: 20px;
      padding: 2px 10px;
      font-size: 12px;
      font-weight: 500;
    }

    .status-ongoing {
      background-color: #ad67c8;
      color: white;
    }

    .status-cancelled {
      background-color: #fff0f0;
      color: #ff4b4b;
      border: 1px solid #ff4b4b;
    }

    .service-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 12px;
    }

    .search-bar {
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    @media (max-width: 768px) {
      .service-img {
        width: 80px;
        height: 80px;
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
        <img src="assets/images/logo.png" alt="Electricity">
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





  <!-- Replace the static card section with this dynamic code -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold">My Booking</h4>
      <i class="bi bi-calendar fs-4"></i>
    </div>

    <div class="search-box-one">
      <div class="search-box-two">
        <input type="text" class="form-control mb-3 search-box" placeholder="Search..." id="bookingSearch">
      </div>
    </div>


    <!-- Dynamic Filter Buttons -->
    <div class="d-flex flex-wrap gap-2 mb-4" id="serviceFilters">
      <button class="btn filter-btn active" data-filter="all">All Service</button>
      <?php
      if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Get distinct services from user's bookings
        $service_query = "SELECT DISTINCT s.service_id, s.service_name 
                             FROM booking b
                             JOIN service s ON b.service_id = s.service_id
                             WHERE b.user_id = ?";

        $stmt = mysqli_prepare($conn, $service_query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $service_result = mysqli_stmt_get_result($stmt);

        // Map service names to filter values
        $service_filters = [
          'Electrician' => 'electrician',
          'Cleaning' => 'cleaning',
          'AC Technician' => 'actechnician',
          'Interior Designer' => 'interiordesigner',
          'Car Mechanic' => 'carmechanic',
          'Carpenter' => 'carpenter',
          'Plumber' => 'plumber'
        ];

        $found_services = [];

        while ($service = mysqli_fetch_assoc($service_result)) {
          $service_name = $service['service_name'];
          $filter_value = $service_filters[$service_name] ?? strtolower(str_replace(' ', '', $service_name));

          if (!in_array($filter_value, $found_services)) {
            $found_services[] = $filter_value;
            echo '<button class="btn filter-btn" data-filter="' . $filter_value . '">' . $service_name . '</button>';
          }
        }
      }
      ?>
    </div>

    <?php
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];

      // Fetch bookings with service and provider details
      // Fetch bookings with service and provider details
      $query = "SELECT b.*, s.service_name, LOWER(REPLACE(s.service_name, ' ', '')) as service_filter, 
                     s.image as service_image, p.provider_name, p.businessname, p.address, p.image as provider_image
              FROM booking b
              JOIN service s ON b.service_id = s.service_id
              JOIN service_providers p ON b.provider_id = p.provider_id
              WHERE b.user_id = ?
              ORDER BY b.created_at DESC";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "i", $user_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        while ($booking = mysqli_fetch_assoc($result)) {
          // Determine status badge class and text
          $status_class = '';
          $status_text = ucfirst($booking['booking_status']);

          switch (strtolower($booking['booking_status'])) {
            case 'pending':
              $status_class = 'bg-warning';
              break;
            case 'accepted':
            case 'approved':
              $status_class = 'bg-primary';
              $status_text = 'Booked';
              break;
            case 'completed':
              $status_class = 'bg-success';
              break;
            case 'rejected':
            case 'cancelled':
              $status_class = 'bg-danger';
              break;
            default:
              $status_class = 'bg-secondary';
          }

          // Format booking time
          $booking_time = date('D, d M Y', strtotime($booking['booking_time']));

          // Determine image path
          $image_path = !empty($booking['provider_image']) ?
            '../s_pro/uploads2/' . $booking['provider_image'] : (!empty($booking['service_image']) ?
              'assets/images/services/' . $booking['service_image'] :
              'https://via.placeholder.com/150');
    ?>
          <div class="card booking-card mb-3"
            onclick="window.location.href='booking_status.php?booking_id=<?php echo $booking['booking_id']; ?>'"
            data-service="<?php echo strtolower(str_replace(' ', '', $booking['service_name'])); ?>"
            style="cursor: pointer;">
            <div class="row g-0">
              <div class="col-4">
                <img src="<?php echo $image_path; ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?php echo htmlspecialchars($booking['service_name']); ?>">
              </div>
              <?php
                      $id=$booking['subservice_id'];
                      $res=mysqli_query($conn,"select * from subservice where subservice_id=$id");
                      $row=mysqli_fetch_assoc($res);  
              ?>
              <div class="col-8">
                <div class="card-body">
                  <h6 class="card-title fw-bold"><?php echo htmlspecialchars($booking['businessname']); ?></h6>
                  <p class="card-text small"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($booking['address']); ?></p>
                  <p class="card-text small mb-1">Service: <?php echo htmlspecialchars($booking['service_name']); ?></p>
                  <p class="card-text small mb-1">Service Category: <?php echo htmlspecialchars($row['subservice_name']); ?></p>
                  <p class="card-text small">Date: <?php echo $booking_time; ?></p>
                  <p class="text-theme fw-bold mb-1">$<?php echo number_format($booking['amount'], 2); ?></p>
                  <span class="badge <?php echo $status_class; ?> text-white"><?php echo $status_text; ?></span>

                </div>
              </div>
            </div>
          </div>
    <?php
        }
      } else {
        echo '<div class="alert alert-info">No bookings found.</div>';
      }
    } else {
      echo '<div class="alert alert-warning">Please login to view your bookings.</div>';
    }
    ?>
  </div>

  <script>
    $(document).ready(function() {
      // Filter buttons
      $(document).on('click', '.filter-btn', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const filter = $(this).data('filter');
        if (filter === 'all') {
          $('.booking-card').show();
        } else {
          $('.booking-card').each(function() {
            const serviceType = $(this).data('service');
            $(this).toggle(serviceType.includes(filter));
          });
        }
      });

      // Search functionality
      $('#bookingSearch').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('.booking-card').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });
    });
  </script>

  <footer class="footer">
    <!-- Your existing footer code here -->
  </footer>

</body>

</html>