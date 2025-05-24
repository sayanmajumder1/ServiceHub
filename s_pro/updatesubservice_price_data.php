<?php

    session_start();
   
	 

     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }

    include_once "connection.php";

    $res=mysqli_query($con,"update subservice_price_map set price='".$_POST['price']."' where subprice_id='".$_POST['id']."'");

    header('location:manageservices.php?status=1');
    exit;

?>