<?php
session_start();
include 'db_connect.php'; // Ensure this connects to `user_auth`

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$service_type = $_SESSION['service_type'] ?? 'Cleaning'; // Default to Maintenance

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['electronics'])) {
    $_SESSION['selected_items'] = $_POST['electronics']; // Store selected items in session
    header("Location: cleaning_requests.php"); // Redirect to image capture page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Electronics for Cleaning</title>
    <style>
        body {
            background: #000;
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            margin-top: 50px;
            font-size: 30px;
            color: #ff0000;
        }
        .container {
            margin-top: 50px;
        }
        .checkbox-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .checkbox-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin: 20px;
            cursor: pointer;
            position: relative;
            text-align: center;
            padding: 10px;
            transition: 0.3s;
        }
        .checkbox-label input {
            display: none;
        }

        /* Circle Styles for Each Service */
        .ac .circle {
            background-color: #1e1e1e;
            border: 5px solid #00ff00;
            box-shadow: 0 0 15px #00ff00, 0 0 30px #00ff00;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            transition: 0.3s;
            animation: glowGreen 1.5s ease-in-out infinite alternate;
        }
        .fridge .circle {
            background-color: #1e1e1e;
            border: 5px solid #00ffff;
            box-shadow: 0 0 15px #00ffff, 0 0 30px #00ffff;
            animation: glowCyan 1.5s ease-in-out infinite alternate;
        }
        .tv .circle {
            background-color: #1e1e1e;
            border: 5px solid #ff00ff;
            box-shadow: 0 0 15px #ff00ff, 0 0 30px #ff00ff;
            animation: glowPink 1.5s ease-in-out infinite alternate;
        }
        .washing-machine .circle {
            background-color: #1e1e1e;
            border: 5px solid #ff9900;
            box-shadow: 0 0 15px #ff9900, 0 0 30px #ff9900;
            animation: glowOrange 1.5s ease-in-out infinite alternate;
        }
        .air-cooler .circle {
            background-color: #1e1e1e;
            border: 5px solid #ffff00;
            box-shadow: 0 0 15px #ffff00, 0 0 30px #ffff00;
            animation: glowYellow 1.5s ease-in-out infinite alternate;
        }
        .fan .circle {
            background-color: #1e1e1e;
            border: 5px solid #ff0000;
            box-shadow: 0 0 15px #ff0000, 0 0 30px #ff0000;
            animation: glowRed 1.5s ease-in-out infinite alternate;
        }

        .checkbox-label .circle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            transition: 0.3s;
            cursor: pointer;
        }

        /* Adjusting image size to fit inside circle */
        .checkbox-label img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover; /* Ensures the image fits inside the circle */
            margin-bottom: 10px;
        }

        .checkbox-label span {
            font-size: 16px;
            color: #fff;
            font-weight: bold;
        }

        /* Hover Effects */
        .checkbox-label:hover .circle {
            transform: scale(1.1);
        }

        .checkbox-label input:checked + .circle {
            transform: scale(1.1);
        }

        .checkbox-label input:checked + .circle + span {
            color: #ff0000;
        }

        /* Animations */
        @keyframes glowGreen {
            0% {
                box-shadow: 0 0 15px #00ff00, 0 0 30px #00ff00;
            }
            100% {
                box-shadow: 0 0 25px #00ff00, 0 0 50px #00ff00;
            }
        }
        @keyframes glowCyan {
            0% {
                box-shadow: 0 0 15px #00ffff, 0 0 30px #00ffff;
            }
            100% {
                box-shadow: 0 0 25px #00ffff, 0 0 50px #00ffff;
            }
        }
        @keyframes glowPink {
            0% {
                box-shadow: 0 0 15px #ff00ff, 0 0 30px #ff00ff;
            }
            100% {
                box-shadow: 0 0 25px #ff00ff, 0 0 50px #ff00ff;
            }
        }
        @keyframes glowOrange {
            0% {
                box-shadow: 0 0 15px #ff9900, 0 0 30px #ff9900;
            }
            100% {
                box-shadow: 0 0 25px #ff9900, 0 0 50px #ff9900;
            }
        }
        @keyframes glowYellow {
            0% {
                box-shadow: 0 0 15px #ffff00, 0 0 30px #ffff00;
            }
            100% {
                box-shadow: 0 0 25px #ffff00, 0 0 50px #ffff00;
            }
        }
        @keyframes glowRed {
            0% {
                box-shadow: 0 0 15px #ff0000, 0 0 30px #ff0000;
            }
            100% {
                box-shadow: 0 0 25px #ff0000, 0 0 50px #ff0000;
            }
        }

        .submit-btn {
            background: #ff0000;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 25px;
            margin-top: 30px;
            transition: 0.3s;
            position: relative;
            display: inline-block;
        }
        .submit-btn:hover {
            background: #ff3333;
            box-shadow: 0 0 20px #ff0000;
        }
        .submit-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

    <h2>Select Electronics for Cleaning</h2>

    <div class="container">
        <form method="POST">
            <div class="checkbox-container">
                <label class="checkbox-label ac">
                    <input type="checkbox" name="electronics[]" value="AC cleaning">
                    <div class="circle">
                        <img src="images/accleaning.jpg" alt="AC Cleaning">
                        <span>AC Cleaning</span>
                    </div>
                </label>
                <label class="checkbox-label fridge">
                    <input type="checkbox" name="electronics[]" value="Fridge cleaning">
                    <div class="circle">
                        <img src="images/fridgecleaning.jpg" alt="Fridge Cleaning">
                        <span>Fridge Cleaning</span>
                    </div>
                </label>
                <label class="checkbox-label tv">
                    <input type="checkbox" name="electronics[]" value="TV cleaning">
                    <div class="circle">
                        <img src="images/tvcleaning.jpg" alt="TV Cleaning">
                        <span>TV Cleaning</span>
                    </div>
                </label>
                <label class="checkbox-label washing-machine">
                    <input type="checkbox" name="electronics[]" value="Washing Machine cleaning">
                    <div class="circle">
                        <img src="images/wmcleaning.jpg" alt="Washing Machine Cleaning">
                        <span>Washing Machine Cleaning</span>
                    </div>
                </label>
                <label class="checkbox-label air-cooler">
                    <input type="checkbox" name="electronics[]" value="Air Cooler cleaning">
                    <div class="circle">
                        <img src="images/aircleaning.jpg" alt="Air Cooler Cleaning">
                        <span>Air Cooler Cleaning</span>
                    </div>
                </label>
                <label class="checkbox-label fan">
                    <input type="checkbox" name="electronics[]" value="Fan cleaning">
                    <div class="circle">
                        <img src="images/fancleaning.jpg" alt="Fan Cleaning">
                        <span>Fan Cleaning</span>
                    </div>
                </label>
            </div>
            <button class="submit-btn" type="submit">Submit</button>
        </form>
    </div>

</body>
</html>
