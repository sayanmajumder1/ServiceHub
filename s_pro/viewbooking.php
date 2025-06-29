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
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
         .profile-card {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

            .profile-img {
            width: 120px;
            height: 120px;
        }

        @media (max-width: 576px) {
            .profile-img {
                width: 90px;
                height: 90px;
            }
        }

        .bg{
            background-color:#9810FA;
        }
        .form-control,.form-select{
            border: 1px solid rgb(13, 69, 165);
        }
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            margin: 0 5px;
            border: 1px solid rgb(5, 52, 98);
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


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-12 col-md-3 col-lg-2 p-0">
            <?php include 'sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-9 col-lg-10">
            <?php
                include_once "connection.php";
                $res = mysqli_query($con, "SELECT booking.*, users.*, subservice.subservice_name FROM booking 
                    INNER JOIN users ON booking.user_id = users.user_id 
                    INNER JOIN subservice ON booking.subservice_id = subservice.subservice_id 
                    WHERE booking_id='" . $_GET['id'] . "' AND booking_status='accepted'");
                while ($row = mysqli_fetch_array($res)) {
            ?>
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <!-- CARD STARTS -->
                        <div class="card profile-card p-4 text-center">
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
                                    <p><strong>Service Category:</strong> <?php echo $row['subservice_name']; ?></p>
                                    <p><strong>Amount:</strong> <?php echo htmlspecialchars($row['amount']); ?></p>
                                    <p><strong>Booking No:</strong> <?php echo $row['booking_no']; ?></p>
                                    <p><strong>Booking Time:</strong> <?php echo $row['booking_time']; ?></p>
                                    <p><strong>Booking Status:</strong> <?php echo ucfirst($row['booking_status']); ?></p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-column flex-md-row justify-content-center gap-2 mt-3" id="actionButtons">
                                <button class="btn btn-success w-100 w-md-auto" id="otpbtn" onclick="sendOtp('<?php echo $row['email']; ?>')">OTP</button>
                                <button class="btn btn-danger w-100 w-md-auto" id="declineBtn" onclick="showDeclineForm()">Decline</button>
                            </div>

                            <!-- Decline and OTP forms go here (as in your original code) -->
                                    <!-- Decline Form -->
                <div id="declineForm" class="mt-3" style="display: none;">
                    <form action="update-reason.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['booking_id'] ?>">
                        <input type="hidden" name="no" value="<?php echo $row['booking_no'] ?>">
                        <div class="mb-3 text-start">
                            <label for="reason" class="form-label">Write the reason for rejection</label>
                            <input type="text" id="reason" name="reason" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- OTP Form -->
                <div id="otpForm" class="mt-3" style="display: none;">
                    <h5 style="color:green">Enter 4 digit OTP Code</h5>
                    
                    <form method="POST" action="Update_booking.php">
                        <input type="hidden" name="id" value="<?php echo $row['booking_id'] ?>">
                        <input type="hidden" name="no" value="<?php echo $row['booking_no'] ?>">
                        <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                            <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'otp2')" onkeydown="moveBack(event, null)" id="otp1" name="otp1" required>
                            <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'otp3')" onkeydown="moveBack(event, 'otp1')" id="otp2" name="otp2" required>
                            <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 'otp4')" onkeydown="moveBack(event, 'otp2')" id="otp3" name="otp3" required>
                            <input type="text" maxlength="1" class="otp-input" onkeydown="moveBack(event, 'otp3')" id="otp4" name="otp4" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit OTP</button>
                        </div>
                    </form>

                        </div>
                        <!-- CARD ENDS -->
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


          


<script src="script.js"></script>
</body>
<script>


function sendOtp(email) {
    fetch('send_otp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'email=' + encodeURIComponent(email)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('OTP sent to email');
            showOtpForm(); // show OTP input fields
        } else {
            alert('Failed to send OTP: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error);
    });
}

function showDeclineForm(){
    document.getElementById('declineForm').style.display = 'block';
    document.getElementById('declineBtn').style.display = 'none'; // Hide only the Decline button
    document.getElementById('otpForm').style.display = 'none';
    document.getElementById('otpbtn').style.display = 'none';
}


function showOtpForm() {
    document.getElementById('otpForm').style.display = 'block';
    document.getElementById('otpbtn').style.display = 'none'; // fixed ID
    document.getElementById('declineBtn').style.display = 'none';
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
