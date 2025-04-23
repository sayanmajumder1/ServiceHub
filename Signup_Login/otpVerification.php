<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
            <img src="./logo.png" alt="Logo" class="h-20 w-20 lg:h-30 lg:w-30" />
        </div>
    </nav>

    <main class="lg:flex max-h-screen w-full">
        <!-- Left Panel -->
        <div class="lg:flex lg:w-[35%] xl:w-2/6 flex-col items-center justify-center p-2 bg-white">
            <div class="w-[90%]">
                <img src="./6333220.jpg" alt="Illustration" />
            </div>
            <p class="mt-3 text-center text-sm lg:text-lg w-full">
                Get thousands of services at one click
            </p>
        </div>

        <!-- Step 4: OTP Verification -->
        <div id="step4Otp" class="lg:w-1/2 flex flex-col px-8 py-8 text-center lg:ml-10 items-center animate-fadeIn">
            <p class="text-sm text-gray-500 mb-2 lg:text-base italic">Step 03/03</p>
            <h1 class="text-3xl lg:text-5xl font-bold mb-4">Verify your Email</h1>
            <p class="mb-6 text-base lg:text-lg text-gray-600">We’ve sent a 6-digit code to your email address</p>

            <div class="flex gap-3 mb-6 justify-center">
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="1" />
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="2" />
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="3" />
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="4" />
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="5" />
                <input maxlength="1" class="otp-input border w-10 h-10 text-center rounded focus:outline-none focus:ring-2 focus:ring-purple-400" tabindex="6" />
            </div>

            <p class="text-sm text-gray-500 mb-4">
                Didn’t receive the code?
                <button class="text-purple-600 hover:underline font-medium">Resend OTP</button>
            </p>

            <div class="flex gap-5 justify-center">
                <button onclick="submitOtp()" class="bg-purple-500 text-white px-5 py-2 rounded hover:bg-purple-600">
                    Verify
                </button>
            </div>
        </div>

    </main>

    <script src="signup.js"></script>
</body>

</html>