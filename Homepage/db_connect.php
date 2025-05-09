
<?php
$servername = "localhost"; // or "127.0.0.1"
$username = "root";        // default XAMPP/WAMP username
$password = "";            // default is empty in local server
$dbname = "servicehub_data"; // replace with your DB name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


