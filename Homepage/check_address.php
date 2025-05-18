<?php
session_start();
include_once "db_connect.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['hasAddress' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode([
    'hasAddress' => !empty($user['address'])
]);
?>