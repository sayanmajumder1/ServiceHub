<?php
session_start();
include_once "connection.php";

// Check if provider is logged in and approved
if (!isset($_SESSION["provider_id"]) || $_SESSION["user_type"] !== 'provider') {
    header("Location: login.php");
    exit;
}

// Get provider details
$res = mysqli_query($con, "SELECT service_providers.*, service.service_name 
    FROM service_providers 
    INNER JOIN service ON service_providers.service_id = service.service_id 
    WHERE service_providers.provider_id = " . $_SESSION['provider_id']);

if (!$res) {
    die("Database error: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($res);

if (!$row) {
    die("Provider not found in database");
}

// ✅ Redirect to review.php if approved_status is 'pending'
if ($row['approved_action'] === 'pending') {
    header("Location: /ServiceHub/Signup_Login/review.php");
    exit;
}


// Store provider ID in session
$_SESSION['id'] = $row['provider_id'];
$_SESSION['service_id']=$row['service_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Dashboard | Service Provider</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	 <link rel="stylesheet" href="hideScrollbar.css">

	<style>
		.review-scroll-wrapper {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.review-scroll-content {
    display: inline-block;
    animation: scroll-up 10s linear infinite;
}

@keyframes scroll-up {
    0% {
        transform: translateY(100%);
    }
    100% {
        transform: translateY(-100%);
    }
}

	</style>
</head>

<body>
	<?php include 'sidebar.php'; ?>
	<div class="main-content">
		<div class="top-profile d-flex justify-content-end align-items-center mb-4">
			<a href="profile-details.php" class="text-decoration-none text-dark">
				<div class="profile-info d-flex align-items-center">
					<img src="./uploads2/<?php echo htmlspecialchars($row['image']) ?>" alt="Profile Picture" class="profile-pic me-3">
					<div>
						<h6 class="mb-0"><?php echo htmlspecialchars($row['provider_name']); ?></h6>
						<small class="text-muted"><?php echo htmlspecialchars($row['service_name']); ?></small>
					</div>
				</div>
			</a>
		</div>
		<div class="container-fluid mt-4">
			<div class="row">
				<div class="col-lg-8">
					<div class="row">
						<div class="col-md-6 mb-4">
							<a href="total_bookings.php" class="text-decoration-none text-dark">
								<div class="custom-card">
									<h5 class="custom-title">Total Bookings</h5>
									<?php
									$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM booking WHERE provider_id='" . $_SESSION['provider_id'] . "'");
									$row = mysqli_fetch_array($res);
									?>
									<p class="custom-number"><?php echo $row['total'] ?></p>
								</div>
							</a>
						</div>
						<div class="col-md-6 mb-4">
							<div class="custom-card">
								<h5 class="custom-title">Pending Payments</h5>
								<?php
								$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM booking WHERE provider_id='" . $_SESSION['provider_id'] . "' AND payment_status='pending'");
								$row = mysqli_fetch_array($res);
								?>
								<p class="custom-number"><?php echo $row['total'] ?></p>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="custom-card">
								<h5 class="custom-title">Completed Tasks</h5>
								<?php
								$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM booking WHERE provider_id='" . $_SESSION['provider_id'] . "' AND booking_status='completed'");
								$row = mysqli_fetch_array($res);
								?>
								<p class="custom-number"><?php echo $row['total'] ?></p>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="custom-card">
								<h5 class="custom-title">Total Earnings</h5>
								<?php
								$res = mysqli_query($con, "SELECT SUM(amount) AS total FROM booking WHERE provider_id='" . $_SESSION['provider_id'] . "' AND booking_status='completed'");
								$row = mysqli_fetch_array($res);
								?>
								<p class="custom-number">
								<?php 
									if (!empty($row['total'])) {
										echo $row['total'];
									} else {
										echo "0";
									}
								?>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 d-flex flex-column justify-content-between" style="min-height: 500px;">
    <div class="custom-card service-card mb-4" style="height: 340px;">
        <h4 class="custom-title">Customer Reviews</h4>
        <div class="review-scroll-wrapper">
            <div class="review-scroll-content">
                <?php
                $res = mysqli_query($con, "SELECT review.*, users.name,users.image FROM review 
                    INNER JOIN users ON review.user_id=users.user_id 
                    WHERE review.provider_id='" . $_SESSION['provider_id'] . "'");
                while ($row = mysqli_fetch_array($res)) {
                ?>
                <div class="review avatar">
				<img src="/ServiceHub/Homepage/assets/images/<?php echo $row['image'] ?>" alt="User" class="user-icon me-2">

                    <div>
                        <div class="review-content">
                            <h6 class="username"><?php echo htmlspecialchars($row['name']); ?></h6>
                            <p class="review-text"><?php echo htmlspecialchars($row['comment']); ?></p>
                            <div class="text-warning">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $row['rating']) {
                                        echo '<i class="fas fa-star text-warning"></i>';
                                    } else {
                                        echo '<i class="far fa-star text-muted"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- <canvas id="myChart" width="400" height="200"></canvas> -->


					
		
	<script>
		document.querySelectorAll('.main-link').forEach(link => {
			if (window.location.href.includes(link.getAttribute('href'))) {
				link.classList.add('active');
			}
		});
	
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar', // You can use 'line', 'pie', 'doughnut', etc.
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Booking',
            data: [12, 19, 23, 25, 12],
            backgroundColor: 'rgba(176, 67, 206, 0.5)',
            borderColor: 'rgb(194, 51, 230)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


	</script>
</body>

</html>