<?php
session_start();

// Check if a new product is added
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? '';
    $product_image = $_POST['product_image'] ?? 'placeholder.png';

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart
    $_SESSION['cart'][] = [
        'name'  => htmlspecialchars($product_name),
        'price' => htmlspecialchars($product_price),
        'image' => htmlspecialchars($product_image)
    ];

    // Set success message
    $_SESSION['message'] = "Item added to cart!";
    
    // Redirect to cart page
    header("Location: cart.php");
    exit();
}

// Retrieve cart items
$cartItems = $_SESSION['cart'] ?? [];
$message = $_SESSION['message'] ?? "";

// Clear the message after displaying
unset($_SESSION['message']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        /* Container */
        .container {
            width: 60%;
            margin: auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px #e60000;
        }

        /* Success Message */
        .message {
            background: #e60000;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Cart Items */
        .cart-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            padding: 15px;
        }

        /* Individual Cart Item */
        .cart-item {
            display: flex;
            align-items: center;
            background: #292929;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px #e60000;
            justify-content: space-between;
        }

        /* Product Image */
        .cart-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
            box-shadow: 0 0 5px #e60000;
        }

        /* Button Styling */
        .btn {
            background: #e60000;
            color: #fff;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }

        .btn:hover {
            background: #cc0000;
        }

        /* Checkout & Continue Shopping */
        .cart-actions {
            margin-top: 20px;
        }

        .checkout-btn {
            font-size: 18px;
            padding: 12px 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Cart</h2>

    <!-- Success Message -->
    <?php if ($message) : ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <div class="cart-container">
        <?php if (!empty($cartItems)) : ?>
            <?php foreach ($cartItems as $index => $item) : ?>
                <div class="cart-item">
                    <img class="cart-img" src="./images/search/<?= htmlspecialchars($item['image']) ?>" 
                         alt="<?= htmlspecialchars($item['name']) ?>" 
                         onerror="this.src='placeholder.png'">
                    <div>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <div style="color: #e60000; font-size: 18px;">₹<?= htmlspecialchars($item['price']) ?></div>
                    </div>

                    <form action="remove_from_cart.php" method="POST">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" class="btn">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <div class="cart-actions">
        <a href="category.php" class="btn">Continue Shopping</a>
        <?php if (!empty($cartItems)) : ?>
            <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
