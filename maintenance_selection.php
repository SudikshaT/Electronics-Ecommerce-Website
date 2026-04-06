<?php
session_start();
include 'db_connect.php'; // Ensure this connects to `user_auth`

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$service_type = $_SESSION['service_type'] ?? 'Maintenance'; // Default to Maintenance

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['electronics'])) {
    $_SESSION['selected_items'] = $_POST['electronics']; // Store selected items in session
    header("Location: maintenance_requests.php"); // Redirect to image capture page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Electronics for Maintenance</title>
    <style>
        body {
            background: #000;
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px #00ffff;
        }
        .container {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .electronic-item {
            background: rgba(255, 0, 0, 0.2);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 200px;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s forwards;
        }
        /* Animations for appearing one by one */
        .electronic-item:nth-child(1) { animation-delay: 0.3s; background: rgba(255, 0, 255, 0.2); box-shadow: 0 0 15px #ff00ff; }
        .electronic-item:nth-child(2) { animation-delay: 0.6s; background: rgba(0, 255, 255, 0.2); box-shadow: 0 0 15px #00ffff; }
        .electronic-item:nth-child(3) { animation-delay: 0.9s; background: rgba(0, 255, 0, 0.2); box-shadow: 0 0 15px #00ff00; }
        .electronic-item:nth-child(4) { animation-delay: 1.2s; background: rgba(255, 165, 0, 0.2); box-shadow: 0 0 15px #ffa500; }
        .electronic-item:nth-child(5) { animation-delay: 1.5s; background: rgba(255, 255, 0, 0.2); box-shadow: 0 0 15px #ffff00; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .electronic-item:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.9);
        }
        .electronic-item img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .checkbox-label {
            display: block;
            font-size: 18px;
        }
        .submit-btn {
            background: #00ff00;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 20px;
            transition: 0.3s;
            box-shadow: 0 0 15px #00ff00;
            animation: pulse 1.5s infinite alternate;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 10px #00ff00; transform: scale(1); }
            100% { box-shadow: 0 0 20px #ff00ff; transform: scale(1.1); }
        }
        .submit-btn:hover {
            background: #ff00ff;
            box-shadow: 0 0 25px #ff00ff;
            transform: scale(1.2);
        }
    </style>
</head>
<body>

    <h2>Select Electronics for Maintenance</h2>

    <form method="POST">
        <div class="container">
            <label class="electronic-item">
                <img src="images/tv.jpg" alt="TV">
                <input type="checkbox" name="electronics[]" value="TV">
                <span class="checkbox-label">TV</span>
            </label>
            <label class="electronic-item">
                <img src="images/refridgerator.jpg" alt="Fridge">
                <input type="checkbox" name="electronics[]" value="Fridge">
                <span class="checkbox-label">Fridge</span>
            </label>
            <label class="electronic-item">
                <img src="images/ac.jpg" alt="AC">
                <input type="checkbox" name="electronics[]" value="AC">
                <span class="checkbox-label">AC</span>
            </label>
            <label class="electronic-item">
                <img src="images/washingmachine.jpg" alt="Washing Machine">
                <input type="checkbox" name="electronics[]" value="Washing Machine">
                <span class="checkbox-label">Washing Machine</span>
            </label>
            <label class="electronic-item">
                <img src="images/aircooler.jpg" alt="Air Cooler">
                <input type="checkbox" name="electronics[]" value="Air Cooler">
                <span class="checkbox-label">Air Cooler</span>
            </label>
        </div>
        <button class="submit-btn" type="submit">Submit</button>
    </form>

</body>
</html>
