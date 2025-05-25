<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";
    

    $res=mysqli_query($con,"delete from service_providers where provider_id='".$_GET['id']."'");

    header("location:rejectprovider.php?rejected=1");
    exit;

?>