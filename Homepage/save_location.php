<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $lat = $_POST['lat'] ?? null;
    $lng = $_POST['lng'] ?? null;
    
    $_SESSION['user_location'] = $name;
    $_SESSION['user_location_coords'] = ['lat' => $lat, 'lng' => $lng];
    
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);