<?php
$conn = mysqli_connect("localhost", "root", "", "servicehub_data");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4"); // Fixes character encoding
?>