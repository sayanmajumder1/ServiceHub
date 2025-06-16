<?php
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Your Brand</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="hideScrollbar.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#AD46FF',
                        secondary: '#9820f7',
                        accent: '#a78bfa',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer components {
            .contact-input {
                @apply w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all;
            }
            .contact-textarea {
                @apply w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all min-h-[120px];
            }
            .social-icon {
                @apply w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white hover:bg-secondary transition-all;
            }
            .success-msg {
                @apply p-3 mb-4 bg-green-100 text-green-700 rounded-lg;
            }
            .error-msg {
                @apply p-3 mb-4 bg-red-100 text-red-700 rounded-lg;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Contact Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto pt-10">
            <!-- Section Header -->
            <div class="text-center mb-12 animate-fade-in">
                <h1 class="text-3xl md:text-4xl font-bold text-dark mb-3">Contact Us</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Have questions or need assistance? We're here to help!</p>
            </div>

            <!-- Contact Container -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Contact Info -->
                    <div class="bg-gradient-to-br from-primary to-secondary p-8 md:p-10 text-white">
                        <h2 class="text-2xl font-bold mb-6">Get In Touch</h2>

                        <div class="space-y-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Email</h3>
                                    <p class="text-primary-100">support@servicehub.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-phone text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Phone</h3>
                                    <p class="text-primary-100">+91 9382594060</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-map-marker-alt text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Address</h3>
                                    <p class="text-primary-100">Bardhaman, West Bengal</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Icons -->
                        <div class="mt-8">
                            <h3 class="font-medium mb-4">Follow Us</h3>
                            <div class="flex space-x-3">
                                <a href="#" class="social-icon">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-icon">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-icon">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-icon">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="p-8 md:p-10">
                        <h2 class="text-2xl font-bold text-dark mb-6">Send Us a Message</h2>

                        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                            <div class="success-msg">
                                <i class="fas fa-check-circle mr-2"></i> Message sent successfully!
                            </div>
                        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                            <div class="error-msg">
                                <i class="fas fa-exclamation-circle mr-2"></i> Something went wrong. Please try again.
                            </div>
                        <?php endif; ?>

                        <form action="submit_contact.php" method="post" class="space-y-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                                <input type="text" id="name" name="name" placeholder="John Doe" required class="contact-input">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="john@example.com" required class="contact-input">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                                <textarea id="message" name="message" placeholder="How can we help you?" required class="contact-textarea"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 px-6 rounded-lg font-medium hover:shadow-lg transition-all">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>