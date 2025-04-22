<?php

    include_once "connection.php";

    /*$query="insert into service set s_name='".$_POST['s_name']."',s_des='".$_POST['s_des']."'";

    $res=mysqli_query($con,$query);

    header("location:dashboard.php");
    */
    $f_name=md5(date('YmdHis')).".jpg";
    $file_name="./img/".$f_name;
    move_uploaded_file($_FILES['s_img']['tmp_name'],$file_name);

    $query="insert into service set s_name='".$_POST['s_name']."',s_des='".$_POST['s_des']."',image='".$f_name."'";

    $res=mysqli_query($con,$query);

    header("location:dashboard.php");
?>