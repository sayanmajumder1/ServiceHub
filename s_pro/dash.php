<?php
session_start();

if (!isset($_SESSION["provider_id"])) {
	header("location:/ServiceHub/Signup_Login/login.php");
	exit;
}

include_once "connection.php";

$res = mysqli_query($con, "SELECT service_providers.*, service.service_name 
    FROM service_providers 
    INNER JOIN service ON service_providers.service_id = service.service_id 
    WHERE service_providers.provider_id = " . $_SESSION['provider_id']);
$row = mysqli_fetch_assoc($res);

$_SESSION['id'] = $row['provider_id'];
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
</head>

<body>
	<?php include 'sidebar.php'; ?>
	<div class="main-content">
		<div class="top-profile d-flex justify-content-end align-items-center mb-4">
			<a href="profile-details.php" class="text-decoration-none text-dark">
				<div class="profile-info d-flex align-items-center">
					<img src="./img/n1.jpg" alt="profile" class="profile-pic me-3">
					<div>
						<h6 class="mb-0"><?php echo $row['provider_name'] ?></h6>
						<small class="text-muted"><?php echo $row['service_name'] ?></small>
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
									$res = mysqli_query($con, "select count(*) as total from booking where provider_id='" . $_SESSION['provider_id'] . "'");
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
								$res = mysqli_query($con, "select count(*) as total from booking where provider_id='" . $_SESSION['provider_id'] . "' and payment_status='pending'");
								$row = mysqli_fetch_array($res);
								?>
								<p class="custom-number"><?php echo $row['total'] ?></p>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="custom-card">
								<h5 class="custom-title">Completed Tasks</h5>
								<?php
								$res = mysqli_query($con, "select count(*) as total from booking where provider_id='" . $_SESSION['provider_id'] . "' and booking_status='completed'");
								$row = mysqli_fetch_array($res);
								?>
								<p class="custom-number"><?php echo $row['total'] ?></p>
							</div>
						</div>
						<div class="col-md-6 mb-4">
							<div class="custom-card">
								<h5 class="custom-title">5 Star Reviews</h5>
								<p class="custom-number">90%</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 d-flex flex-column justify-content-between" style="min-height: 500px;">
					<div class="custom-card service-card mb-4">
						<h4 class="custom-title">Service Image</h4>
						<div class="image-container text-center">
							<img src="img/n1.jpg" alt="Service Image" class="img-fluid service-img">
						</div>
					</div>

					<div class="review-card">
						<h5 class="section-title">Customer Reviews</h5>
						<div class="review-item">
							<?php
							$res = mysqli_query($con, "select review.*,users.name from review inner join users on review.user_id=users.user_id where review.provider_id='" . $_SESSION['provider_id'] . "' and rating=5");
							while ($row = mysqli_fetch_array($res)) {
							?>
								<div class="review avatar">
									<img src="img/n1.jpg" alt="User" class="user-icon me-2">
									<div>
										<div class="review-content">
											<h6 class="username"><?php echo $row['name'] ?></h6>
											<p class="review-text"><?php echo $row['comment'] ?></p>
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
		</div>
	</div>
	<script>
		document.querySelectorAll('.main-link').forEach(link => {
			if (window.location.href.includes(link.getAttribute('href'))) {
				link.classList.add('active');
			}
		});
	</script>
</body>

</html>