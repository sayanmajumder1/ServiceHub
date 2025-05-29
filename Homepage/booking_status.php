<?php
include "navbar.php";

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

// Status colors mapping
$status_colors = [
  'pending' => 'bg-amber-100 text-amber-800',
  'accepted' => 'bg-blue-100 text-blue-800',
  'approved' => 'bg-purple-100 text-purple-800',
  'completed' => 'bg-green-100 text-green-800',
  'rejected' => 'bg-red-100 text-red-800',
  'cancelled' => 'bg-gray-100 text-gray-800'
];

$status_color = $status_colors[strtolower($booking['booking_status'])] ?? 'bg-purple-100 text-purple-800';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booking Detail</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="hideScrollbar.css">
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#8b5cf6',
            secondary: '#7c3aed',
            accent: '#a78bfa',
            dark: '#1e293b',
            light: '#f8fafc'
          },
          animation: {
            'fade-in': 'fadeIn 0.6s ease-in-out',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(-10px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            }
          }
        }
      }
    }
  </script>
  
  <style type="text/tailwindcss">
    @layer components {
      .timeline {
        @apply border-l-2 border-gray-200 pl-4 ml-2;
      }
      .timeline-item {
        @apply relative mb-6 flex items-start;
      }
      .timeline-icon {
        @apply w-8 h-8 rounded-full flex items-center justify-center mr-3 mt-0.5;
      }
      .timeline-content {
        @apply flex-1;
      }
      .status-badge {
        @apply px-3 py-1 rounded-full text-sm font-medium;
      }
      .nav-tab {
        @apply px-4 py-2 text-sm font-medium rounded-lg transition-all;
      }
      .nav-tab.active {
        @apply bg-primary/10 text-primary;
      }
    }
  </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
  <div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Back Button -->
    <div class="mb-4">
      <a href="javascript:history.back()" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm hover:bg-gray-50 transition-all">
        <i class="bi bi-arrow-left text-gray-600"></i>
      </a>
    </div>

    <!-- Booking Header -->
    <div class="text-center mb-8">
      <h1 class="text-2xl font-bold text-dark mb-2 relative pb-3 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-1 after:bg-gradient-to-r after:from-primary after:to-secondary after:rounded-full">
        Booking Details
        <span class="status-badge <?php echo $status_color; ?> ml-2">
          <?php echo ucfirst($booking['booking_status']); ?>
        </span>
      </h1>
      <p class="text-gray-500">Booking #<?php echo $booking['booking_no']; ?></p>
    </div>

    <!-- Booking Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <!-- Provider Image -->
      <div class="h-64 md:h-80 overflow-hidden">
        <img 
          src="../s_pro/uploads2/<?php echo htmlspecialchars($booking['provider_image']); ?>" 
          alt="<?php echo htmlspecialchars($booking['provider_name']); ?>" 
          class="w-full h-full object-cover">
      </div>

      <div class="p-6">
        <!-- Service Title -->
        <?php
        $id = $booking['subservice_id'];
        $res = mysqli_query($conn, "select * from subservice where subservice_id=$id");
        $row = mysqli_fetch_assoc($res);
        ?>
        <h2 class="text-xl font-bold text-dark mb-2"><?php echo htmlspecialchars($row['subservice_name']); ?></h2>

        <!-- Location and Rating -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
          <div class="flex items-center text-gray-600">
            <i class="bi bi-geo-alt mr-1 text-primary"></i>
            <span><?php echo htmlspecialchars($booking['provider_address']); ?></span>
          </div>
          <div class="flex items-center text-amber-500">
            <i class="bi bi-star-fill mr-1"></i>
            <span>4.4 (532)</span>
          </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex border-b border-gray-200 mb-6">
          <button 
            id="details-tab" 
            class="nav-tab active mr-2"
            onclick="switchTab('details')">
            Service Details
          </button>
          <button 
            id="provider-tab" 
            class="nav-tab"
            onclick="switchTab('provider')">
            Provider Info
          </button>
        </div>

        <!-- Tab Contents -->
        <div id="details-content" class="tab-content">
          <!-- Booking Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <p class="text-gray-500 text-sm">Booking Time</p>
              <p class="font-semibold"><?php echo date('F j, Y', strtotime($booking['booking_time'])); ?></p>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Amount</p>
              <p class="font-semibold text-primary">$<?php echo number_format($booking['amount'], 2); ?></p>
            </div>
            <?php if (!empty($booking['reason'])): ?>
              <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Reason</p>
                <p class="font-semibold"><?php echo htmlspecialchars($booking['reason']); ?></p>
              </div>
            <?php endif; ?>
          </div>

          <!-- Timeline -->
          <h3 class="font-semibold text-dark mb-4">Booking Timeline</h3>
          <div class="timeline">
            <?php foreach ($timeline_statuses as $status): ?>
              <div class="timeline-item">
                <div class="timeline-icon <?php echo $status['active'] ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'; ?>">
                  <i class="bi <?php echo $status['icon']; ?>"></i>
                </div>
                <div class="timeline-content">
                  <h4 class="font-semibold text-dark mb-1"><?php echo $status['title']; ?></h4>
                  <p class="text-gray-500 text-sm"><?php echo $status['description']; ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div id="provider-content" class="tab-content hidden">
          <!-- Provider Info -->
          <div class="flex items-center mb-6">
            <img 
              src="../s_pro/uploads2/<?php echo htmlspecialchars($booking['provider_image']); ?>" 
              alt="<?php echo htmlspecialchars($booking['provider_name']); ?>" 
              class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h3 class="font-bold text-dark"><?php echo htmlspecialchars($booking['provider_name']); ?></h3>
              <p class="text-gray-500"><?php echo htmlspecialchars($booking['businessname']); ?></p>
            </div>
          </div>

          <div class="space-y-3 mb-6">
            <p class="flex items-center text-gray-700">
              <i class="bi bi-envelope mr-2 text-primary"></i>
              <?php echo htmlspecialchars($booking['provider_email']); ?>
            </p>
            <p class="flex items-center text-gray-700">
              <i class="bi bi-telephone mr-2 text-primary"></i>
              <?php echo htmlspecialchars($booking['provider_phone']); ?>
            </p>
            <p class="flex items-center text-gray-700">
              <i class="bi bi-geo-alt mr-2 text-primary"></i>
              <?php echo htmlspecialchars($booking['provider_address']); ?>
            </p>
          </div>

          <div class="flex space-x-3">
            <button class="flex-1 py-2 border border-primary text-primary rounded-lg hover:bg-primary/10 transition-all">
              <i class="bi bi-chat-left-text mr-1"></i> Message
            </button>
            <button class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all">
              <i class="bi bi-telephone mr-1"></i> Call
            </button>
          </div>
        </div>

        <!-- Action Button -->
        <div class="mt-8">
          <?php if (strtolower($booking['booking_status']) === 'pending'): ?>
            <button 
              class="w-full py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all"
              onclick="document.getElementById('cancel-modal').classList.remove('hidden')">
              Cancel Booking
            </button>
          <?php elseif (strtolower($booking['booking_status']) === 'completed'): ?>
                    <button 
            onclick="window.location.href='view.php?booking_id=<?php echo $booking['booking_id']; ?>'" 
            class="w-full py-3 bg-primary text-white rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="bi bi-receipt mr-1"></i> View Receipt
          </button>
          <?php else: ?>
            <button class="w-full py-3 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
              <?php echo ucfirst($booking['booking_status']); ?>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Cancel Booking Modal -->
  <div id="cancel-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-dark">Cancel Booking</h3>
        <button 
          class="text-gray-500 hover:text-gray-700"
          onclick="document.getElementById('cancel-modal').classList.add('hidden')">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <p class="mb-6 text-gray-600">Are you sure you want to cancel this booking?</p>
      <div class="flex space-x-3">
        <button 
          class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all"
          onclick="document.getElementById('cancel-modal').classList.add('hidden')">
          Go Back
        </button>
        <a 
          href="cancel_booking.php?id=<?php echo $booking['booking_id'] ?>" 
          class="flex-1 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all text-center">
          Confirm Cancel
        </a>
      </div>
    </div>
  </div>

  <script>
    // Tab switching function
    function switchTab(tabName) {
      // Hide all tab contents
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
      });
      
      // Show selected tab content
      document.getElementById(tabName + '-content').classList.remove('hidden');
      
      // Update active tab button
      document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
      });
      document.getElementById(tabName + '-tab').classList.add('active');
    }
  </script>
</body>
</html>