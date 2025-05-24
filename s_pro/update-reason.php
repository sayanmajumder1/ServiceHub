<?php

    include_once "connection.php";

    $res=mysqli_query($con,"update booking set booking_status='rejected',payment_status='failed',reason='".$_POST['reason']."' 
    where booking_no='".$_POST['no']."' and booking_id='".$_POST['id']."'");



        if ($res) {
            header("Location: ongoingbooking.php?status=success");
            exit();
        } else {
            header("Location: ongoingbooking.php?status=error");
            exit();
        }


   

?>