<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";

    $res=mysqli_query($con,"delete from subservice where subservice_id='".$_GET['id']."'");

    header("Location:managesubservice.php?delete=1");
    exit;


?>