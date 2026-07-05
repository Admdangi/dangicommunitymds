<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: index.html"); exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>User Dashboard</title><style>body{font-family:sans-serif; padding:40px; background:#f4f7f6;} .card{background:white; padding:30px; border-radius:8px; max-width:800px; margin:0 auto; box-shadow:0 4px 10px rgba(0,0,0,0.1);} .btn{padding:10px 20px; background:#e74c3c; color:white; text-decoration:none; border-radius:4px; display:inline-block; margin-top:20px;}</style></head>
<body>
<div class="card">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>
    <p>This is your protected dashboard. You can add your specific content, dairy records, or tables right here.</p>
    <a href="?logout=true" class="btn">Logout</a>
    <?php if (isset($_GET['logout'])) { session_destroy(); header("Location: index.html"); exit; } ?>
</div>
</body>
</html>
