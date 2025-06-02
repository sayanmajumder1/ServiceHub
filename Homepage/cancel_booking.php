<?php


session_start(); // Start the session

include_once "db_connect.php";



$res=mysqli_query($conn,"delete from booking where booking_id='".$_GET['id']."'");

header('location:cart.php');

?>