<?php
session_start();
include_once "connection.php";

// Retrieve OTP input
$otp1 = $_POST['otp1'] ?? '';
$otp2 = $_POST['otp2'] ?? '';
$otp3 = $_POST['otp3'] ?? '';
$otp4 = $_POST['otp4'] ?? '';
$full_otp = $otp1 . $otp2 . $otp3 . $otp4;

if ($_SESSION['OTP'] == $full_otp) {
    $res = mysqli_query($con, "UPDATE booking SET  payment_status='success', booking_status='completed' WHERE booking_no='{$_POST['no']}' and
    booking_id='".$_POST['id']."'");
    
    if ($res) {
        
        echo "<script>
            alert('Your work has been completed');
            window.location.href = 'ongoingbooking.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Database update failed');
            window.location.href = 'ongoingbooking.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Invalid OTP');
        window.location.href = 'ongoingbooking.php';
    </script>";
    exit;
}
?>
