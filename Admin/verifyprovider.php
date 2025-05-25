<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";
    $value='approved';

    $res=mysqli_query($con,"update service_providers set approved_action='$value' where provider_id='".$_GET['id']."'");

    header("location:addprovider.php?accepted=1");
    exit;

?>