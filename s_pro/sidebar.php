<?php
include_once "connection.php";
$res = mysqli_query($con, "SELECT service_providers.*, service.service_name 
    FROM service_providers 
    INNER JOIN service ON service_providers.service_id = service.service_id 
    WHERE service_providers.provider_id = " . $_SESSION['provider_id']);
$row=mysqli_fetch_assoc($res);
?>
<div class="sidebar">
    <div class="logo">
        <div class="circle">SP</div>
        <h4><?php  echo "welcome🤝".$row['businessname'] ?></h4><br><hr>
        <p><h2>Task Maker<h2></p>
    </div>
    <nav>
        <a href="dash.php" class="main-link">Dashboard</a>
		<a href="bookings.php" class="main-link">Bookings</a>
        <a href="ongoingbooking.php" class="main-link">Ongoing Booking</a>

        <a href="pay.php" class="main-link">Payment</a>
        <a href="rvu.php" class="main-link">Review</a>
        <a href="lout.php" class="main-link logout">🔓 Log Out</a>
    </nav>
</div>
