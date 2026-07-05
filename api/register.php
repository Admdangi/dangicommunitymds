<?php
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($data['email']);
$mobile = $conn->real_escape_string($data['mobile']);
$otp = $conn->real_escape_string($data['otp']);
$password = $data['password'];

// Verify OTP (Fetch the latest OTP for this contact combo)
$otpCheck = $conn->query("SELECT * FROM otp_requests WHERE email='$email' AND mobile='$mobile' AND otp='$otp' ORDER BY created_at DESC LIMIT 1");

if ($otpCheck->num_rows > 0) {
    // OTP matches, hash password and save user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $insertUser = "INSERT INTO users (email, mobile, password_hash) VALUES ('$email', '$mobile', '$hashed_password')";
    
    if ($conn->query($insertUser) === TRUE) {
        // Clean up used OTPs for security
        $conn->query("DELETE FROM otp_requests WHERE email='$email'");
        
        echo json_encode(["status" => "success", "message" => "Registration successful! You can now login."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid OTP."]);
}
$conn->close();
?>
