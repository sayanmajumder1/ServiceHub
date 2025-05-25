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

    $query="insert into subservice set service_id='".$_POST['s_id']."',subservice_name='".$_POST['sub_name']."', service_des='".$_POST['s_des']."',
    image='".$f_name."'";

    $res=mysqli_query($con,$query);

    header("location:addsubservice.php?add=1");
    exit;

?>