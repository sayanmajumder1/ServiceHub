<<<<<<< HEAD:LSF/Homepage/index.php
<?php
session_start();
// If user has already visited, redirect to home.php directly
if (isset($_SESSION['visited'])) {
    header("Location: home.php");
    exit();
}
// Mark session as visited
$_SESSION['visited'] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- Viewport for responsive design on all screen sizes -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- External Stylesheet (Optional) -->
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-white flex items-center justify-center min-h-screen transition-all duration-1000">
  <!-- 
    - bg-white: White background for a clean professional look.
    - flex: Apply Flexbox layout.
    - items-center: Vertically center contents.
    - justify-center: Horizontally center contents.
    - min-h-screen: Ensures full-screen height.
    - transition-all duration-1000: Smooth transition when properties change.
  -->

  <!-- Splash Screen Wrapper -->
  <div class="text-center animate-fade-in">
    <!-- 
      - text-center: Align text to center.
      - animate-fade-in: Custom fade-in animation (defined below).
    -->

    <!-- Logo and Loader Container -->
    <div class="relative inline-block w-40 h-40 mx-auto mb-6">
      <!-- 
        - relative: To anchor absolutely-positioned child (logo).
        - inline-block: Allows dimensions to apply.
        - w-40 h-40: 10rem square logo container.
        - mx-auto: Horizontally center.
        - mb-6: Bottom margin.
      -->

      <!-- Centered Circular Logo -->
            <img 
        src="assets/images/logo.png" 
        alt="Logo"
        class="bg-[#ad67c8] w-32 h-32 rounded-full shadow-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 transition-all duration-700"
      />

      <!-- 
        - w-32 h-32: 8rem circular logo.
        - rounded-full: Fully circular.
        - shadow-xl: Drop shadow for modern effect.
        - absolute center: Perfectly center logo within parent.
        - transition-all duration-700: Smooth load-in.
      -->
    </div>

    <!-- Horizontal Loading Bar -->
    <div class="w-40 h-2 bg-gray-300 rounded-full overflow-hidden mx-auto mb-4 relative">
      <!-- 
        - w-40 h-2: Loader size.
        - bg-gray-300: Base of loader bar.
        - rounded-full: Rounded edges.
        - overflow-hidden: Hide overflow of animated inner bar.
        - relative: Needed for absolute inner bar.
      -->

      <!-- Smooth Moving Loader Fill -->
      <div class="absolute left-0 top-0 h-full bg-[#ad67c8] animate-loader-smooth" style="width: 50%;"></div>
      <!-- 
        - absolute: Inner animated bar positioning.
        - bg-purple-600: Tailwind violet/purple accent.
        - animate-loader-smooth: Defined below.
        - width: 50% to control chunk size.
      -->
    </div>

          <!-- Brand Title -->
      <h1 class="  text-[#ad67c8] text-4xl font-extrabold tracking-widest uppercase drop-shadow-md animate-fadeIn transition-all duration-1000">
        Service Hub
        <!-- 
          - text-gray-800: Professional dark text color.
          - text-4xl: Slightly larger headline for emphasis.
          - font-extrabold: Strong weight for brand visibility.
          - tracking-widest: Wider letter spacing for modern feel.
          - uppercase: Brand in capital letters for identity.
          - drop-shadow-md: Subtle shadow to lift text visually.
          - animate-fadeIn: Smooth entrance animation (defined below).
          - transition-all duration-1000: Smooth property changes (e.g., hover or on-load).
        -->
      </h1>


    <!-- Tagline -->
    <p class="text-gray-600 text-sm mt-2 opacity-80 italic">
      powered by your brand
      <!-- 
        - text-gray-600: Lighter subtitle.
        - text-sm: Smaller font.
        - mt-2: Spacing above.
        - opacity-80: Subtle style.
        - italic: Style enhancement.
      -->
    </p>
  </div>

  <!-- Custom CSS Animations -->
  <style>
    
/* Smooth bar sliding left to right Splash screen*/
@keyframes loader-smooth {
  0% { left: -50%; }
  50% { left: 25%; }
  100% { left: 100%; }
}

.animate-loader-smooth {
  animation: loader-smooth 1.8s ease-in-out infinite;
}

/* Fade-in on load */
@keyframes fadeIn {
  0% {
  opacity: 0;
  transform: translateY(20px);
}
100% {
  opacity: 1;
  transform: translateY(0);
}
}

.animate-fade-in {
  animation: fadeIn 1s ease-out forwards;
}



  </style>
</body>
</html>
<script>
//Js For Showing The Splash Screen  When the Website Is Opening
setTimeout(function(){
window.location.href="home.php";
},5000);
</script>
</body>
</html>
