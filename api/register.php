<?php
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($data['email']);
$mobile = $conn->real_escape_string($data['mobile']);
$password = $data['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insertUser = "INSERT INTO users (email, mobile, password_hash) VALUES ('$email', '$mobile', '$hashed_password')";

if ($conn->query($insertUser) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Registration successful! Please login."]);
} else {
    echo json_encode(["status" => "error", "message" => "User with this Email or Mobile already exists."]);
}
$conn->close();
?>
