<?php

    session_start();
// submit_contact.php
include 'db_connect.php'; // Make sure your DB connection is here

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages set name='".$_POST['name']."',email='".$_POST['email']."',message='".$_POST['message']."'";

    if (mysqli_query($conn, $sql)) {
        header("Location: contact.php?status=success");
    } else {
        header("Location: contact.php?status=error");
    }

    $conn->close();
}
?>
