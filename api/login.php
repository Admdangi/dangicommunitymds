<?php
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$loginId = $conn->real_escape_string($data['loginId']);
$password = $data['password'];

// Find user by either email or mobile
$result = $conn->query("SELECT * FROM users WHERE email='$loginId' OR mobile='$loginId'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verify password hash
    if (password_verify($password, $row['password_hash'])) {
        echo json_encode(["status" => "success", "message" => "Login successful! Welcome."]);
        // Here you would typically start a PHP session or generate a JWT token
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
}
$conn->close();
?>
