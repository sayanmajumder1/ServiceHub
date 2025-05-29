<?php

// Start session for user authentication
session_start();
// Database configuration - REPLACE WITH YOUR ACTUAL CREDENTIALS
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'servicehub_data';

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get logged-in user ID - adjust based on your authentication system
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php?error=not_logged_in");
    exit();
}

// Get booking ID from URL
$booking_id = $_GET['booking_id'] ?? $_GET['id'] ?? null;

// Validate booking ID
if (!$booking_id || !is_numeric($booking_id)) {
    header("Location: bookings.php?error=invalid_booking_id");
    exit();
}

$booking_id = (int)$booking_id;

// Fetch booking details
$booking_query = $conn->prepare("SELECT 
                                b.*, 
                                s.service_name, 
                                ss.subservice_name, 
                                ss.service_des as subservice_description,
                                ss.image as subservice_image,
                                p.provider_name, 
                                p.businessname, 
                                p.image as provider_image, 
                                p.email as provider_email, 
                                p.phone as provider_phone, 
                                p.address as provider_address,
                                p.lisenceno,
                                p.identityno
                                FROM booking b
                                JOIN service s ON b.service_id = s.service_id
                                JOIN subservice ss ON b.subservice_id = ss.subservice_id
                                JOIN service_providers p ON b.provider_id = p.provider_id
                                WHERE b.booking_id = ? AND b.user_id = ?");
$booking_query->bind_param("ii", $booking_id, $user_id);
$booking_query->execute();
$booking_result = $booking_query->get_result();

if ($booking_result->num_rows === 0) {
    header("Location: cart.php?error=booking_not_found");
    exit();
}

$booking = $booking_result->fetch_assoc();

// Format dates
$booking_date = date('F j, Y', strtotime($booking['booking_time']));
$completion_date = date('F j, Y', strtotime($booking['created_at']));
$receipt_date = date('F j, Y, g:i a');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Service Receipt</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
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
      .receipt-container {
        @apply max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden;
      }
      .receipt-header {
        @apply bg-gradient-to-r from-primary to-secondary text-white p-6 text-center;
      }
      .receipt-title {
        @apply text-2xl font-bold mb-2;
      }
      .receipt-subtitle {
        @apply text-sm opacity-90;
      }
      .divider {
        @apply border-t border-gray-200 my-4;
      }
      .section-title {
        @apply text-lg font-semibold text-dark mb-3;
      }
      .detail-item {
        @apply flex justify-between py-2;
      }
      .detail-label {
        @apply text-gray-600;
      }
      .detail-value {
        @apply font-medium text-dark;
      }
      .provider-card {
        @apply bg-gray-50 rounded-lg p-4 flex items-center;
      }
      .stamp {
        @apply absolute right-6 top-1/2 transform -translate-y-1/2 opacity-80;
      }
    }
    
    @page {
      size: auto;
      margin: 0mm;
    }
    
    @media print {
      body {
        padding: 0;
        background: white;
      }
      .no-print {
        display: none !important;
      }
      .receipt-container {
        box-shadow: none;
        border-radius: 0;
      }
    }
  </style>
</head>

