<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location:adminlog.php");
    exit;
}

include_once "connection.php";

$s_id = mysqli_real_escape_string($con, $_POST['s_id']);
$s_name = mysqli_real_escape_string($con, $_POST['s_name']);
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

$sql = "UPDATE service SET service_name = '$s_name' $update_image WHERE service_id = '$s_id'";
$res = mysqli_query($con, $sql);

if (!$res) {
    die("Query failed: " . mysqli_error($con));
}

header("location:manageservice.php");
?>
