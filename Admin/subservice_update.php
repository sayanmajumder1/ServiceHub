<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location:adminlog.php");
    exit;
}

include_once "connection.php";

$s_id = mysqli_real_escape_string($con, $_POST['s_id']);
$service_id = mysqli_real_escape_string($con, $_POST['service_id']);
$sub_name = mysqli_real_escape_string($con, $_POST['sub_name']);
$s_des = mysqli_real_escape_string($con, $_POST['s_des']);
$s_price = mysqli_real_escape_string($con, $_POST['s_price']);
$update_image = "";

if (!empty($_FILES['s_img']['tmp_name'])) {
    $f_name = md5(date('YmdHis')) . ".jpg";
    $file_path = "./img/" . $f_name;

    if (move_uploaded_file($_FILES['s_img']['tmp_name'], $file_path)) {
        $update_image = ", image = '$f_name'";
    } else {
        die("Image upload failed.");
    }
}

$sql = "UPDATE subservice SET service_id='$service_id',subservice_name='$sub_name', service_des='$s_des' $update_image WHERE subservice_id = '$s_id'";
$res = mysqli_query($con, $sql);

if (!$res) {
    die("Query failed: " . mysqli_error($con));
}

header("location:managesubservice.php");
?>
