<?php
	 
	 session_start();
     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ongoing Booking </title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-card {
            max-width: 600px;
            margin: auto;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(88, 86, 86, 0.1);
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: -75px;
            border: 5px solid white;
        }
        .bg{
            background-color:#9810FA;
        }
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            margin: 0 5px;
            border: 1px solid #ced4da;
            border-radius: 8px;
        }
        .otp-input:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>
            <?php
                                     
                 include_once "connection.php";
                $res=mysqli_query($con,"select booking.*,users.*,service.service_name from booking inner join users on booking.user_id=users.user_id 
                inner join service on booking.service_id=service.service_id where booking_id='".$_GET['id']."' and booking_status='accepted'");
                 $count=1;
                 while($row=mysqli_fetch_array($res))
                {
            ?>
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card profile-card p-4 text-center w-100" style="max-width: 600px;">
                <div class="bg text-white p-4 rounded-top">
                    <h3 class="mb-0">Booking Details</h3>
                </div>
                <img src="img/i1.jpeg" alt="Profile Picture" class="profile-img mx-auto mt-3">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row['name']; ?></h4>
                    <p class="text-muted"><?php echo $row['email']; ?></p>
                    <hr>
                    <div class="text-start px-2 px-md-4">
                        <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                        <p><strong>Address:</strong> <?php echo ucfirst($row['address']); ?></p>
                        <!-- <p><strong>Service Provider Name:</strong> <?php echo $row['provider_name']; ?></p> -->
                        <p><strong>Service Category:</strong> <?php echo $row['service_name']; ?></p>
                        <p><strong>Booking No:</strong> <?php echo $row['booking_no']; ?></p>
                        <p><strong>Booking Time:</strong> <?php echo $row['booking_time']; ?></p>
                        <p><strong>Booking Status:</strong> <?php echo ucfirst($row['booking_status']); ?></p>
                       

            <!-- <a href="#.php?id=<?php echo $row['provider_id']; ?>" class="btn btn-outline-danger mt-3">COMPLETE</a>
                    </div> -->
                </div>
            </div>
    <!-- OTP Button -->
        <a href="javascript:void(0);" id="showOtpBtn" onclick="showOtpForm()" class="btn btn-outline-success mt-3">OTP</a>

        <!-- OTP Form (Initially Hidden) -->
        <div id="otpForm" style="display: none;" class="mt-3">
            <form>
                <div class="d-flex justify-content-center mb-3">
                    <input type="text" maxlength="1" class="otp-input"
                        oninput="moveToNext(this, 'otp2')" onkeydown="moveBack(event, null)" id="otp1" autofocus>
                    <input type="text" maxlength="1" class="otp-input"
                        oninput="moveToNext(this, 'otp3')" onkeydown="moveBack(event, 'otp1')" id="otp2">
                    <input type="text" maxlength="1" class="otp-input"
                        oninput="moveToNext(this, 'otp4')" onkeydown="moveBack(event, 'otp2')" id="otp3">
                    <input type="text" maxlength="1" class="otp-input"
                        onkeydown="moveBack(event, 'otp3')" id="otp4">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit OTP</button>
                </div>
            </form>
        </div>






        </div>
    </div>
            <?php

                }

            ?>

</div>
<script src="script.js"></script>
</body>
<!-- JavaScript to toggle visibility -->
<script>
    function showOtpForm() {
        document.getElementById('otpForm').style.display = 'block';     // Show OTP form
        document.getElementById('showOtpBtn').style.display = 'none';   // Hide OTP button
    }

    function moveToNext(current, nextFieldID) {
        if (current.value.length >= 1 && nextFieldID) {
            document.getElementById(nextFieldID).focus();
        }
    }

    function moveBack(e, prevFieldID) {
        if (e.key === "Backspace" && e.target.value === '' && prevFieldID) {
            document.getElementById(prevFieldID).focus();
        }
    }
</script>

</html>
