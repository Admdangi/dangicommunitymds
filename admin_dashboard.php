<?php
session_start();
// Kick out anyone who isn't logged in as Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.html"); exit;
}

require 'api/db.php';
$result = $conn->query("SELECT id, email, mobile, created_at FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Registered Members</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background:#f4f7f6; margin:0;} 
        .header { background: #2c3e50; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: 8px; margin-bottom: 20px;}
        .header a { color: white; text-decoration: none; background: #e74c3c; padding: 8px 15px; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #ecf0f1; }
    </style>
</head>
<body>

<div class="header">
    <h2>Secure Admin Panel</h2>
    <a href="?logout=true">Secure Logout</a>
</div>

<table>
    <tr><th>ID</th><th>Email Address</th><th>Mobile Number</th><th>Join Date</th></tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['created_at']}</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4' style='text-align:center;'>No members registered yet.</td></tr>";
    }
    ?>
</table>

<?php 
// Admin logout logic
if (isset($_GET['logout'])) { 
    session_destroy(); 
    header("Location: admin.html"); 
    exit; 
} 
$conn->close();
?>
</body>
</html>
