<?php

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";

 
    $f_name=md5(date('YmdHis')).".jpg";
    $file_name="./img/".$f_name;
    move_uploaded_file($_FILES['s_img']['tmp_name'],$file_name);

    $query="insert into service set service_name='".$_POST['s_name']."',image='".$f_name."'";

    $res=mysqli_query($con,$query);

    header("location:addservice.php?add=1");
    exit;

?>