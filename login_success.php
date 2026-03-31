<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: user_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Success</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }
        .loader {
            border: 5px solid rgba(255, 255, 255, 0.1);
            border-top: 5px solid #ff0000;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <h2>Login Successful!</h2>
    <p>Redirecting to Dashboard...</p>
    <div class="loader"></div>

    <script>
        setTimeout(() => {
            window.location.href = "user_dashboard.php"; // Ensure file exists
        }, 3000);
    </script>
</body>
</html>
