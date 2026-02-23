<?php
// Define Discounts manually
$discounts = ["discount1.png", "discount2.png", "discount3.png", "discount4.png", "discount5.png"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discounts</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .discount-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .discount-item {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
            overflow: hidden;
        }

        .discount-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background: #ff1744;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
        }

        .back-btn:hover {
            background: #d01133;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.9);
        }
    </style>
</head>
<body>
    <h2>Exclusive Discounts</h2>
    <div class="discount-container">
        <?php foreach ($discounts as $discountImage) : ?>
            <div class="discount-item">
                <img src="./images/<?= htmlspecialchars($discountImage) ?>" alt="Discount">
            </div>
        <?php endforeach; ?>
    </div>

    <button class="back-btn" onclick="goBack()">Go Back</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>