<?php
session_start();
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$loginId = $conn->real_escape_string($data['loginId']);
$password = $data['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$loginId' OR mobile='$loginId'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password_hash'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $row['email'];
        echo json_encode(["status" => "success", "message" => "Login successful! Redirecting..."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
}
$conn->close();
?>
