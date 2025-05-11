<?php
session_start();
require_once "connection.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data when submitted
    $targetDir = "uploads/";
    
    // Create upload directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Handle file upload
    $identityImage = '';
    if (isset($_FILES['documentUpload'])) {
        $identityImage = $targetDir . uniqid() . "_" . basename($_FILES["documentUpload"]["name"]);
        if (!move_uploaded_file($_FILES["documentUpload"]["tmp_name"], $identityImage)) {
            $error = "Failed to upload document";
        }
    }

    if (empty($error)) {
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
            'service_id' => $_POST['service_id'],
            'image' => "default_provider.png",
            'description' => "New provider",
            'approved_action' => "pending"
        ];

        $_SESSION['otp'] = rand(100000, 999999);
        $_SESSION['auth_type'] = 'signup';
        $_SESSION['user_type'] = 'provider';
        $_SESSION['signup_data'] = $data;
        
        header("Location: otpVerification.php");
        exit();
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
  </style>
</head>

<body class="h-screen overflow-y-auto">
  <!-- Error Message Display -->
  <?php if ($error): ?>
    <div class="fixed top-20 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <!-- Navbar -->
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0 z-50">
    <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30 md:h-25 md:w-25" />
    <a href="./login.php">
      <button class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">Login</button>
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

      <form method="POST" action="" enctype="multipart/form-data" class="w-full max-w-5xl mx-auto">
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
              <input type="tel" name="phone" placeholder="Phone Number" 
                     class="px-3 py-2 w-full focus:outline-none" required />
            </div>
            <div class="mb-3 relative">
              <input id="password" name="password" type="password" placeholder="Password" 
                     class="w-full p-3 border rounded pr-10" required>
              <span onclick="togglePassword()" class="absolute right-3 top-3 cursor-pointer text-gray-500">👀</span>
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
                     class="w-full p-3 border rounded">
            </div>
            <div class="mb-3">
              <input id="documentUpload" name="documentUpload" type="file" 
                     class="w-full p-3 border rounded" accept=".pdf,.jpg,.jpeg,.png">
            </div>
          </div>
        </div>

        <!-- Services Section -->
        <div class="mt-10">
          <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Select Your Service</h2>
          <p class="text-sm text-gray-500 text-center mb-4">(Choose one service category)</p>

          <div class="services-container overflow-x-auto whitespace-nowrap pb-4">
            <div class="inline-flex space-x-4">
            <?php

              include_once "connection.php";
              $res=mysqli_query($conn,"select * from service");
              while($row=mysqli_fetch_array($res))
              {

            ?>
           
              <div class="service-card border rounded-xl shadow p-4 bg-white inline-block w-64"
                onclick="selectService(this, '<?php echo $row['service_name']; ?>')">
                <img src="/serviceHub/Admin/img/<?php echo $row['image'] ?>"  alt="Plumbing Service" 
                  class="w-full h-48 object-cover mb-4 rounded-lg shadow-md transition-transform duration-300 hover:scale-105">

                <h3 class="font-bold text-gray-800 text-center"><?php echo $row['service_name'] ?></h3>
                <input type="radio" name="service_id" value="<?php echo $row['service_id']; ?>" class="hidden" required>
                <!-- <p class="text-sm text-gray-600 text-center">Tap, pipe, and drain services.</p> -->
            
          
              </div>
            <?php

                }

            ?>
        </div>
        </div>
        <p id="selected-service-name" class="mt-4 text-lg font-semibold text-purple-600 text-center"></p>
        <!-- Submit and Back Buttons -->
        <div class="mt-8 flex justify-between items-center">
          <button type="button" onclick="goBackToStep1()" class="bg-gray-300 px-5 py-2 rounded">Back</button>
          <button type="submit" class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition">
            Signup
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
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

        // Show selected service name below
        document.getElementById('selected-service-name').textContent = "Selected Service: " + serviceName;
    }


  </script>
</body>
</html>