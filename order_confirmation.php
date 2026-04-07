<?php
session_start();

// Check if the cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "No order found. Please add items.";
    header("Location: cart.php");
    exit();
}

// Retrieve order details
$cartItems = $_SESSION['cart'];
$totalAmount = array_sum(array_column($cartItems, 'price'));
$paymentMethod = $_SESSION['payment_method'] ?? 'COD';
$transactionID = $_SESSION['transaction_id'] ?? null;

// Clear cart after order confirmation
unset($_SESSION['cart']);
unset($_SESSION['transaction_id']);
unset($_SESSION['payment_method']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #e60000;
        }
        .confirmation-message {
            font-size: 22px;
            color: #e60000;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .order-summary {
            background: #292929;
            padding: 15px;
            border-radius: 8px;
        }
        .order-summary h3 {
            color: #e60000;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #444;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 0 5px #e60000;
            margin-right: 15px;
        }
        .product-info {
            text-align: left;
        }
        .product-name {
            font-weight: bold;
            color: #fff;
        }
        .product-price {
            color: #e60000;
            font-size: 18px;
        }
        .total-amount {
            font-size: 22px;
            font-weight: bold;
            color: #e60000;
            margin-top: 15px;
        }
        .btn {
            background: #e60000;
            color: #fff;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #cc0000;
        }
        .thank-you {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #e60000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎉 Order Successful 🎉</h2>
        <p class="confirmation-message">Thank you! Your order has been placed successfully.</p>

        <div class="order-summary">
            <h3>🛒 Order Summary</h3>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($cartItems as $item): ?>
                    <li class="order-item">
                        <?php 
                            $imagePath = !empty($item['image']) ? "/sreee/images/" . htmlspecialchars($item['image']) : "placeholder.png";
                        ?>
                        <img src="<?php echo $imagePath; ?>" 
                             alt="Product Image" 
                             class="product-image"
                             onerror="this.onerror=null; this.src='placeholder.png';">
                        <div class="product-info">
                            <span class="product-name"><?php echo htmlspecialchars($item['name']); ?></span><br>
                            <span class="product-price">₹<?php echo htmlspecialchars($item['price']); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <h3>🧾 Billing Details</h3>
<p>Payment Method: <strong><?php echo htmlspecialchars($paymentMethod); ?></strong></p>
<?php if ($paymentMethod == 'Online' && !empty($transactionID)): ?>
    <p>Transaction ID: <strong><?php echo htmlspecialchars($transactionID); ?></strong></p>
<?php endif; ?>


        <p class="total-amount">Total Amount: ₹<?php echo $totalAmount; ?></p>

        <p class="thank-you">🙏 Thank you for shopping with us! Visit again. 🙏</p>

        <a href="feedback.php" class="btn">Give Feedback</a>
        <a href="user_dashboard.php" class="btn">Back to Home</a>
    </div>
</body>
</html>
