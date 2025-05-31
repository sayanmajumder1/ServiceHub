<?php
if (!isset($_SESSION['user_id'])) {
  header("Location:/ServiceHub/Signup_Login/login.php");
  exit();
}
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

  if (
    isset($_POST['startDate']) && !empty($_POST['startDate']) &&
    isset($_POST['endDate']) && !empty($_POST['endDate'])
  ) {
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
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="hideScrollbar.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#AD46FF',
            secondary: '#9820f7',
            accent: '#a78bfa',
            dark: '#1e293b',
            light: '#f8fafc'
          },
          animation: {
            'fade-in': 'fadeIn 0.6s ease-in-out',
          },
          keyframes: {
            fadeIn: {
              '0%': {
                opacity: '0',
                transform: 'translateY(-10px)'
              },
              '100%': {
                opacity: '1',
                transform: 'translateY(0)'
              },
            }
          }
        }
      }
    }
  </script>

  <style type="text/tailwindcss">
    @layer components {
      .filter-btn {
        @apply border border-primary/20 text-primary px-4 py-2 rounded-lg transition-all hover:bg-primary/10;
      }
      .filter-btn.active {
        @apply bg-primary text-white border-primary hover:bg-primary;
      }
      .btn-custom {
        @apply bg-gradient-to-r from-primary to-secondary text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all;
      }
      .status-badge {
        @apply text-xs px-3 py-1 rounded-full font-medium;
      }
      .card-hover {
        @apply transition-all hover:shadow-lg hover:-translate-y-0.5;
      }
      .section-title {
        @apply text-2xl font-bold text-dark mb-1 relative pb-2;
      }
      .section-title:after {
        @apply content-[''] absolute bottom-0 left-0 w-16 h-1 bg-gradient-to-r from-primary to-secondary rounded-full;
      }
    }
  </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
  <div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header Section -->
    <div class="text-center mb-8 animate-fade-in mt-20">
      <h1 class="section-title inline-block">My Bookings</h1>
      <p class="text-gray-500 mt-2">View and manage your service appointments</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
      <div id="calendar-container" class="<?php echo $date_filter_applied ? 'show' : '' ?>">
        <form method="POST" action="">
          <h3 class="text-lg font-semibold text-dark mb-4 flex items-center gap-2">
            <i class="bi bi-funnel text-primary"></i>
            Filter Options
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Single Date Picker -->
            <div>
              <label for="bookingDate" class="block text-sm font-medium text-gray-700 mb-1">Specific Date</label>
              <div class="relative">
                <input type="date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  id="bookingDate" name="bookingDate" value="<?php echo htmlspecialchars($date_filter) ?>">
              </div>
            </div>

            <!-- Date Range Fields -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
              <div id="dateRangeFields" class="<?php echo (!empty($start_date) ? 'block' : 'hidden') ?> space-y-2">
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <input type="date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary"
                      id="startDate" name="startDate" value="<?php echo htmlspecialchars($start_date) ?>">
                  </div>
                  <div>
                    <input type="date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary"
                      id="endDate" name="endDate" value="<?php echo htmlspecialchars($end_date) ?>">
                  </div>
                </div>
              </div>
              <button type="button" class="text-primary text-sm font-medium mt-1 flex items-center gap-1" onclick="toggleDateRange()">
                <i class="bi bi-calendar-range"></i>
                <span><?php echo (!empty($start_date)) ? 'Hide range' : 'Select date range' ?></span>
              </button>
            </div>
          </div>

          <!-- Buttons -->
          <div class="flex flex-wrap gap-3 pt-5">
            <button type="submit" class="btn-custom flex-1 md:flex-none">
              <i class="bi bi-funnel-fill mr-2"></i> Apply Filters
            </button>
            <button type="button" class="px-5 py-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all flex-1 md:flex-none"
              onclick="resetDateFilter()">
              <i class="bi bi-x-circle mr-2"></i> Clear All
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Service Filters -->
    <div class="flex flex-wrap gap-3 mb-6" id="serviceFilters">
      <button class="filter-btn active" data-filter="all">
        <i class="bi bi-grid-fill mr-2"></i> All Services
      </button>
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
            echo '<button class="filter-btn" data-filter="' . $filter_value . '">' . $service_name . '</button>';
          }
        }
      }
      ?>
    </div>

    <!-- Bookings List -->
    <div class="space-y-4">
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
                $status_class = 'bg-amber-100 text-amber-800';
                break;
              case 'accepted':
              case 'approved':
                $status_class = 'bg-blue-100 text-blue-800';
                $status_text = 'Confirmed';
                break;
              case 'completed':
                $status_class = 'bg-green-100 text-green-800';
                $review_button = true;
                break;
              case 'rejected':
              case 'cancelled':
                $status_class = 'bg-red-100 text-red-800';
                break;
              default:
                $status_class = 'bg-gray-100 text-gray-800';
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
            <div class="card bg-white rounded-xl shadow-md overflow-hidden card-hover"
              onclick="window.location.href='booking_status.php?booking_id=<?php echo $booking['booking_id']; ?>'"
              data-service="<?php echo strtolower(str_replace(' ', '', $booking['service_name'])); ?>">
              <div class="flex flex-col md:flex-row">
                <!-- Service Image -->
                <div class="w-full md:w-1/4 h-48 md:h-auto">
                  <img src="<?php echo $image_path; ?>" class="w-full h-full object-cover" alt="<?php echo htmlspecialchars($booking['service_name']); ?>">
                </div>

                <!-- Booking Details -->
                <div class="w-full md:w-3/4 p-5">
                  <div class="flex justify-between items-start">
                    <div>
                      <h3 class="text-xl font-bold text-dark"><?php echo htmlspecialchars($booking['businessname']); ?></h3>
                      <p class="text-gray-500 text-sm flex items-center gap-1 mt-1">
                        <i class="bi bi-geo-alt text-primary"></i>
                        <?php echo htmlspecialchars($booking['address']); ?>
                      </p>
                    </div>
                    <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                      <p class="text-sm text-gray-600"><span class="font-medium text-dark">Service:</span> <?php echo htmlspecialchars($booking['service_name']); ?></p>
                      <p class="text-sm text-gray-600"><span class="font-medium text-dark">Category:</span> <?php echo htmlspecialchars($row['subservice_name']); ?></p>
                    </div>
                    <div>
                      <p class="text-sm text-gray-600"><span class="font-medium text-dark">Date:</span> <?php echo $booking_time; ?></p>
                      <p class="text-primary font-bold text-lg mt-1">$<?php echo number_format($booking['amount'], 2); ?></p>
                    </div>
                  </div>

                  <?php if ($review_button): ?>
                    <div class="mt-4 flex justify-end">
                      <button class="btn-custom text-sm px-4 py-1.5" onclick="event.stopPropagation(); window.location.href='review.php?booking_id=<?php echo $booking['booking_id']; ?>'">
                        <i class="bi bi-star-fill mr-1"></i> Leave Review
                      </button>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
      <?php
          }
        } else {
          echo '<div class="bg-blue-50 text-blue-800 p-6 rounded-xl text-center">
                  <i class="bi bi-calendar-x text-4xl mb-3 text-blue-400"></i>
                  <h3 class="text-lg font-medium">No bookings found</h3>
                  <p class="text-sm mt-1">' . ($date_filter_applied ? 'Try adjusting your date filters' : 'You haven\'t made any bookings yet') . '</p>
                </div>';
        }
      } else {
        echo '<div class="bg-amber-50 text-amber-800 p-6 rounded-xl text-center">
                <i class="bi bi-exclamation-triangle text-4xl mb-3 text-amber-400"></i>
                <h3 class="text-lg font-medium">Authentication Required</h3>
                <p class="text-sm mt-1">Please login to view your bookings</p>
                <a href="/ServiceHub/Signup_Login/login.php" class="btn-custom inline-block mt-3 px-4 py-2 text-sm">
                  <i class="bi bi-box-arrow-in-right mr-1"></i> Login Now
                </a>
              </div>';
      }
      ?>
    </div>
  </div>

  <script>
    function toggleDateRange() {
      const dateRangeFields = document.getElementById('dateRangeFields');
      const toggleBtn = document.querySelector('[onclick="toggleDateRange()"] span');

      dateRangeFields.classList.toggle('hidden');
      dateRangeFields.classList.toggle('block');

      if (dateRangeFields.classList.contains('hidden')) {
        toggleBtn.textContent = 'Select date range';
      } else {
        toggleBtn.textContent = 'Hide range';
      }
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
        document.getElementById('dateRangeFields').classList.remove('hidden');
        document.querySelector('[onclick="toggleDateRange()"] span').textContent = 'Hide range';
      }

      // Filter buttons
      $(document).on('click', '.filter-btn', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const filter = $(this).data('filter');
        if (filter === 'all') {
          $('.card').show();
        } else {
          $('.card').each(function() {
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