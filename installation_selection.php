<?php
session_start();
include 'db_connect.php'; // Ensure this connects to `user_auth`

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$service_type = $_SESSION['service_type'] ?? 'Product Installation'; // Default to Maintenance

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['electronics'])) {
    $_SESSION['selected_items'] = $_POST['electronics']; // Store selected items in session
    header("Location: installation_requests.php"); // Redirect to image capture page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Electronics for Product Installation</title>
    <style>
        body {
            background: #000;
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        h2 {
            margin-top: 20px;
            text-shadow: 0 0 10px #ff0000;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .electronic-box {
            width: 200px;
            background: rgba(255, 0, 0, 0.2);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
            text-align: center;
            padding: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .electronic-box:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.8);
        }
        .electronic-box img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .checkbox-label {
            display: block;
            font-size: 16px;
            font-weight: bold;
        }
        .submit-btn {
            background: linear-gradient(45deg, #ff0000, #ff4d4d);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 15px;
            margin-top: 20px;
            transition: 0.4s;
            box-shadow: 0 0 15px #ff3333;
        }
        .submit-btn:hover {
            background: linear-gradient(45deg, #ff3333, #ff6666);
            box-shadow: 0 0 20px #ff0000;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <h2>Select Electronics for Product Installation</h2>

    <form method="POST">
        <div class="container">
            <label class="electronic-box">
                <img src="images/search/tv1.png" alt="TV">
                <input type="checkbox" name="electronics[]" value="TV">
                <span class="checkbox-label">TV</span>
            </label>

            <label class="electronic-box">
                <img src="images/hometheatre.jpg" alt="Home Theatre">
                <input type="checkbox" name="electronics[]" value="Home Theatre">
                <span class="checkbox-label">Home Theatre</span>
            </label>

            <label class="electronic-box">
                <img src="images/search/fr1.png" alt="Fridge">
                <input type="checkbox" name="electronics[]" value="Fridge">
                <span class="checkbox-label">Fridge</span>
            </label>

            <label class="electronic-box">
                <img src="images/ac.jpg" alt="AC">
                <input type="checkbox" name="electronics[]" value="AC">
                <span class="checkbox-label">AC</span>
            </label>
        </div>

        <button class="submit-btn" type="submit">Submit</button>
    </form>

</body>
</html>
