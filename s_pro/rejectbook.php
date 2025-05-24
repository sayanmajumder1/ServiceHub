<?php

    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("location:/serviceHub/Signup_login/login.php");
        exit;
    }
    include_once "connection.php";
   
    if (!isset($_GET['id'])) {
        die("Missing booking ID.");
    }
    $value='rejected';
    $value1='failed';

    $res=mysqli_query($con,"update booking set booking_status='$value' ,payment_status='$value1' where booking_id='".$_GET['id']."'");

    header('location:bookings.php?rejected=1');
     exit;
?>