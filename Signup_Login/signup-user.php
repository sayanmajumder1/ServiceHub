<?php
session_start();
require_once "connection.php";
require_once "smtp/PHPMailerAutoload.php"; // Adjust path if needed

if (isset($_SESSION['user_id'])) {
  header("Location: /ServiceHub/Homepage/index.php"); // Redirect if already logged in
  exit();
}

$error = '';

// Function to send OTP
function sendOTP($email, $name)
{
  $_SESSION['otp'] = rand(100000, 999999); // Generate OTP

  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'verify.servicehub@gmail.com'; // Your Gmail
    $mail->Password = 'elyz jwsz ebpx zrsr'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('verify.servicehub@gmail.com', 'ServiceHub');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Your ServiceHub OTP Code';
    $mail->Body = "<p>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
                      <p>Thank you for registering with ServiceHub.</p>
                      <p>Your OTP is: <strong>" . $_SESSION['otp'] . "</strong></p>
                      <p>Please enter this code to complete your registration. This OTP is valid for 5 minutes.</p>";

    $mail->send();
  } catch (Exception $e) {
    $GLOBALS['error'] = "OTP sending failed: " . $mail->ErrorInfo;
  }
}

// On form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate phone number format (10 digits)
  if (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
    $error = "Please enter a valid 10-digit phone number!";
  }
  // Check password match
  elseif ($_POST['password'] !== $_POST['confirmPassword']) {
    $error = "Passwords do not match!";
  }
  // Check password strength
  elseif (strlen($_POST['password']) < 8) {
    $error = "Password must be at least 8 characters long!";
  } else {
    $data = [
      'account_type' => 'user',
      'name' => $_POST['fullName'],
      'email' => $_POST['email'],
      'phone' => $_POST['phone'],
      'password' => $_POST['password'],
      'image' => "default_user.png"
    ];
    $_SESSION['email'] = $data['email'];
    $_SESSION['signup_data'] = $data;
    sendOTP($data['email'], $data['name']);

    if (!$error) {
      header("Location: otpVerification.php");
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - User</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    /* Custom styles for error message */
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
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
    <a href="/ServiceHub/Homepage/index.php">
      <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
    </a>
    <a href="./login.php">
      <button class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">Login</button>
    </a>
  </nav>

  <main class="lg:flex w-full">
    <!-- Left Panel -->
    <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
      <div class="img1 w-[90%]">
        <img src="./images/5052671.jpg" alt="User Signup" />
      </div>
      <p class="hidden lg:flex lg:justify-center mt-3 text-center text-sm lg:text-lg w-full">
        Get services done at your doorstep
      </p>
    </div>

    <!-- Right Form Panel -->
    <div class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
      <p class="text-sm text-gray-500 mb-2 lg:text-base italic">Step 02/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold mb-4">Create your profile</h1>
      <p class="mb-6 text-base lg:text-lg">Fill in your personal details</p>

      <form method="POST" action="" id="signupForm">
        <input type="text" name="fullName" placeholder="Full Name"
          class="border px-4 py-2 rounded mb-3 w-full max-w-md" style="text-transform: capitalize;" required />
        <input type="email" name="email" placeholder="Email"
          class="border px-4 py-2 rounded mb-3 w-full max-w-md" required />
        <div class="flex items-center border rounded mb-3 w-full max-w-md overflow-hidden">
          <span class="px-3 py-2 bg-gray-100 text-gray-700 border-r">+91</span>
          <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" title="Please enter a 10-digit phone number"
            class="px-3 py-2 w-full focus:outline-none" required />
        </div>
        <div class="password-container w-full max-w-md mb-3">
          <input type="password" name="password" id="password" placeholder="Password (min 8 characters)"
            class="border px-4 py-2 rounded w-full" minlength="8" required />
          <span class="password-toggle" onclick="togglePassword('password')">👁️</span>
        </div>
        <div class="password-container w-full max-w-md mb-3">
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password"
            class="border px-4 py-2 rounded w-full" minlength="8" required />
          <!-- <span class="password-toggle" onclick="togglePassword('confirmPassword')">👁️</span> -->
        </div>
        <div class="text-left text-sm text-gray-500 w-full max-w-md mb-5">
          <p id="passwordHint" class="hidden text-red-600">Password does not match</p>
        </div>
        <div class="flex gap-5 justify-center mb-4">
          <button type="button" onclick="window.location.href='signup.php';"
            class="bg-gray-300 px-5 py-2 rounded">Back</button>
          <button type="submit" id="submitBtn"
            class="bg-purple-500 text-white px-5 py-2 rounded hover:bg-purple-600 flex items-center justify-center">
            Signup
            <div id="submitSpinner" class="spinner"></div>
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    // Auto-hide error message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.querySelector('.error-message');
      if (errorMessage) {
        setTimeout(() => {
          errorMessage.remove();
        }, 5000);
      }
    });

    // Toggle password visibility
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      if (field.type === "password") {
        field.type = "text";
      } else {
        field.type = "password";
      }
    }


    // Form submission handler
    document.getElementById('signupForm').addEventListener('submit', function(e) {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (password !== confirmPassword) {
        e.preventDefault();
        document.getElementById('passwordHint').classList.remove('hidden');
        document.getElementById('passwordHint').classList.add('block');
        return false;
      }

      return true;
    });
  </script>
</body>

</html>