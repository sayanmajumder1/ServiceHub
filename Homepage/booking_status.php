<?php
session_start();
include_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location:/ServiceHub/Signup_Login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user details from DB
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
$image = $user['image'] ?? '';
$displayImage = !empty($image) ? $image : 'default.jpg';




// Get booking ID from URL
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : (isset($_GET['id']) ? $_GET['id'] : null);

if (!is_numeric($booking_id)) {
    die("Invalid booking ID");
}
$booking_id = (int)$booking_id;


// Fetch booking details
$booking_query = $conn->prepare("SELECT b.*, s.service_name, p.provider_name, p.businessname, p.image as provider_image, p.email as provider_email, p.phone as provider_phone, p.address as provider_address 
                                FROM booking b
                                JOIN service s ON b.service_id = s.service_id
                                JOIN service_providers p ON b.provider_id = p.provider_id
                                WHERE b.booking_id = ? AND b.user_id = ?");
$booking_query->bind_param("ii", $booking_id, $user_id);
$booking_query->execute();
$booking_result = $booking_query->get_result();

if ($booking_result->num_rows === 0) {
    die("Booking not found or you don't have permission to view it");
}

$booking = $booking_result->fetch_assoc();

// Determine timeline statuses
$timeline_statuses = [
    'ordered' => [
        'icon' => 'bi-cart',
        'title' => 'Service Ordered',
        'description' => $booking['businessname'],
        'active' => true
    ],
    'payment' => [
        'icon' => 'bi-credit-card-2-front',
        'title' => 'Payment Done',
        'description' => 'Paid via ' . $booking['payment_method'] . ' - ' . date('M j, H:i', strtotime($booking['created_at'])),
        'active' => $booking['payment_status'] === 'completed'
    ],
    'working' => [
        'icon' => 'bi-briefcase',
        'title' => in_array(strtolower($booking['booking_status']), ['rejected', 'cancelled']) ? 'Service Not Started' : 'Being worked on',
        'description' => 'With ' . $booking['provider_name'],
        'active' => in_array(strtolower($booking['booking_status']), ['accepted', 'approved', 'pending', 'in progress'])
    ],
    'completed' => [
        'icon' => 'bi-file-earmark-check',
        'title' => ucfirst($booking['booking_status']),
        'description' => $booking['service_name'] . ' service has been ' . $booking['booking_status'],
        'active' => in_array(strtolower($booking['booking_status']), ['completed', 'rejected', 'cancelled'])
    ]
];

// Set status colors
$status_colors = [
    'pending' => 'warning',
    'accepted' => 'primary',
    'approved' => 'success',
    'completed' => 'success',
    'rejected' => 'danger',
    'cancelled' => 'secondary'
];

$status_color = $status_colors[strtolower($booking['booking_status'])] ?? 'primary';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booking Detail</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- SideBar Functionality JS -->
  <script src="SideBarFunction.js"></script>
  <!-- Bootstrap JS (for responsive behavior) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .timeline {
      border-left: 2px solid #dee2e6;
      padding-left: 1rem;
      margin-left: 0.5rem;
    }
    .timeline-item {
      position: relative;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: flex-start;
    }
    .timeline-icon {
      width: 2rem;
      height: 2rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      margin-top: 0.3rem;
    }
    .timeline-content {
      flex: 1;
    }
    @keyframes fadeInScale {
      0% { opacity: 0; transform: translateY(-8px) scale(0.98); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    .booking-title {
      color: #ad67c8;
      padding-bottom: 12px;
      font-weight: 700;
      margin: 0 auto 1.5rem;
      text-align: center;
      animation: fadeInScale 0.8s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
      display: inline-block;
      position: relative;
      font-size: 1.5rem;
      letter-spacing: 0.5px;
    }
    .booking-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, rgba(173,103,200,0.2), #ad67c8, rgba(173,103,200,0.2));
      transform: scaleX(0);
      transform-origin: center;
      transition: transform 0.4s cubic-bezier(0.65, 0, 0.35, 1);
      border-radius: 2px;
    }
    .booking-title:hover::after {
      transform: scaleX(1);
    }
    .title-container {
      text-align: center;
      padding: 0.5rem 0;
      overflow: hidden;
    }
    .status-badge {
      background-color: #ad67c8;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.875rem;
      font-weight: 500;
    }
  </style>
</head>
<body>

<!-- Custom Nav Bar -->
<nav>
  <!-- Side Bar Section-->
  <ul class="sidebar" id="sidebar">
    <li onclick="hideSidebar()" class="navbar-profile-two d-flex align-items-center padding-top-bottom" onclick="showSidebar()" style="height: 100px;">
      <a href="#"><i class="fa-solid fa-times"></i></a>
      <a href="profile.php" class="d-inline-block position-relative">
        <img 
          src="assets/images/<?php echo $displayImage; ?>"
          alt="User profile" 
          class="img-fluid rounded-circle shadow profile-img-animate"
          style="width: 80px; height: 80px; object-fit: cover;"
        />
      </a>
    </li>
    <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="service.php"><i class="fas fa-concierge-bell"></i>Service</a></li>
    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>Cart</a></li>
    <li><a href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
    <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
  </ul>
  
  <!-- Nav Bar Section-->      
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

<div class="container py-4">
  <!-- Back Button -->
  <div class="mb-3">
    <a href="javascript:history.back()" class="btn btn-light rounded-circle shadow-sm">
      <i class="bi bi-arrow-left"></i>
    </a>
  </div>
  <!-- Booking Title -->
  <div class="title-container">
    <h4 class="booking-title">Booking Details <span class="status-badge" style="background-color: <?php echo $status_color === 'primary' ? '#ad67c8' : ''; ?>"><?php echo ucfirst($booking['booking_status']); ?></span></h4>
    <p class="text-muted">Booking #<?php echo $booking['booking_no']; ?></p>
  </div>

  <!-- Booking Card -->
  <div class="card shadow-sm rounded-4 overflow-hidden">
    <!-- Provider Image -->
    <div class="rounded-4 overflow-hidden shadow-sm" style="max-height: 450px;">
      <img 
        src="../s_pro/uploads2/<?php echo htmlspecialchars($booking['provider_image']); ?>"
        alt="<?php echo htmlspecialchars($booking['provider_name']); ?>"
        class="img-fluid w-100"
        style="object-fit: cover; height: 100%;"
      >
    </div>
    <div class="card-body">
      <!-- Title -->
      <h5 class="fw-bold"><?php echo htmlspecialchars($booking['service_name']); ?></h5>

      <!-- Location and Rating -->
      <p class="text-muted d-flex flex-wrap align-items-center">
        <i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars($booking['provider_address']); ?>
        <span class="ms-auto text-warning d-flex align-items-center">
          <i class="bi bi-star-fill me-1"></i> 4.4 (532)
        </span>
      </p>

      <!-- Tabs -->
      <ul class="nav nav-tabs mt-3" id="bookingTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="todo-tab" data-bs-toggle="tab" data-bs-target="#todo" type="button" role="tab">Service Details</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="worker-tab" data-bs-toggle="tab" data-bs-target="#worker" type="button" role="tab">Provider Info</button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content mt-3" id="bookingTabsContent">
        <!-- Service Todo Tab -->
        <div class="tab-pane fade show active" id="todo" role="tabpanel">
          <div class="row text-center text-md-start">
            <div class="col-12 col-md-6 mb-3">
              <p class="text-muted mb-1">Booking Time</p>
              <h6 class="fw-semibold"><?php echo date('F j, Y', strtotime($booking['booking_time'])); ?></h6>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <p class="text-muted mb-1">Amount</p>
              <h6 class="fw-semibold">$<?php echo number_format($booking['amount'], 2); ?></h6>
            </div>
            <?php if (!empty($booking['reason'])): ?>
            <div class="col-12 mb-3">
              <p class="text-muted mb-1">Reason</p>
              <h6 class="fw-semibold"><?php echo htmlspecialchars($booking['reason']); ?></h6>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Timeline -->
          <div class="timeline mt-4">
            <?php foreach ($timeline_statuses as $status): ?>
              <div class="timeline-item <?php echo $status['active'] ? 'active' : ''; ?>">
                <div class="timeline-icon bg-<?php echo $status['active'] ? $status_color : 'secondary'; ?>">
                  <i class="bi <?php echo $status['icon']; ?> text-white"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="fw-bold mb-0"><?php echo $status['title']; ?></h6>
                  <small class="text-muted"><?php echo $status['description']; ?></small>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Worker Tab -->
        <div class="tab-pane fade" id="worker" role="tabpanel">
          <div class="d-flex align-items-center mt-3">
            <img 
              src="../s_pro/uploads2/<?php echo htmlspecialchars($booking['provider_image']); ?>"
              alt="<?php echo htmlspecialchars($booking['provider_name']); ?>"
              class="rounded-circle me-3"
              style="width: 80px; height: 80px; object-fit: cover;"
            >
            <div>
              <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($booking['provider_name']); ?></h5>
              <p class="text-muted mb-1"><?php echo htmlspecialchars($booking['businessname']); ?></p>
            </div>
          </div>
          
          <div class="mt-4">
            <p><i class="bi bi-envelope me-2"></i> <?php echo htmlspecialchars($booking['provider_email']); ?></p>
            <p><i class="bi bi-telephone me-2"></i> <?php echo htmlspecialchars($booking['provider_phone']); ?></p>
            <p><i class="bi bi-geo-alt me-2"></i> <?php echo htmlspecialchars($booking['provider_address']); ?></p>
          </div>
          
          <div class="mt-3">
            <button class="btn btn-outline-primary rounded-pill me-2">
              <i class="bi bi-chat-left-text me-1"></i> Message
            </button>
            <button class="btn btn-outline-secondary rounded-pill">
              <i class="bi bi-telephone me-1"></i> Call
            </button>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="mt-4">
        <?php if (strtolower($booking['booking_status']) === 'pending'): ?>
          <button class="btn btn-danger rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#cancelModal">
            Cancel Booking
          </button>
        <?php elseif (strtolower($booking['booking_status']) === 'completed'): ?>
          <button class="btn btn-primary rounded-pill w-100">
            <i class="bi bi-receipt me-1"></i> View Receipt
          </button>
        <?php else: ?>
          <button class="btn btn-primary rounded-pill w-100" disabled>
            <?php echo ucfirst($booking['booking_status']); ?>
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to cancel this booking?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="confirmCancel">Confirm Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
// Cancel booking functionality
document.getElementById('confirmCancel')?.addEventListener('click', function() {
  fetch('cancel_booking.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      booking_id: <?php echo $booking_id; ?>
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      window.location.reload();
    } else {
      alert('Error: ' + (data.message || 'Failed to cancel booking'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while canceling the booking');
  });
});
</script>

</body>
</html>