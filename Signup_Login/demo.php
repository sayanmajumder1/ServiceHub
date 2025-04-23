<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    @media (min-width: 1024px) {
      .scrollbar-hide::-webkit-scrollbar {
        display: none;
      }

      .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    }
  </style>

</head>

<body class="h-screen overflow-y-auto">
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
    <div>
      <img src="./logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30 md:h-25 md:w-25" />
    </div>
    <a href="./login.php"><button class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">Login</button></a>
    </button>
  </nav>

  <main class="lg:flex h-screen w-full">
    <!-- Left Panel -->
    <div class="lg:w-[35%] xl:h-screen xl:w-2/6 flex flex-col items-center justify-center p-2 bg-white">
      <div class="img1 w-[40%] lg:w-[95%] xl:w-[90%]">
        <img src="./4219239.jpg" alt="Illustration" />
      </div>
      <p class="mt-3 text-center text-sm lg:text-lg w-full">
        Get thousands of services at one click
      </p>
    </div>

    <!-- Step 1: Choose Account -->
    <div id="step1" class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
      <p class="text-gray-500 text-sm mb-2 lg:text-base italic">Step 01/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold mb-4">Create an account</h1>

      <h2 class="text-lg font-medium mb-8 lg:mb-15">Choose account type</h2>

      <button onclick="selectAccount('provider')" id="providerBtn"
        class="bg-white p-3 rounded-xl w-2/3 mb-6 border hover:bg-purple-500 hover:text-white text-gray-500">
        Service Provider
      </button>

      <button onclick="selectAccount('user')" id="userBtn"
        class="bg-white p-3 rounded-xl w-2/3 mb-6 border hover:bg-purple-500 hover:text-white text-gray-500">
        User Account
      </button>

      <p class="text-xs text-gray-500 mb-6 lg:mt-15">
        This information will be securely saved as per the
        <span class="font-semibold">Terms of Services</span> and
        <span class="font-semibold">Privacy Policy</span>
      </p>

      <!-- <div class="flex gap-8 justify-center mt-10">
        <button class="bg-gray-200 px-5 py-2 rounded">Help!</button>
        <button onclick="goToNextStep()" class="bg-purple-500 text-white px-5 py-2 rounded hover:bg-purple-600">
          Next
        </button>
      </div> -->
    </div>

    <!-- Step 2: Provider Form -->
    <div id="step3Provider" class="hidden w-full max-w-5xl mx-auto px-4 sm:px-6 py-6 h-[calc(100vh-60px)] overflow-y-auto scrollbar-hide">
      <form method="POST" action="http://localhost/ServiceHub/Signup_Login/otpVerification.php">
        <!-- Top Info Section -->
        <p class="text-gray-500 text-sm mb-2 lg:text-base italic text-center lg:text-left">Step 02/03</p>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Personal Information -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Personal Information</h2>

            <div class="mb-3">
              <label for="businessName" class="block text-sm font-medium mb-1">Business Name</label>
              <input id="businessName" name="businessName" type="text" placeholder="Business Name" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-3">
              <label for="ownerName" class="block text-sm font-medium mb-1">Owner Name</label>
              <input id="ownerName" name="ownerName" type="text" placeholder="Owner Name" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-3">
              <label for="businessAddress" class="block text-sm font-medium mb-1">Business Address</label>
              <input id="businessAddress" name="businessAddress" type="text" placeholder="Business Address" class="w-full p-2 border rounded" required>
            </div>
          </div>

          <!-- Identity & Legal Documents -->
          <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Identity & Legal Documents</h2>

            <div class="mb-3">
              <label for="idNumber" class="block text-sm font-medium mb-1">ID Number</label>
              <input id="idNumber" name="idNumber" type="text" placeholder="ID Number" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-3">
              <label for="licenseNumber" class="block text-sm font-medium mb-1">License Number</label>
              <input id="licenseNumber" name="licenseNumber" type="text" placeholder="License Number" class="w-full p-2 border rounded">
            </div>

            <div class="mb-3">
              <label for="documentUpload" class="block text-sm font-medium mb-1">Upload Documents</label>
              <input id="documentUpload" name="documentUpload" type="file" class="w-full p-2 border rounded">
            </div>
          </div>
        </div>

        <!-- Services Section -->
        <div class="mt-10">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">Available Services</h2>
          <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <!-- Service Card 1 -->
            <div class="border rounded-lg shadow p-4 bg-white">
              <img src="./service1.jpg" alt="Plumbing Service" class="w-full h-32 object-cover mb-2 rounded">
              <h3 class="font-bold text-gray-800">Plumbing</h3>
              <p class="text-sm text-gray-600">Tap, pipe, and drain services.</p>
            </div>

            <!-- Service Card 2 -->
            <div class="border rounded-lg shadow p-4 bg-white">
              <img src="./service2.jpg" alt="Electrician Service" class="w-full h-32 object-cover mb-2 rounded">
              <h3 class="font-bold text-gray-800">Electrician</h3>
              <p class="text-sm text-gray-600">Wiring, installations, repairs.</p>
            </div>

            <!-- More cards can be added similarly -->
          </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center mt-8 gap-4">
          <button type="button" onclick="goBackToStep1()" class="bg-gray-500 text-white px-4 py-2 rounded w-full sm:w-auto">Back</button>
          <input type="submit" class="bg-purple-500 text-white px-4 py-2 rounded w-full sm:w-auto" value="Next">
        </div>
      </form>
    </div>

    <!-- Step 3: User Account Form -->
    <div id="step3User" class="hidden lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center">
      <p class="text-sm text-gray-500 mb-2 lg:text-base italic">Step 02/03</p>
      <h1 class="text-3xl lg:text-5xl font-bold mb-4">Create your profile</h1>
      <p class="mb-6 text-base lg:text-lg">Fill in your personal details</p>

      <form method="POST" action="http://localhost/ServiceHub/Signup_Login/otpVerification.php">
        <input type="text" name="fullName" id="fullName" placeholder="Full Name" class="border px-4 py-2 rounded mb-3 w-full max-w-md" style="text-transform: capitalize;" />
        <input type="email" name="email" id="email" placeholder="Email" required class="border px-4 py-2 rounded mb-3 w-full max-w-md" />
        <div class="flex items-center border rounded mb-3 w-full max-w-md overflow-hidden">
          <span class="px-3 py-2 bg-gray-100 text-gray-700 border-r">+91</span>
          <input type="tel" name="phone" id="phone" placeholder="Phone Number" class="px-3 py-2 w-full focus:outline-none" />
        </div>

        <input type="password" name="password" id="password" placeholder="Password" class="border px-4 py-2 rounded mb-3 w-full max-w-md" />
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="border px-4 py-2 rounded mb-5 w-full max-w-md" />

        <div class="flex gap-5 justify-center mb-4">
          <button onclick="goBackToStep1()" class="bg-gray-300 px-5 py-2 rounded">Back</button>
          <button onclick="goToNextFromStep3()" class="bg-purple-500 text-white px-5 py-2 rounded hover:bg-purple-600">Next</button>
        </div>
      </form>
    </div>

  </main>

  <script src="signup.js"></script>
</body>

</html>