<?php
session_start();
include 'db_connect.php'; // Ensure this connects to `user_auth`

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$service_type = $_SESSION['service_type'] ?? 'Product Replacement'; // Default to Maintenance

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['electronics'])) {
    $_SESSION['selected_items'] = $_POST['electronics']; // Store selected items in session
    header("Location: product_replacement_requests.php"); // Redirect to image capture page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Electronics for Product Replacement</title>
    <style>
        /* Global Styles */
        body {
            background: #111;
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            color: #ff4b4b;
            font-size: 32px;
            margin-bottom: 40px;
            text-shadow: 0 0 15px rgba(255, 75, 75, 0.7);
        }

        /* Container for the form */
        .container {
            background: #1a1a1a;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 75, 75, 0.5);
            max-width: 500px;
            width: 100%;
            text-align: left;
        }

        /* Styling for each electronics box */
        .electronics-box {
            background: #2c2c2c;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 75, 75, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: 0.3s ease;
        }

        .electronics-box:hover {
            background: #333;
            box-shadow: 0 0 15px rgba(255, 75, 75, 0.7);
        }

        /* Image inside each box - Increased size */
        .electronics-box img {
            width: 70px; /* Increased width */
            height: 70px; /* Increased height */
            margin-right: 20px;
        }

        /* Checkbox Label inside each box */
        .electronics-box label {
            font-size: 18px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        /* Custom Checkbox Style */
        .electronics-box input[type="checkbox"] {
            margin-right: 10px;
            width: 20px;
            height: 20px;
            background-color: #333;
            border: 2px solid #ff4b4b;
            border-radius: 5px;
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Checked checkbox styling */
        .electronics-box input[type="checkbox"]:checked {
            background-color: #ff4b4b;
            border-color: #ff4b4b;
            box-shadow: 0 0 5px rgba(255, 75, 75, 0.7);
        }

        .electronics-box input[type="checkbox"]:checked::before {
            content: '✔';
            color: white;
            position: absolute;
            top: 0;
            left: 3px;
            font-size: 18px;
        }

        /* Button Styling */
        .submit-btn {
            background: #ff4b4b;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 20px;
            transition: 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background: #ff7373;
            box-shadow: 0 0 20px rgba(255, 75, 75, 0.7);
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 90%;
            }

            .electronics-box {
                flex-direction: column;
                align-items: flex-start;
            }

            .electronics-box img {
                margin-bottom: 10px;
            }

            .submit-btn {
                padding: 12px 25px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <h2>Select Electronics for Product Replacement</h2>

    <div class="container">
        <form method="POST">
            <div class="electronics-box">
                <img src="images/search/tv4.png" alt="TV Icon">
                <label>
                    <input type="checkbox" name="electronics[]" value="TV inches">
                    TV inches
                </label>
            </div>
            <div class="electronics-box">
                <img src="images/search/fr4.png" alt="Fridge Icon">
                <label>
                    <input type="checkbox" name="electronics[]" value="Fridge type">
                    Fridge type
                </label>
            </div>
            <div class="electronics-box">
                <img src="images/ac.jpg" alt="AC Icon">
                <label>
                    <input type="checkbox" name="electronics[]" value="AC with stabilizer">
                    AC with stabilizer
                </label>
            </div>

            <button class="submit-btn" type="submit">Submit</button>
        </form>
    </div>

</body>
</html>
