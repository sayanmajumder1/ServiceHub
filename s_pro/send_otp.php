<?php
session_start();
include_once "connection.php";
require_once "smtp/PHPMailerAutoload.php";

if (!isset($_POST['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Email not provided']);
    exit;
}

$email = $_POST['email'];
$otp = rand(1111, 9999);
$_SESSION['OTP'] = $otp;

// Send email using PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "verify.servicehub@gmail.com"; // your Gmail
    $mail->Password = "elyz jwsz ebpx zrsr"; // your App Password
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("verify.servicehub@gmail.com", "ServiceHub");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Your OTP Code";
    $mail->Body = "Your OTP code is: <strong>$otp</strong>";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
}
?>
