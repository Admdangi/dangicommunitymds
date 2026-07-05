<?php
$host = 'localhost';
$dbname = 'secure_portal';
$username = 'root'; 
$password = '';     

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}
?>
