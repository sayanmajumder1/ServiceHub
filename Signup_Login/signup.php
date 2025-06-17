<?php session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: /ServiceHub/Homepage/index.php"); // Redirect if already logged in
  exit();
} else if (isset($_SESSION['provider_id'])) {
  header("Location: /ServiceHub/s_pro/dash.php"); // Redirect if provider is already logged in
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="h-screen overflow-y-auto">
  <nav class="w-full h-15 flex items-center justify-between px-3 lg:px-10 bg-white sticky top-0">
    <a href="/ServiceHub/Homepage/index.php">
      <img src="./images/logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
    </a>
    <a href="./login.php"><button class="bg-purple-500 px-3 py-1 rounded-full lg:px-8 lg:py-2 lg:font-semibold text-white">Login</button></a>
    </button>
  </nav>

  <main class="lg:flex max-h-screen w-full">
    <!-- Left Panel -->
    <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
      <div id="carousel" class="img1 w-[90%]">
        <img src="./images/7400904.jpg" alt="Illustration" id="carousel-image" class="transition-opacity duration-1000 opacity-100">
      </div>
      <div id="carousel-dots" class=" flex justify-center mt-4 gap-2">
        <span class="w-2.5 h-2.5 bg-purple-500 rounded-full transition-all duration-300"></span>
        <span class="w-2.5 h-2.5 bg-gray-300 rounded-full transition-all duration-300"></span>
        <span class="w-2.5 h-2.5 bg-gray-300 rounded-full transition-all duration-300"></span>
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

      <a href="./signup-user.php" class="w-full">
        <button id="userBtn"
          class="bg-white p-3 rounded-xl w-2/3 mb-6 border hover:bg-purple-500 hover:text-white text-gray-500">
          User Account
        </button>
      </a>
      <a href="./signup-provider.php" class="w-full">
        <button id="providerBtn"
          class="bg-white p-3 rounded-xl w-2/3 mb-6 border hover:bg-purple-500 hover:text-white text-gray-500">
          Service Provider
        </button>
      </a>

      <p class="text-xs text-gray-500 mb-6 lg:mt-15">
        This information will be securely saved as per the
        <span class="font-semibold">Terms of Services</span> and
        <span class="font-semibold">Privacy Policy</span>
      </p>

    </div>
  </main>


  <script>
    const imagePaths = [
      './images/7400904.jpg',
      './images/4219239.jpg',
      './images/5248427.jpg'
    ];

    let currentIndex = 0;
    const imageElement = document.getElementById('carousel-image');
    const dots = document.querySelectorAll('#carousel-dots span');

    function updateDots(index) {
      dots.forEach((dot, i) => {
        dot.classList.remove('bg-purple-500');
        dot.classList.add('bg-gray-300');
        if (i === index) {
          dot.classList.remove('bg-gray-300');
          dot.classList.add('bg-purple-500');
        }
      });
    }

    setInterval(() => {
      // Fade out
      imageElement.classList.remove('opacity-100');
      imageElement.classList.add('opacity-0');

      setTimeout(() => {
        // Change image
        currentIndex = (currentIndex + 1) % imagePaths.length;
        imageElement.src = imagePaths[currentIndex];
        imageElement.classList.remove('opacity-0');
        imageElement.classList.add('opacity-100');
        updateDots(currentIndex);
      }, 600);
    }, 3000);
  </script>

</body>

</html>