<body class="bg-gray-100 font-sans antialiased py-8">
  <div class="container mx-auto px-4">
    <!-- Back Button (Hidden when printing) -->
    <div class="mb-4 no-print">
      <a href="cart.php" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm hover:bg-gray-50 transition-all">
        <i class="bi bi-arrow-left text-gray-600"></i>
      </a>
    </div>

    <!-- Receipt Container -->
    <div class="receipt-container">
      <!-- Receipt Header -->
      <div class="receipt-header">
        <h1 class="receipt-title">Service Completion Receipt</h1>
        <p class="receipt-subtitle">Thank you for choosing our services</p>
      </div>
      
      <!-- Receipt Content -->
      <div class="p-6">
        <!-- Receipt Info -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
          <div>
            <h2 class="text-xl font-bold text-dark"><?php echo htmlspecialchars($booking['businessname']); ?></h2>
            <p class="text-gray-600"><?php echo htmlspecialchars($booking['provider_address']); ?></p>
            <p class="text-gray-600">Phone: <?php echo htmlspecialchars($booking['provider_phone']); ?></p>
          </div>
          <div class="mt-4 md:mt-0 text-right">
            <p class="text-gray-600">Receipt #<?php echo htmlspecialchars($booking['booking_no']); ?></p>
            <p class="text-gray-600">Date: <?php echo $receipt_date; ?></p>
            <p class="text-gray-600">Status: <span class="font-semibold text-green-600">Completed</span></p>
          </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Service Details -->
        <div class="mb-6">
          <h3 class="section-title">Service Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="detail-label">Service Type</p>
              <p class="detail-value"><?php echo htmlspecialchars($booking['service_name']); ?></p>
            </div>
            <div>
              <p class="detail-label">Subservice</p>
              <p class="detail-value"><?php echo htmlspecialchars($booking['subservice_name']); ?></p>
            </div>
            <div>
              <p class="detail-label">Booking Date</p>
              <p class="detail-value"><?php echo $booking_date; ?></p>
            </div>
            <div>
              <p class="detail-label">Completion Date</p>
              <p class="detail-value"><?php echo $completion_date; ?></p>
            </div>
          </div>
          
          <?php if (!empty($booking['subservice_description'])): ?>
            <div class="mt-4">
              <p class="detail-label">Service Description</p>
              <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['subservice_description']); ?></p>
            </div>
          <?php endif; ?>
        </div>
        
        <div class="divider"></div>
        
        <!-- Provider Information -->
        <div class="mb-6">
          <h3 class="section-title">Service Provider</h3>
          <div class="provider-card">
            <img 
              src="../s_pro/uploads2/<?php echo htmlspecialchars($booking['provider_image']); ?>" 
              alt="<?php echo htmlspecialchars($booking['provider_name']); ?>" 
              class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h4 class="font-bold text-dark"><?php echo htmlspecialchars($booking['provider_name']); ?></h4>
              <p class="text-gray-600"><?php echo htmlspecialchars($booking['businessname']); ?></p>
              <p class="text-sm text-gray-500 mt-1">
                License: <?php echo htmlspecialchars($booking['lisenceno']); ?> | 
                ID: <?php echo htmlspecialchars($booking['identityno']); ?>
              </p>
            </div>
          </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Payment Information -->
        <div class="mb-6">
          <h3 class="section-title">Payment Details</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="detail-item">
              <span class="detail-label">Subtotal</span>
              <span class="detail-value">$<?php echo number_format($booking['amount'], 2); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Tax</span>
              <span class="detail-value">$0.00</span>
            </div>
            <div class="detail-item border-t border-gray-200 pt-2 mt-2">
              <span class="detail-label font-bold">Total Amount</span>
              <span class="detail-value font-bold text-primary">$<?php echo number_format($booking['amount'], 2); ?></span>
            </div>
            <div class="detail-item mt-2">
              <span class="detail-label">Payment Method</span>
              <span class="detail-value"><?php echo ucfirst($booking['payment_method']); ?></span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Transaction ID</span>
              <span class="detail-value"><?php echo htmlspecialchars($booking['transaction_id']); ?></span>
            </div>
          </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Customer Support -->
        <div class="text-center py-4">
          <h3 class="section-title">Customer Support</h3>
          <p class="text-gray-600 mb-3">If you have any questions about this receipt, please contact us.</p>
          <div class="flex flex-wrap justify-center gap-3">
            <a href="mailto:<?php echo htmlspecialchars($booking['provider_email']); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
              <i class="bi bi-envelope mr-2 text-primary"></i> Email Support
            </a>
            <a href="tel:<?php echo htmlspecialchars($booking['provider_phone']); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
              <i class="bi bi-telephone mr-2 text-primary"></i> Call Support
            </a>
          </div>
        </div>
      </div>
      
      <!-- Receipt Footer -->
      <div class="bg-gray-50 p-6 text-center">
        <p class="text-gray-600 text-sm">Thank you for your business!</p>
        <p class="text-gray-500 text-xs mt-2">This is an official receipt for your records.</p>
      </div>
      
      <!-- Completed Stamp (Positioned absolutely) -->
      <div class="stamp no-print">
        <svg width="120" height="120" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="100" cy="100" r="90" fill="none" stroke="#10B981" stroke-width="10"/>
          <path d="M50 100 L85 135 L150 65" stroke="#10B981" stroke-width="15" stroke-linecap="round"/>
        </svg>
      </div>
    </div>

    <!-- Print Button ::: I Just Call A Funtiob That Is Print() which download the Recipt -->
    <div class="mt-6 text-center no-print">
      <button 
        onclick="window.print()" 
        class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg shadow-md hover:shadow-lg transition-all">
        <i class="bi bi-printer mr-2"></i> Print Receipt
      </button>
      <button 
        onclick="window.location.href='cart.php'" 
        class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all ml-4">
        <i class="bi bi-arrow-left mr-2"></i> Back to Bookings
      </button>
    </div>
  </div>
</body>
</html>