<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("location:/serviceHub/Signup_login/login.php");
    exit;
}

include_once "connection.php";

// Check if file was uploaded
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $f_name = md5(date('YmdHis')) . ".jpg";
    $file_path = "./uploads2/" . $f_name;

    if (move_uploaded_file($_FILES['profile']['tmp_name'], $file_path)) {
        // Update DB
        $email = mysqli_real_escape_string($con, $_SESSION['email']);
        $query = "UPDATE service_providers SET image='$f_name' WHERE email='$email'";
        $res = mysqli_query($con, $query);

        if ($res) {
            header("Location: profile-details.php");
            exit;
        } else {
            echo "Database update failed: " . mysqli_error($con);
        }
    } else {
        echo "Failed to move uploaded file.";
    }
} else {
    echo "No file uploaded or an error occurred.";
}
?>
