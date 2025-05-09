<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";


    $res=mysqli_query($con,"update service set service_name='".$_POST['s_name']."' where service_id='".$_POST['s_id']."'");

    header("location:manageservice.php");
?>