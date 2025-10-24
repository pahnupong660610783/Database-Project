<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$conn = new mysqli("mysql-db", "admin", "admin1234", "shipphi");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

$user_id = intval($_SESSION['user_id']);
$result = $conn->query("SELECT name, lastname, address, email, phone FROM users WHERE id=$user_id");

if ($result && $user = $result->fetch_assoc()) {
    echo json_encode([
        'name' => $user['name'],
        'lastname' => $user['lastname'],
        'address' => $user['address'],
        'email' => $user['email'],
        'phone' => $user['phone']
    ]);
} else {
    echo json_encode(['error' => 'User not found']);
}

$conn->close();
?>
