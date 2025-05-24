<?php

    include_once "connection.php";

    $res=mysqli_query($con,"update booking set booking_status='rejected',payment_status='failed',reason='".$_POST['reason']."' 
    where booking_no='".$_POST['no']."' and booking_id='".$_POST['id']."'");

    if($res)
    {
        echo "<script>alert('Reason has been submitted and booking is rejected')
        window.location.href = 'ongoingbooking.php';
        </script>";
    }
   

?>