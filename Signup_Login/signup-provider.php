<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Service Provider</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen overflow-y-auto">

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
      <!-- <p class="mt-3 text-center text-sm lg:text-lg w-full">
        Start offering your services to thousands of customers
      </p> -->
    </div>

    <!-- Step 2 Form -->
    <div class="w-full lg:w-[65%] xl:w-4/6 px-6 py-6 lg:py-10 overflow-y-auto h-full scrollbar-hide">
      <p class="text-gray-500 text-sm mb-2 lg:text-base italic text-center">Step 02/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold text-center mb-4">Create your provider profile</h1>
      <p class="mb-8 text-center text-base lg:text-lg">Fill in your business and personal information</p>

      <form method="POST" action="http://localhost/ServiceHub/Signup_Login/otpVerification.php" enctype="multipart/form-data" class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Left Form -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Personal Information</h2>
            <div class="mb-3">
              <input id="businessName" name="businessName" type="text" placeholder="Business Name" class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="ownerName" name="ownerName" type="text" placeholder="Owner Name" class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="businessAddress" name="businessAddress" type="text" placeholder="Business Address" class="w-full p-3 border rounded capitalize" required>
            </div>
            <div class="mb-3">
              <input id="email" name="email" type="email" placeholder="Email Address" class="w-full p-3 border rounded" required>
            </div>
            <div class="mb-3 relative">
              <input id="password" name="password" type="password" placeholder="Password" class="w-full p-3 border rounded pr-10" required>
              <span onclick="togglePassword()" class="absolute right-3 top-3 cursor-pointer text-gray-500">👁️</span>
            </div>
          </div>

          <!-- Right Form -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Legal Documents</h2>
            <div class="mb-3">
              <input id="idNumber" name="idNumber" type="text" placeholder="ID Number" class="w-full p-3 border rounded" required>
            </div>
            <div class="mb-3">
              <input id="licenseNumber" name="licenseNumber" type="text" placeholder="License Number" class="w-full p-3 border rounded">
            </div>
            <div class="mb-3">
              <input id="documentUpload" name="documentUpload" type="file" class="w-full p-3 border rounded">
            </div>
          </div>
        </div>

        <!-- Services Section -->
        <div class="mt-10">
          <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Available Services</h2>
          <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="border rounded-xl shadow p-4 bg-white">
              <img src="./service1.jpg" alt="Plumbing Service" class="w-full h-32 object-cover mb-2 rounded-lg">
              <h3 class="font-bold text-gray-800 text-center">Plumbing</h3>
              <p class="text-sm text-gray-600 text-center">Tap, pipe, and drain services.</p>
            </div>
            <div class="border rounded-xl shadow p-4 bg-white">
              <img src="./service2.jpg" alt="Electrician Service" class="w-full h-32 object-cover mb-2 rounded-lg">
              <h3 class="font-bold text-gray-800 text-center">Electrician</h3>
              <p class="text-sm text-gray-600 text-center">Wiring, installations, repairs.</p>
            </div>
          </div>
        </div>

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
      window.location.href = "signup.php"; // Change as needed
    }
  </script>
</body>

</html>