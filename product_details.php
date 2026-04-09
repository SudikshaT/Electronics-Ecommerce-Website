<?php
session_start();

// Get product details from the URL parameters
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Unknown";
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : "Unknown";
$image = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : "default.png";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($name) ?> - Product Details</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        .product-img {
            width: 300px;
            height: auto;
            border: 2px solid #ff1744;
            border-radius: 10px;
            box-shadow: 0 0 10px #ff1744;
        }

        .product-name {
            font-size: 24px;
            margin: 10px 0;
            color: #ff1744;
            text-shadow: 0 0 5px #ff1744;
        }

        .product-price {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .btn {
            background: #ff1744;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
            margin: 5px;
        }

        .btn:hover {
            background: #ffeb3b;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Product Details</h2>
    <img class="product-img" src="./images/search/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
    <div class="product-name"><?= htmlspecialchars($name) ?></div>
    <div class="product-price"><?= htmlspecialchars($price) ?></div>

    <form action="add_to_cart.php" method="POST">
        <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">
        <input type="hidden" name="image" value="<?= htmlspecialchars($image) ?>">
        <button type="submit" class="btn">Add to Cart </button>
    </form>

    <a href="cart.php" class="btn">Go to Cart</a>
</div>

</body>
</html>
