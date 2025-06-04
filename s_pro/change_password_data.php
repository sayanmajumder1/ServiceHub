
<?php 
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: /serviceHub/Signup_login/login.php");
    exit;
}

include_once "connection.php";

$provider_id = $_POST['id'];
$current_password = $_POST['pass1']; 
$new_password = $_POST['pass2'];



// Get the existing password from DataBase
$query = "SELECT password FROM service_providers WHERE provider_id = '$provider_id'";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);
$existing_password = $row['password'];

if ($existing_password === $current_password) 
{
        // Passwords match — update to new password
        $update_query = "UPDATE service_providers SET password = '$new_password' WHERE provider_id = '$provider_id'";
        mysqli_query($con, $update_query);
        header('Location: profile-details.php?status=2'); // success
        exit;
} 
else 
{
        // Passwords do not match
        header('Location: profile-details.php?status=3'); // password mismatch
        exit;
}

?>
