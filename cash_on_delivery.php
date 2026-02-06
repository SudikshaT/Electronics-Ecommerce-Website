<?php
session_start();
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : null;
if (!$order_id) {
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        body { background: #0d0d0d; color: #fff; font-family: Arial, sans-serif; text-align: center; }
        .container { width: 50%; margin: auto; padding: 20px; border-radius: 10px; background: #222; }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Confirmed</h2>
    <p>Your order #<?php echo $order_id; ?> has been placed successfully.</p>
    <p>It will be delivered to your address soon.</p>
</div>

</body>
</html>
