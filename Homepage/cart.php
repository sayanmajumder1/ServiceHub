<?php
include "navbar.php";
// Handle date filter submission
$date_filter = '';
$start_date = '';
$end_date = '';
$date_filter_applied = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['bookingDate']) && !empty($_POST['bookingDate'])) {
        $date_filter = $_POST['bookingDate'];
        $date_filter_applied = true;
    }
    
    if (isset($_POST['startDate']) && !empty($_POST['startDate']) && 
        isset($_POST['endDate']) && !empty($_POST['endDate'])) {
        $start_date = $_POST['startDate'];
        $end_date = $_POST['endDate'];
        $date_filter_applied = true;
    }
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
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <style>
   
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
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

    .btn-custom {
  background-color: #ad67c8;
  color: white;
  border-color: #ad67c8;
    }

.btn-custom:hover {
  background-color: #9c56b7;
  border-color: #9c56b7;
}
.calendar-container {
  max-width: 600px;
  margin: auto;
  padding-bottom: 20px ;
}

.btn-custom {
  background-color: #ad67c8;
  color: #fff;
  border-radius: 6px;
  padding: 10px 20px;
}

.btn-custom:hover {
  background-color: #ad67c8;
  color: white;
}






.date-range-toggle {
  font-size: 0.95rem;
}

.date-range-fields {
  display: none;
}

.date-range-fields.active {
  display: block;
}
.custom-heading {
  color: #ad67c8;
  display: inline-block;
  position: relative;
}

.custom-heading::after {
  content: '';
  display: block;
  margin: 6px auto 0;
  width: 50%;
  height: 3px;
  background-color: #ad67c8;
  border-radius: 2px;
}

/* Fade-in animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Apply animation to the header */
.animate-fade-in {
  animation: fadeIn 0.6s ease-in-out;
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




  <!-- Replace the static card section with this dynamic code -->
  <div class="container py-4">
   <!-- Booking Header Section -->
<div class="text-center mb-4 animate-fade-in">
  <h4 class="fw-bold custom-heading">My Bookings</h4>
</div>



<!-- Calendar Container -->
<div id="calendar-container" class="calendar-container <?php echo $date_filter_applied ? 'show' : '' ?>">
  <form method="POST" action="" class="p-4 border rounded shadow-sm bg-white">
    <h5 class="mb-4">📅 Filter by Date</h5>

    <!-- Single Date Picker -->
    <div class="mb-3">
      <label for="bookingDate" class="form-label">Select a Specific Date</label>
      <input type="date" class="form-control" id="bookingDate" name="bookingDate"
             value="<?php echo htmlspecialchars($date_filter) ?>">
    </div>

    <!-- Date Range Toggle -->
    <div class="mb-3">
      <span class="date-range-toggle text-primary fw-semibold cursor-pointer" onclick="toggleDateRange()" style="cursor:pointer;">
        <i class="bi bi-calendar-range me-1"></i> Select Date Range
      </span>

      <!-- Date Range Fields -->
      <div id="dateRangeFields" class="date-range-fields mt-3">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="startDate"
                   value="<?php echo htmlspecialchars($start_date) ?>">
          </div>
          <div class="col-md-6">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate"
                   value="<?php echo htmlspecialchars($end_date) ?>">
          </div>
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2 pt-3 pb-4">
      <button type="submit" class="btn btn-custom">Apply Filter</button>
      <button type="button" class="btn btn-outline-secondary" onclick="resetDateFilter()">Clear Filter</button>
    </div>
  </form>
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

   
      // Base query
      $query = "SELECT b.*, s.service_name, LOWER(REPLACE(s.service_name, ' ', '')) as service_filter, 
                       s.image as service_image, p.provider_name, p.businessname, p.address, p.image as provider_image
                FROM booking b
                JOIN service s ON b.service_id = s.service_id
                JOIN service_providers p ON b.provider_id = p.provider_id
                WHERE b.user_id = ?";

      // Add date filtering conditions
      if (!empty($date_filter)) {
        $query .= " AND DATE(b.booking_time) = ?";
      } elseif (!empty($start_date) && !empty($end_date)) {
        $query .= " AND DATE(b.booking_time) BETWEEN ? AND ?";
      }
      
      $query .= " ORDER BY b.created_at DESC";
      
      $stmt = mysqli_prepare($conn, $query);
      
      // Bind parameters based on date filtering
      if (!empty($date_filter)) {
        mysqli_stmt_bind_param($stmt, "is", $user_id, $date_filter);
      } elseif (!empty($start_date) && !empty($end_date)) {
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $start_date, $end_date);
      } else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
      }
      
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        while ($booking = mysqli_fetch_assoc($result)) {
          // Determine status badge class and text
          $status_class = '';
          $status_text = ucfirst($booking['booking_status']);
          $review_button = false;

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
              $review_button = true;
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
              
          $id = $booking['subservice_id'];
          $res = mysqli_query($conn, "select * from subservice where subservice_id=$id");
          $row = mysqli_fetch_assoc($res);  
    ?>
          <div class="card booking-card mb-3"
            onclick="window.location.href='booking_status.php?booking_id=<?php echo $booking['booking_id']; ?>'"
            data-service="<?php echo strtolower(str_replace(' ', '', $booking['service_name'])); ?>"
            style="cursor: pointer;">
            <div class="row g-0">
              <div class="col-4">
                <img src="<?php echo $image_path; ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?php echo htmlspecialchars($booking['service_name']); ?>">
              </div>
              <div class="col-8">
                <div class="card-body">
                  <h6 class="card-title fw-bold"><?php echo htmlspecialchars($booking['businessname']); ?></h6>
                  <p class="card-text small"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($booking['address']); ?></p>
                  <p class="card-text small mb-1">Service: <?php echo htmlspecialchars($booking['service_name']); ?></p>
                  <p class="card-text small mb-1">Service Category: <?php echo htmlspecialchars($row['subservice_name']); ?></p>
                  <p class="card-text small">Date: <?php echo $booking_time; ?></p>
                  <p class="text-theme fw-bold mb-1">$<?php echo number_format($booking['amount'], 2); ?></p>
                  <span class="badge <?php echo $status_class; ?> text-white"><?php echo $status_text; ?></span>
                  <?php if ($review_button): ?>
                    <button class="btn btn-sm btn-custom ms-2" onclick="event.stopPropagation(); window.location.href='review.php?booking_id=<?php echo $booking['booking_id']; ?>'">Review</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
    <?php
        }
      } else {
        echo '<div class="alert alert-info">No bookings found' . ($date_filter_applied ? ' for the selected date range' : '') . '.</div>';
      }
    } else {
      echo '<div class="alert alert-warning">Please login to view your bookings.</div>';
    }
    ?>
  </div>

  <script>
    function toggleCalendar() {
      document.getElementById('calendar-container').classList.toggle('show');
    }
    
    function toggleDateRange() {
      document.getElementById('dateRangeFields').style.display = 
        document.getElementById('dateRangeFields').style.display === 'block' ? 'none' : 'block';
    }
    
    function resetDateFilter() {
      document.getElementById('bookingDate').value = '';
      document.getElementById('startDate').value = '';
      document.getElementById('endDate').value = '';
      document.querySelector('form').submit();
    }

    $(document).ready(function() {
      // Initialize date range fields if values exist
      if ("<?php echo $start_date ?>" || "<?php echo $end_date ?>") {
        document.getElementById('dateRangeFields').style.display = 'block';
      }

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
    });
  </script>

  <?php
  include_once "footer.php"; 
  ?>
</body>
</html>
