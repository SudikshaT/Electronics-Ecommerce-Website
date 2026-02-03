<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_auth");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["admin"] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Your existing CSS remains unchanged */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #000; color: #fff; }
        .login-container { background: rgba(255, 255, 255, 0.1); padding: 30px; border-radius: 10px; text-align: center; animation: neon-border 1.5s infinite alternate; }
        @keyframes neon-border { 0% { border-color: #ff6b6b; box-shadow: 0 0 20px #ff6b6b; } 50% { border-color: #1db954; box-shadow: 0 0 20px #1db954; } 100% { border-color: #00aaff; box-shadow: 0 0 20px #00aaff; } }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 10px; border: none; border-radius: 5px; background: #222; color: #fff; }
        .glow-on-hover { width: 100%; height: 50px; border: none; outline: none; color: #fff; background: #111; cursor: pointer; border-radius: 10px; font-size: 16px; font-weight: bold; }
        .glow-on-hover:hover { box-shadow: 0 0 20px #fff; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="glow-on-hover">Login</button>
        </form>
    </div>
</body>
</html>
