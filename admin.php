<?php
// Connect to the database
require 'api/db.php';

// Fetch all users, newest first
$query = "SELECT id, email, mobile, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Registered Users</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .empty-msg { text-align: center; color: #666; font-style: italic; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Users Overview</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email ID</th>
                <th>Mobile Number</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Format the date to be more readable
                    $date = date("d M Y, h:i A", strtotime($row['created_at']));
                    echo "<tr>
                            <td>#{$row['id']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['mobile']}</td>
                            <td>{$date}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='empty-msg'>No users have registered yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php $conn->close(); ?>
