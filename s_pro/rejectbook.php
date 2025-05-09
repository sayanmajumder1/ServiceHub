<?php

    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("location:/project_php/serviceHub/Signup_login/login.php");
        exit;
    }
    include_once "connection.php";
   
    
    $value='rejected';

    $res=mysqli_query($con,"update booking set booking_status='$value'where booking_id='".$_GET['id']."'");

    header("location:total_bookings.php");

?>