<?php
$host = 'localhost';
$dbname = 'auth_system';
$username = 'root'; // Default XAMPP username
$password = '';     // Default XAMPP password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}
?>
