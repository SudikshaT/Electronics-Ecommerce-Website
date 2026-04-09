<?php
session_start();
$message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : "Payment not found.";
unset($_SESSION['success_message']); // Clear the message after displaying
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #0d0d0d;
            color: white;
            padding: 20px;
        }
        .success-box {
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px #00ff00;
            margin-top: 20px;
        }
        .btn {
            background: linear-gradient(45deg, #00ff00, #007bff);
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 10px;
            font-weight: bold;
            color: black;
        }
        .btn:hover {
            background: linear-gradient(45deg, #007bff, #00ff00);
            box-shadow: 0 0 15px #00ff00, 0 0 20px #007bff;
        }
    </style>
</head>
<body>

<h2>Payment Confirmation</h2>

<div class="success-box">
    <h3><?php echo $message; ?></h3>
    <br>
    <a href="index.html" class="btn">Return to Home</a>
</div>

</body>
</html>
