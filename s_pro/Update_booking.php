<?php
session_start();
include_once "connection.php";

// Retrieve OTP input
$otp1 = $_POST['otp1'] ?? '';
$otp2 = $_POST['otp2'] ?? '';
$otp3 = $_POST['otp3'] ?? '';
$otp4 = $_POST['otp4'] ?? '';
$full_otp = $otp1 . $otp2 . $otp3 . $otp4;

$success = false;
$message = "Invalid OTP";

if ($_SESSION['OTP'] == $full_otp) {
    $res = mysqli_query($con, "
        UPDATE booking 
        SET payment_status='success', booking_status='completed' 
        WHERE booking_no='{$_POST['no']}' AND booking_id='{$_POST['id']}'
    ");
    
    if ($res) {
        $success = true;
        $message = "Your work has been completed successfully!";
    } else {
        $message = "Database update failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verification Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       
    </style>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="taskCompletedModal" tabindex="-1" aria-labelledby="taskCompletedLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- ADDED THIS CLASS -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="taskCompletedLabel">MESSAGE</h5>
        </div>
        <div class="modal-body">
          <?php echo"$message"?>
        </div>
        <div class="modal-footer">
            <a href="ongoingbooking.php" class="btn btn-primary">OK</a>
        </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    var myModal = new bootstrap.Modal(document.getElementById('taskCompletedModal'));
    myModal.show();
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
