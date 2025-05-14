<?php
session_start();
if (isset($_SESSION['visited'])) {
  header("Location: dash.php");
  exit();
}
$_SESSION['visited'] = true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen w-full">
  <div class="text-center w-[40%]">
    <div class="relative inline-block w-full h-40 mx-auto mb-6">
      <img
        loading="lazy"
        src="./img/loader.gif"
        alt="Logo"
        class="w-48 h-48 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
    </div>

    <div class="w-full h-6 mx-auto mb-4 relative">
      <span class="loader"></span>
    </div>

    <h1 class="text-[#ad67c8] text-4xl font-extrabold tracking-widest uppercase">
      Service Hub
    </h1>
  </div>

  <style>
    .loader {
      width: 0;
      height: 4.8px;
      display: inline-block;
      position: relative;
      background: #ad67c8;
      box-shadow: 0 0 10px rgba(173, 103, 200, 0.5);
      box-sizing: border-box;
      animation: animFw 4s linear infinite;
    }

    .loader::after,
    .loader::before {
      content: '';
      width: 10px;
      height: 1px;
      background: #ad67c8;
      position: absolute;
      top: 9px;
      right: -2px;
      opacity: 0;
      transform: rotate(-45deg) translateX(0px);
      box-sizing: border-box;
      animation: coli1 0.3s linear infinite;
    }

    .loader::before {
      top: -4px;
      transform: rotate(45deg);
      animation: coli2 0.3s linear infinite;
    }

    @keyframes animFw {
      0% {
        width: 0;
      }

      100% {
        width: 100%;
      }
    }

    @keyframes coli1 {
      0% {
        transform: rotate(-45deg) translateX(0px);
        opacity: 0.7;
      }

      100% {
        transform: rotate(-45deg) translateX(-45px);
        opacity: 0;
      }
    }

    @keyframes coli2 {
      0% {
        transform: rotate(45deg) translateX(0px);
        opacity: 1;
      }

      100% {
        transform: rotate(45deg) translateX(-45px);
        opacity: 0.7;
      }
    }
  </style>
  <script>
    setTimeout(function() {
      window.location.href = "dash.php";
    }, 3000);
  </script>
</body>

</html>