<?php
header("Content-Type: application/json");
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($data['email']);
$mobile = $conn->real_escape_string($data['mobile']);

if (empty($email) || empty($mobile)) {
    echo json_encode(["status" => "error", "message" => "Email and Mobile are required."]);
    exit;
}

// Check if user already exists
$checkUser = $conn->query("SELECT id FROM users WHERE email='$email' OR mobile='$mobile'");
if ($checkUser->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "User already exists. Please login."]);
    exit;
}

// Generate 6-digit OTP
$otp = rand(100000, 999999);

// Store OTP in database
$sql = "INSERT INTO otp_requests (email, mobile, otp) VALUES ('$email', '$mobile', '$otp')";

if ($conn->query($sql) === TRUE) {
    // IN PRODUCTION: Integrate your SMS/Email API here to actually send the $otp variable to the user.
    // For this testing environment, we are returning the OTP in the response so you can copy-paste it.
    echo json_encode([
        "status" => "success", 
        "message" => "OTP generated successfully.",
        "test_otp" => $otp // REMOVE THIS LINE IN PRODUCTION
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to generate OTP."]);
}
$conn->close();
?>
