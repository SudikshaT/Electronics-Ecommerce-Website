<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_auth");

if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}

// Fetch all tables dynamically
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { font-family: Arial, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { display: flex; background: #000; color: #fff; }
        
        .sidebar { width: 250px; background: rgba(255, 255, 255, 0.1); padding: 20px; height: 100vh; }
        .sidebar h2 { color: #ff6b6b; text-align: center; margin-bottom: 20px; }
        .sidebar a { display: block; color: #fff; padding: 10px; text-decoration: none; border-radius: 5px; }
        .sidebar a:hover { background: #ff6b6b; }
        
        .content { flex-grow: 1; padding: 20px; }
        .header { text-align: center; font-size: 24px; margin-bottom: 20px; color: #ff6b6b; }
        
        .table-list { background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 10px; display: flex; flex-wrap: wrap; gap: 10px; }
        .table-list a { 
            background: #111; color: cyan; padding: 10px 15px; 
            border: 1px solid cyan; text-decoration: none; border-radius: 8px; 
            transition: 0.3s ease-in-out;
        }
        .table-list a:hover { background: cyan; color: #111; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Shri Ram Electronics</h2>
        <a href="admin_profile.php">Profile</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <div class="header">Admin Dashboard</div>
        <div class="table-list">
            <h3>Database Tables</h3>
            <?php foreach ($tables as $table): ?>
                <a href="view_tables.php?table=<?= $table ?>"><?= ucfirst(str_replace("_", " ", $table)) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
