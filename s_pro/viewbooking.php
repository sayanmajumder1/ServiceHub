<?php
	 
	 session_start();
     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }

    
                          
 
   
  

      $OTP=rand(1111,9999);
      $_SESSION['OTP']=$OTP; 

   
          
           

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
                       
                    </div>
                 
                </div>
                        <!-- Payment and Decline Buttons -->
                        <div class="mt-3" id="actionButtons">
                            <button class="btn btn-success" id="otpbtn" onclick="showOtpForm()">OTP</button>
                            <button class="btn btn-danger" id="declineBtn" onclick="showDeclineForm()">Decline</button>
                        </div>

                            
   
                      
                        <!--Decline Form (Initially Hidden) -->
                        <div id="declineForm" class="mt-3" style="display: none;">
                            <form action="update-reason.php" method="POST" >
                                <div class="mb-3">
                                    <input type="text" id="no" name="no" value="<?php echo $row['booking_no']?>"class="form-control" hidden>  
                                    <label for="amount" class="form-label">Write the Reason for reject</label>
                                    <input type="text" id="reason" name="reason" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit </button>
                            </form>
                        </div>

                                

                                <!-- OTP Form (Initially Hidden) -->
                                <div id="otpForm" style="display: none;" class="mt-3">
                                   
                                    <h5 style="color:green">Enter 4 digit OTP Code</h5>
                                    <p style="color:green">Your 4 digits OTP code is :<?php echo $_SESSION['OTP'] ?></p>
                                    <form method="POST" action="Update_booking.php">
                                        <div class="d-flex justify-content-center mb-3">
                                            <input type="text" id="no" name="no" value="<?php echo $row['booking_no']?>"class="form-control" hidden>
                                            <input type="text" maxlength="1" class="otp-input"
                                                oninput="moveToNext(this, 'otp2')" onkeydown="moveBack(event, null)" id="otp1" name="otp1" autofocus required>
                                            <input type="text" maxlength="1" class="otp-input"
                                                oninput="moveToNext(this, 'otp3')" onkeydown="moveBack(event, 'otp1')" id="otp2" name="otp2" required>
                                            <input type="text" maxlength="1" class="otp-input"
                                                oninput="moveToNext(this, 'otp4')" onkeydown="moveBack(event, 'otp2')" id="otp3" name="otp3" required>
                                            <input type="text" maxlength="1" class="otp-input"
                                                onkeydown="moveBack(event, 'otp3')" id="otp4" name="otp4" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Submit OTP</button>
                                        </div>
                                    </form>
                                </div>
                    <?php
                        }
                    ?>
            </div>
        </div>
          


<script src="script.js"></script>
</body>
<script>

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
