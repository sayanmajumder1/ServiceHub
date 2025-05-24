<?php
include "navbar.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Service Finder</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="Search_Function.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom animations -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .profile-img-animate {
            transition: all 0.3s ease;
        }

        .profile-img-animate:hover {
            transform: scale(1.05);
        }

        /* Scrolling Animation */
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-250px * 7));
            }
        }

        .scrolling-wrapper {
            animation: scroll 40s linear infinite;
            width: calc(250px * 14);
        }

        .scrolling-wrapper:hover {
            animation-play-state: paused;
        }

        /* Poster Animation */
        .poster-container {
            perspective: 1000px;
        }

        .poster {
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .poster:hover {
            transform: rotateY(180deg);
        }

        /* Original Navbar Colors */
        .original-nav {
            background-color: #ffffff;
        }

        .original-nav-link {
            color: #010913FF;
        }

        .original-nav-link:hover {
            color: #AD46FF;
        }

        .original-sidebar {
            background-color: #ffffff;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-r from-purple-50 to-purple-100 overflow-hidden">
        <div class="container mx-auto px-4 relative animate-fade-in">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Find Home <span class="text-purple-600">Service/Repair</span> Near You
                </h1>
                <p class="text-lg text-gray-600 mb-8">Explore best home service & repair near you</p>

                <!-- Search Bar -->
                <div class="flex justify-center max-w-2xl mx-auto">
                    <div class="relative w-full">
                        <input
                            id = "serviceSearch"
                            type="text"
                            class="w-full py-4 px-6 rounded-full border-0 shadow-lg focus:ring-2 focus:ring-purple-300 transition-all duration-300"
                          
                            placeholder="What service are you looking for?"
                             >
                        <button    onclick="filterServices()" class="absolute right-2 top-2 bg-purple-600 hover:bg-purple-700 text-white py-2 px-6 rounded-full transition-all duration-300">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Services Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Browse through our wide range of home services</p>
            </div>
                        <!-- Added search results count -->
            <div id="searchResultsCount" class="text-center text-purple-600 font-medium mb-4 hidden">
            Found <span id="resultsCount">0</span> services matching your search
            </div>
            <div  id="servicesContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                $user_id = $_SESSION['user_id'] ?? null;

                include 'db_connect.php';

               
                  // Get services ordered by service_id descending
                $sql = "SELECT * FROM service ORDER BY service_id DESC";
                $result = $conn->query($sql);

               


        
 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $image_data = '../Admin/img/' . $row['image'];
                        echo '
                        <div class="service-card group" data-service-name="'.strtolower(htmlspecialchars($row['service_name'])).'">

                            <a href="' . (!empty($user_id) ? 'providers.php?service_id=' . $row['service_id'] : '/ServiceHub/Signup_Login/login.php') . '" class="block">
                                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 service-card hover:shadow-lg">
                                    <div class="h-48 overflow-hidden">
                                        <img src="' . trim($image_data) . '" alt="' . htmlspecialchars($row['service_name']) . '" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">' . htmlspecialchars($row['service_name']) . '</h3>
                                        <div class="flex justify-between items-center">
                                            <span class="text-purple-600 text-sm font-medium">Explore</span>
                                            <i class="fas fa-arrow-right text-purple-600 transition-transform group-hover:translate-x-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                } else {
             echo '<p class="text-center col-span-full text-gray-600">No services available at the moment</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Scrolling Services Banner (New Unique Section) -->
    <section class="py-12 bg-white overflow-hidden">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-[#AD46FF] mb-8 text-center">Popular Services Near You</h2>

            <div class="relative h-64">
                <div class="absolute inset-0 flex items-center scrolling-wrapper space-x-8">
                    <?php
                    $services = [
                        ["Plumbing", "fa-faucet"],
                        ["Electrical", "fa-bolt"],
                        ["Cleaning", "fa-broom"],
                        ["Painting", "fa-paint-roller"],
                        ["Moving", "fa-truck-moving"],
                        ["Gardening", "fa-leaf"],
                        ["Repairs", "fa-tools"],
                        ["Carpentry", "fa-hammer"],
                        ["AC Repair", "fa-snowflake"],
                        ["Pest Control", "fa-bug"]
                    ];

                    foreach ($services as $service) {
                        echo '
                        <div class="flex-shrink-0 w-56 h-48 bg-[#AD46FF] bg-opacity-10 backdrop-filter backdrop-blur-sm rounded-xl p-6 flex flex-col items-center justify-center border border-white border-opacity-20 transition-all duration-300 hover:bg-opacity-20">
                            <i class="fas ' . $service[1] . ' text-[#AD46FF] text-4xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-[#AD46FF]">' . $service[0] . '</h3>
                            <p class="text-[#AD46FF] text-opacity-80 text-sm mt-2">50+ professionals</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Get your home services in just 3 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center px-6 py-8 bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-purple-600 text-2xl font-bold">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Find a Service</h3>
                    <p class="text-gray-600">Browse through our categories or search for specific services you need.</p>
                </div>

                <div class="text-center px-6 py-8 bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-purple-600 text-2xl font-bold">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Book an Appointment</h3>
                    <p class="text-gray-600">Select a professional and schedule a time that works for you.</p>
                </div>

                <div class="text-center px-6 py-8 bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-purple-600 text-2xl font-bold">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Enjoy Your Service</h3>
                    <p class="text-gray-600">Relax while our professionals take care of your home needs.</p>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>

    <!-- JavaScript -->
    <script>
        // Scrolling animation pause on hover
        document.querySelectorAll('.scrolling-wrapper').forEach(wrapper => {
            wrapper.addEventListener('mouseenter', () => {
                wrapper.style.animationPlayState = 'paused';
            });
            wrapper.addEventListener('mouseleave', () => {
                wrapper.style.animationPlayState = 'running';
            });
        });

 function filterServices() {
        const searchInput = document.getElementById('serviceSearch').value.toLowerCase();
        const serviceCards = document.querySelectorAll('[data-service-name]');
        let matchCount = 0;

        serviceCards.forEach(card => {
            const serviceName = card.getAttribute('data-service-name');
            if (serviceName.includes(searchInput)) {
                card.style.display = 'block';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const resultsCountContainer = document.getElementById('searchResultsCount');
        const resultsCount = document.getElementById('resultsCount');

        if (searchInput.trim() === "") {
            resultsCountContainer.classList.add("hidden");
        } else {
            resultsCount.textContent = matchCount;
            resultsCountContainer.classList.remove("hidden");
        }
    }

    // Optional: trigger search on Enter key press
    document.getElementById('serviceSearch').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            filterServices();
        }
    });
    </script>







</body>

</html>