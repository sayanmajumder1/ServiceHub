<?php

    session_start();
   
	 

     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }

     include_once "connection.php";

     $res=mysqli_query($con,"insert into subservice_price_map set service_id='".$_POST['service_id']."',subservice_id='".$_POST['subservice_id']."',
     provider_id='".$_POST['provider_id']."',price='".$_POST['price']."'");

     header('location:manageservices.php?add=1');
     exit;

?>