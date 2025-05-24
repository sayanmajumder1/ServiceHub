<?php

    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("location:/serviceHub/Signup_login/login.php");
        exit;
    }
    include_once "connection.php";
   
    
    $value='accepted';

    $res=mysqli_query($con,"update booking set booking_status='$value'where booking_id='".$_GET['id']."'");

    header("location:bookings.php?accepted=1");
    exit;

?>