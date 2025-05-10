<?php 
 
	 
    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("location:/serviceHub/Signup_login/login.php");
        exit;
    }


    include_once "connection.php";

    $res=mysqli_query($con,"update service_providers set description='".$_POST['description']."',email='".$_POST['email']."',
    phone='".$_POST['no']."',address='".$_POST['address']."',password='".$_POST['password']."' where provider_id='".$_POST['id']."'");
   

    header('location:profile-details.php');

?>