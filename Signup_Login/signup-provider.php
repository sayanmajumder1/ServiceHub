<?php
session_start();
require_once "connection.php";
require_once "smtp/PHPMailerAutoload.php"; // Required for sending OTP

if (isset($_SESSION['provider_id'])) {
  header("Location: /ServiceHub/s_pro/dash.php"); // Redirect if provider is already logged in
  exit();
}

$error = '';

// Fetch services from database
$services = [];
$service_query = mysqli_query($conn, "SELECT * FROM service");
while ($service = mysqli_fetch_assoc($service_query)) {
  $services[] = $service;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate phone number format (10 digits)
  if (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
    $error = "Please enter a valid 10-digit phone number!";
  }
  // Check password strength
  elseif (strlen($_POST['password']) < 8) {
    $error = "Password must be at least 8 characters long!";
  } else {
    $targetDir = "uploads/";

    if (!file_exists($targetDir)) {
      mkdir($targetDir, 0777, true);
    }

    $identityImage = '';
    if (isset($_FILES['documentUpload'])) {
      $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
      $identityImage = $targetDir . uniqid() . "_" . basename($_FILES["documentUpload"]["name"]);
      if (!move_uploaded_file($_FILES["documentUpload"]["tmp_name"], $identityImage)) {
        $error = "Failed to upload document";
      }
    }
  }

  if (empty($error)) {
    $service_id = (int)$_POST['service_id'];

    // Validate service
    $valid_service = false;
    foreach ($services as $service) {
      if ($service['service_id'] == $service_id) {
        $valid_service = true;
        break;
      }
    }

    if (!$valid_service) {
      $error = "Please select a valid service";
    } else {
      // Prepare signup data
      $data = [
        'account_type' => 'provider',
        'businessname' => $_POST['businessName'],
        'provider_name' => $_POST['ownerName'],
        'address' => $_POST['businessAddress'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'password' => $_POST['password'],
        'identityno' => $_POST['idNumber'],
        'lisenceno' => $_POST['licenseNumber'] ?? '',
        'identityimage' => $identityImage,
        'service_id' => $service_id,
        'image' => "default_provider.png",
        'description' => "New provider",
        'approved_action' => "pending"
      ];

      // Generate OTP
      $otp = rand(100000, 999999);
      $_SESSION['otp'] = $otp;
      $_SESSION['signup_data'] = $data;
      $_SESSION['email'] = $data['email'];
      $_SESSION['auth_type'] = 'signup';
      $_SESSION['user_type'] = 'provider';

      // Send OTP via PHPMailer
      $mail = new PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'verify.servicehub@gmail.com';
        $mail->Password = 'elyz jwsz ebpx zrsr'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('verify.servicehub@gmail.com', 'ServiceHub');
        $mail->addAddress($data['email'], $data['provider_name']);

        $mail->isHTML(true);
        $mail->Subject = 'OTP code';
        $mail->Body = "<p>Hello <strong>{$data['provider_name']}</strong>,</p>
                                   <p>Thank you for registering with ServiceHub.</p>
                                   <p>Your OTP is: <strong>$otp</strong></p>
                                   <p>Please enter this to verify your account.This OTP is valid for 5 minutes.</p>";

        $mail->send();
        // Redirect after successful email
        header("Location: otpVerification.php");
        exit();
      } catch (Exception $e) {
        $error = "Email sending failed: " . $mail->ErrorInfo;
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Service Provider</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    .service-card {
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .service-card.selected {
      border-color: #8b5cf6;
      box-shadow: 0 0 0 3px #8b5cf6;
      transform: scale(0.9);
    }

    .services-container {
      scrollbar-width: thin;
      scrollbar-color: #8b5cf6 #f3f4f6;
    }

    .services-container::-webkit-scrollbar {
      height: 8px;
    }

    .services-container::-webkit-scrollbar-thumb {
      background-color: #8b5cf6;
      border-radius: 4px;
    }

    /* Password toggle eye */
    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .password-container {
      position: relative;
    }

    /* Error message animation */
    .error-message {
      animation: fadeInOut 5s ease-in-out forwards;
    }

    @keyframes fadeInOut {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }

      10% {
        opacity: 1;
        transform: translateY(0);
      }

      90% {
        opacity: 1;
        transform: translateY(0);
      }

      100% {
        opacity: 0;
        transform: translateY(-20px);
      }
    }
  </style>
</head>

<body class="h-screen overflow-y-auto">
  <!-- Error Message Display -->
  <?php if ($error): ?>
    <div class="fixed top-20 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50 error-message">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <!-- Navbar -->
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0 z-50">
    <a href="/ServiceHub/Homepage/index.php"><img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30 md:h-25 md:w-25" /></a>
    <a href="./login.php" class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">
      Login
    </a>
  </nav>

  <!-- Main Content -->
  <main class="lg:flex max-h-screen w-full">
    <!-- Left Panel Image -->
    <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
      <div class="img1 w-[90%]">
        <img src="./images/4706264.jpg" alt="Provider Signup" />
      </div>
      <p class="hidden lg:flex lg:justify-center mt-3 text-center text-sm lg:text-lg w-full">
        Start offering your services to thousands of customers
      </p>
    </div>

    <!-- Step 2 Form -->
    <div class="w-full lg:w-[65%] xl:w-4/6 px-6 py-6 lg:py-10 overflow-y-auto h-full scrollbar-hide">
      <p class="text-gray-500 text-sm mb-2 lg:text-base italic text-center">Step 02/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold text-center mb-4">Create your provider profile</h1>
      <p class="mb-8 text-center text-base lg:text-lg">Fill in your business and personal information</p>

      <form method="POST" action="" enctype="multipart/form-data" class="w-full max-w-5xl mx-auto" id="signupForm">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Left Form -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Personal Information</h2>
            <div class="mb-3">
              <input id="businessName" name="businessName" type="text" placeholder="Business Name"
                class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="ownerName" name="ownerName" type="text" placeholder="Owner Name"
                class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="businessAddress" name="businessAddress" type="text" placeholder="Business Address"
                class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="email" name="email" type="email" placeholder="Email Address"
                class="w-full p-3 border rounded" required>
            </div>
            <div class="flex items-center border rounded mb-3 w-full max-w-md overflow-hidden">
              <span class="px-3 py-2 bg-gray-100 text-gray-700 border-r">+91</span>
              <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" title="Please enter a 10-digit phone number"
                class="px-3 py-2 w-full focus:outline-none" required />
            </div>
            <div class="mb-3 password-container">
              <input id="password" name="password" type="password" placeholder="Password (min 8 characters)" minlength="8"
                class="w-full p-3 border rounded pr-10" required>
              <span class="password-toggle" onclick="togglePassword('password')">👁️</span>
            </div>
          </div>

          <!-- Right Form -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Legal Documents</h2>
            <div class="mb-3">
              <input id="idNumber" name="idNumber" type="text" placeholder="ID Number"
                class="w-full p-3 border rounded" required>
            </div>
            <div class="mb-3">
              <input id="licenseNumber" name="licenseNumber" type="text" placeholder="License Number"
                class="w-full p-3 border rounded" required>
            </div>
            <div class="mb-3">
              <input id="documentUpload" name="documentUpload" type="file"
                class="w-full p-3 border rounded" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
          </div>
        </div>

        <!-- Services Section -->
        <div class="mt-10">
          <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Select Your Service</h2>
          <p class="text-sm text-gray-500 text-center mb-4">(Choose one service category)</p>

          <div class="services-container overflow-x-auto whitespace-nowrap pb-4">
            <div class="inline-flex space-x-4">
              <?php foreach ($services as $service): ?>
                <div class="service-card border rounded-xl shadow p-4 bg-white inline-block w-64"
                  onclick="selectService(this, '<?php echo htmlspecialchars($service['service_name']); ?>')">
                  <img src="/serviceHub/Admin/img/<?php echo htmlspecialchars($service['image']); ?>"
                    alt="<?php echo htmlspecialchars($service['service_name']); ?>"
                    class="w-full h-48 object-cover mb-4 rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                  <h3 class="font-bold text-gray-800 text-center"><?php echo htmlspecialchars($service['service_name']); ?></h3>
                  <input type="radio" name="service_id" value="<?php echo $service['service_id']; ?>" class="hidden" required>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <p id="selected-service-text" class="text-center mt-4 text-purple-600 font-medium hidden">
            Selected service: <span id="selected-service-name"></span>
          </p>
        </div>
        <p id="selected-service-name" class="mt-4 text-lg font-semibold text-purple-600 text-center"></p>
        <!-- Submit and Back Buttons -->
        <div class="mt-8 flex justify-between items-center">
          <button type="button" onclick="goBackToStep1()" class="bg-gray-300 px-5 py-2 rounded">Back</button>
          <button type="submit" id="submitBtn" class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition flex items-center justify-center">
            Signup
            <div id="submitSpinner" class="spinner"></div>
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      if (field.type === "password") {
        field.type = "text";
      } else {
        field.type = "password";
      }
    }

    function goBackToStep1() {
      window.location.href = "signup.php";
    }

    function selectService(card, serviceName) {
      // Remove 'selected' class from all service cards
      document.querySelectorAll('.service-card').forEach(c => c.classList.remove('ring', 'ring-purple-600'));

      // Add 'selected' style to clicked card
      card.classList.add('ring', 'ring-purple-600');

      // Set the value of the hidden radio input inside this card
      card.querySelector('input[type="radio"]').checked = true;

      // Update selected service text
      document.getElementById('selected-service-name').textContent = serviceName;
      document.getElementById('selected-service-text').classList.remove('hidden');
    }

    // Form submission handler
    document.getElementById('signupForm').addEventListener('submit', function(e) {
      const password = document.getElementById('password').value;

      // Show loading spinner
      document.getElementById('loadingOverlay').classList.remove('hidden');
      document.getElementById('submitSpinner').style.display = 'block';
      document.getElementById('submitBtn').disabled = true;

      return true;
    });

    // Password strength meter event listener
    document.getElementById('password').addEventListener('input', function(e) {
      updateStrengthMeter(e.target.value);
    });

    // Auto-hide error message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.querySelector('.error-message');
      if (errorMessage) {
        setTimeout(() => {
          errorMessage.remove();
        }, 5000);
      }
    });
  </script>
</body>

</html>