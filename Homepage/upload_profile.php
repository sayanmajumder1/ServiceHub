<?php
include_once "db_connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ✅ Handle profile image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imgName = $_FILES['image']['name'];
        $imgTmp = $_FILES['image']['tmp_name'];

        // Generate new unique name with date and user ID
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        $newImgName = date("Y-m-d_His") . "_user_" . $user_id . "." . $ext;

        $uploadDir = "assets/images/";
        $targetFile = $uploadDir . $newImgName;

        if (move_uploaded_file($imgTmp, $targetFile)) {
            $query = "UPDATE users SET image = '$newImgName', updated_at = NOW() WHERE user_id = $user_id";
            mysqli_query($conn, $query);
        }
        header("Location: profile.php?image_uploaded=1");
        exit();
    }

    // ✅ Handle profile data update
    if (isset($_POST['update_profile'])) {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $query = "UPDATE users SET 
                    name = '$first_name',
                    phone = '$phone',
                    dob='$dob',
                    updated_at = NOW()
                  WHERE user_id = $user_id";

        if (mysqli_query($conn, $query)) {
            header("Location: home.php?success=1");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        exit();
    }
}
?>
