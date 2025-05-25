<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";


    $res=mysqli_query($con,"update admin set name='".$_POST['name']."',username='".$_POST['uname']."',email='".$_POST['umail']."',
    password='".$_POST['upass']."',no='".$_POST['uphone']."' where admin_id='".$_POST['id']."'");

    header("location:adminview.php?add=1");
    exit;
?>