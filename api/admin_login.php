<?php
session_start();
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

// Define your single Admin credentials here
$admin_username = "admin";
$admin_password = "SuperSecretPassword123"; 

if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid admin credentials."]);
}
?>
