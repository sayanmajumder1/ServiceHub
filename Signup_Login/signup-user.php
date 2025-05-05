<?php session_start(); /* NEW: Required for sessions */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - User</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="h-screen overflow-y-auto">

  <!-- Navbar  -->
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
    <div>
      <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30 md:h-25 md:w-25" />
    </div>
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

      <form method="POST" action="processSignup_user.php"> 
        <input type="text" name="fullName" placeholder="Full Name" class="border px-4 py-2 rounded mb-3 w-full max-w-md" style="text-transform: capitalize;" required />
        <input type="email" name="email" placeholder="Email" class="border px-4 py-2 rounded mb-3 w-full max-w-md" required />
        <div class="flex items-center border rounded mb-3 w-full max-w-md overflow-hidden">
          <span class="px-3 py-2 bg-gray-100 text-gray-700 border-r">+91</span>
          <input type="tel" name="phone" placeholder="Phone Number" class="px-3 py-2 w-full focus:outline-none" required />
        </div>
        <input type="password" name="password" placeholder="Password" class="border px-4 py-2 rounded mb-3 w-full max-w-md" required />
        <input type="password" name="confirmPassword" placeholder="Confirm Password" class="border px-4 py-2 rounded mb-5 w-full max-w-md" required />
        <div class="flex gap-5 justify-center mb-4">
          <button type="button" onclick="window.location.href='signup.php';" class="bg-gray-300 px-5 py-2 rounded">Back</button>
          <button type="submit" class="bg-purple-500 text-white px-5 py-2 rounded hover:bg-purple-600">Signup</button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>