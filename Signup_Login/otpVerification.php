<?php
ob_start();
session_start();
include 'connection.php';

// Generate OTP if not exists
if (!isset($_SESSION['otp'])) {
    $_SESSION['otp'] = rand(100000, 999999);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify'])) {
        // Get entered OTP
        $enteredOtp = implode('', $_POST['otp_digits'] ?? []);
        
        // Verify OTP
        if ($enteredOtp == $_SESSION['otp']) {
            // Check if it's signup or login
            if (isset($_SESSION['signup_data'])) {
                $data = $_SESSION['signup_data'];
                
                if ($data['account_type'] == 'user') {
                    // Insert user
                    $query = "INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ssss", $data['name'], $data['email'], $data['password'], $data['phone']);
                    mysqli_stmt_execute($stmt);
                    
                    // Set session and redirect
                    $_SESSION['user_id'] = mysqli_insert_id($conn);
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['account_type'] = 'user';
                    unset($_SESSION['signup_data'], $_SESSION['otp']);
                    header("Location: /ServiceHub/Homepage/home.php");
                    exit();
                } else {
                    // Insert provider
                    $query = "INSERT INTO service_provider(business_name, owner, email, phone, category) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "sssss", $data['business_name'], $data['owner'], $data['email'], $data['phone'], $data['category']);
                    mysqli_stmt_execute($stmt);
                    
                    $_SESSION['provider_id'] = mysqli_insert_id($conn);
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['account_type'] = 'provider';
                    unset($_SESSION['signup_data'], $_SESSION['otp']);
                    header("Location: /ServiceHub/s_pro/dash.php");
                    exit();
                }

            } else {
                // For login, just redirect
                unset($_SESSION['otp']);
                if ($_SESSION['account_type'] == 'user') {
                    header("Location: /ServiceHub/Homepage/home.php");
                } else {
                    header("Location: /ServiceHub/s_pro/dash.php");
                }
                exit();
            }

           
      
        } else {
            $error = "Wrong OTP entered. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify OTP</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    .otp-input {
      transition: all 0.3s ease;
    }
    .otp-input:focus {
      border-color: #8b5cf6;
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }
  </style>
</head>

<body class="h-screen overflow-y-auto">
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
    <div>
      <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
    </div>
  </nav>

  <main class="lg:flex max-h-screen w-full">
    <!-- Left Panel -->
    <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
      <div class="w-[90%]">
        <img src="./images/6333220.jpg" alt="Illustration" />
      </div>
      <p class="mt-3 text-center text-sm lg:text-lg w-full">
        Verify your profile & mobile no. via OTP
      </p>
    </div>

    <!-- OTP Verification Panel -->
    <div id="step4Otp" class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
      <p class="text-sm text-gray-500 mb-2 lg:text-base italic">Step 03/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold mb-4">Verify your Mobile</h1>
      <p class="mb-6 text-base lg:text-lg text-gray-600">We've sent a 6-digit code to your mobile number</p>

      <!-- Display OTP at the top for testing -->
      <div class="bg-purple-100 p-3 rounded-lg mb-4">
        <p class="text-purple-800 font-mono">For testing purposes, your OTP is: <span class="font-bold"><?php echo $_SESSION['otp']; ?></span></p>
      </div>

      <form method="POST" action="otpVerification.php">
        <div class="flex gap-2 justify-center">
          <?php for ($i = 0; $i < 6; $i++): ?>
            <input type="text" maxlength="1" name="otp_digits[]" 
                   class="otp-input border w-12 h-12 text-center text-xl rounded-lg focus:outline-none" 
                   required />
          <?php endfor; ?>
        </div>

        <!-- Error message display -->
        <?php if ($error): ?>
          <div class="mt-4 text-red-600 text-sm">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <div class="mt-6">
          <button type="submit" name="verify"
                  class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition">
            Verify OTP
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const otpInputs = document.querySelectorAll('.otp-input');

      otpInputs.forEach((input, index) => {
        // Auto-focus first input
        if (index === 0) input.focus();
        
        input.addEventListener('input', (e) => {
          if (e.target.value.length === 1 && index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
          }
        });

        input.addEventListener('keydown', (e) => {
          if (e.key === "Backspace" && e.target.value === "" && index > 0) {
            otpInputs[index - 1].focus();
          }
        });
      });
    });
  </script>
</body>
</html>