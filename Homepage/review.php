<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Initialize variables
$booking = [];
$error = '';
$success = '';
$review_exists = false;
$existing_review = null;

// Fetch booking details and validate it's completed
if ($booking_id > 0) {
    $stmt = $conn->prepare("
 SELECT b.*, p.businessname, p.image as provider_image, s.service_name, p.provider_id, s.service_id 
        FROM booking b
        JOIN service_providers p ON b.provider_id = p.provider_id
        JOIN service s ON b.service_id = s.service_id
        WHERE b.booking_id = ? AND b.user_id = ? AND b.booking_status = 'completed'
    ");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if (!$booking) {
        $_SESSION['error'] = "Invalid booking, booking not completed, or you don't have permission to review this booking";
        header("Location: bookings.php");
        exit();
    }

    // Get provider image path
    $provider_image = !empty($booking['provider_image']) ? '../s_pro/uploads2/' . $booking['provider_image'] : '';
    // Check if review already exists for this booking
    $check_stmt = $conn->prepare("
        SELECT * FROM review 
        WHERE user_id = ? AND EXISTS (
            SELECT 1 FROM booking 
            WHERE booking_id = ? AND user_id = ?
        )
    ");
    
    if ($check_stmt === false) {
        $error = "Database error: " . $conn->error;
    } else {
        $check_stmt->bind_param("iii", $user_id, $booking_id, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $review_exists = true;
            $existing_review = $check_result->fetch_assoc();
        }
        $check_stmt->close();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review']) && !$review_exists) {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $provider_id = $booking['provider_id'];
    $service_id = $booking['service_id'];
    
    // Validate input
    if ($rating < 1 || $rating > 5) {
        $error = "Please select a valid rating (1-5 stars)";
    } elseif (empty($comment)) {
        $error = "Please enter your review comments";
    } else {
        // Insert new review
        $insert_stmt = $conn->prepare("
            INSERT INTO review
            (user_id, provider_id, rating, comment, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        if ($insert_stmt === false) {
            $error = "Database error: " . $conn->error;
        } else {
            $insert_stmt->bind_param(
                "iiis", 
                $user_id, 
                $provider_id, 
                $rating, 
                $comment
            );
                    if ($insert_stmt->execute()) {
            // Update booking to mark as reviewed (optional - only if column exists)
            $update_sql = "UPDATE booking SET is_reviewed = 1 WHERE booking_id = ?";
            if ($update_stmt = $conn->prepare($update_sql)) {
                $update_stmt->bind_param("i", $booking_id);
                $update_stmt->execute();
                $update_stmt->close();
            }
                
                $_SESSION['success'] = "Thank you for your review!";
                header("Location: cart.php");
                exit();
            } else {
                $error = "There was an error submitting your review. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
        :root {
            --primary-color: #ad67c8;
            --primary-hover: #9c56b7;
        }
        
        .review-card {
            max-width: 600px;
            margin: 2rem auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .review-header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0;
        }
        
        .rating-stars {
            font-size: 2rem;
            color: #ffc107;
            cursor: pointer;
            margin: 1rem 0;
        }
        
        .star {
            transition: all 0.2s;
        }
        
        .star:hover:not(.disabled), .star.active:not(.disabled) {
            transform: scale(1.2);
        }
        
        .star.disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .btn-disabled {
            background: #cccccc;
            border-color: #cccccc;
            cursor: not-allowed;
        }
        
        .service-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .existing-review {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 576px) {
            .rating-stars { font-size: 1.5rem; }
            .service-image { width: 60px; height: 60px; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="card review-card">
            <div class="review-header text-center">
                <h2><i class="fas fa-star me-2"></i>Leave a Review</h2>
            </div>
            
            <div class="card-body p-4">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <!-- Booking Summary -->
                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                       <?php if (!empty($provider_image)): ?>
                        <img src="<?= htmlspecialchars($provider_image) ?>" 
                             class="service-image me-3" 
                             alt="<?= htmlspecialchars($booking['businessname']) ?>"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
                    <?php else: ?>
                        <div class="service-image img-placeholder me-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars($booking['service_name']) ?></h5>
                        <p class="mb-1 text-muted"><?= htmlspecialchars($booking['businessname']) ?></p>
                        <small class="text-muted">
                            <?= date('M d, Y', strtotime($booking['booking_time'])) ?>
                        </small>
                    </div>
                </div>
                
                <?php if ($review_exists): ?>
                    <div class="existing-review">
                        <h5>Your Existing Review</h5>
                        <div class="mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= $existing_review['rating'] ? 'fas' : 'far' ?> fa-star text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <p><?= htmlspecialchars($existing_review['comment']) ?></p>
                        <small class="text-muted">
                            Submitted on <?= date('M d, Y', strtotime($existing_review['created_at'])) ?>
                        </small>
                    </div>
                <?php endif; ?>
                
                <!-- Review Form -->
                <form method="POST">
                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                    
                    <div class="mb-4">
                        <h5 class="mb-3">How would you rate your experience?</h5>
                        <div class="rating-stars text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="far fa-star star mx-1 <?= $review_exists ? 'disabled' : '' ?>" 
                                   data-rating="<?= $i ?>" 
                                   onclick="<?= $review_exists ? '' : 'setRating('.$i.')' ?>"></i>
                            <?php endfor; ?>
                            <input type="hidden" name="rating" id="rating-value" 
                                   value="<?= $review_exists ? $existing_review['rating'] : '' ?>"
                                   <?= $review_exists ? 'disabled' : '' ?> required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="comment" class="form-label h5">Your Review</label>
                        <textarea class="form-control" id="comment" name="comment" 
                                  placeholder="<?= $review_exists ? 'You have already submitted a review for this booking' : 'Share details about your experience...' ?>" 
                                  <?= $review_exists ? 'disabled' : '' ?>
                                  required rows="4"><?= $review_exists ? htmlspecialchars($existing_review['comment']) : '' ?></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" name="submit_review" 
                                class="btn btn-primary-custom btn-lg py-2 <?= $review_exists ? 'btn-disabled' : '' ?>"
                                <?= $review_exists ? 'disabled' : '' ?>>
                            <i class="fas fa-paper-plane me-2"></i> 
                            <?= $review_exists ? 'Review Already Submitted' : 'Submit Review' ?>
                        </button>
                        <a href="home.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back To Home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setRating(rating) {
            document.getElementById('rating-value').value = rating;
            const stars = document.querySelectorAll('.star:not(.disabled)');
            
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('fas', 'active');
                    star.classList.remove('far');
                } else {
                    star.classList.remove('fas', 'active');
                    star.classList.add('far');
                }
            });
        }
        
        // Initialize stars if existing review
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($review_exists): ?>
                // Show existing rating
                const existingRating = <?= $existing_review['rating'] ?>;
                const stars = document.querySelectorAll('.star');
                
                stars.forEach((star, index) => {
                    if (index < existingRating) {
                        star.classList.add('fas', 'active');
                        star.classList.remove('far');
                    } else {
                        star.classList.remove('fas', 'active');
                        star.classList.add('far');
                    }
                });
            <?php else: ?>
                // Initialize empty stars
                stars = document.querySelectorAll('.star');
                stars.forEach(star => star.classList.add('far'));
            <?php endif; ?>
        });
    </script>
</body>
</html>