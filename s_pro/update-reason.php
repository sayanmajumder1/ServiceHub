<?php

    include_once "connection.php";

    $res=mysqli_query($con,"update booking set booking_status='rejected',payment_status='failed',reason='".$_POST['reason']."' where booking_no='".$_POST['no']."'");

    if($res)
    {
        echo "<script>alert('Reason has been submitted and booking is rejected')</script>";
    }
    header('location:ongoingbooking.php');

?>