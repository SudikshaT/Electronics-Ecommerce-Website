z<?php
session_start();
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cartItems)) {
    $_SESSION['message'] = "Your cart is empty.";
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            background: #0d0d0d;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 30px;
            border-radius: 15px;
            background: rgba(20, 20, 20, 0.9);
            box-shadow: 0px 0px 20px rgba(255, 23, 68, 0.8);
        }
        h2, h3 {
            color: #ff1744;
            text-shadow: 0px 0px 10px #ff1744;
        }
        label {
            font-size: 16px;
            display: block;
            margin: 10px 0;
            text-align: left;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 8px;
            border: none;
            outline: none;
            background: #222;
            color: #fff;
            font-size: 16px;
            box-shadow: 0px 0px 10px rgba(255, 23, 68, 0.5);
            transition: 0.3s ease-in-out;
        }
        input:focus, textarea:focus {
            box-shadow: 0px 0px 15px rgba(255, 235, 59, 0.8);
            border: 1px solid #ffeb3b;
        }
        .btn {
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(45deg, #ff1744, #ffeb3b);
            color: #000;
            text-transform: uppercase;
            transition: 0.4s;
            box-shadow: 0px 0px 15px rgba(255, 23, 68, 0.8);
        }
        .btn:hover {
            background: linear-gradient(45deg, #ffeb3b, #ff1744);
            box-shadow: 0px 0px 20px rgba(255, 235, 59, 0.9);
            color: black;
        }
        .radio-group {
            text-align: left;
            margin: 15px 0;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            font-size: 16px;
            cursor: pointer;
            padding: 5px;
        }
        .radio-group input {
            width: auto;
            margin-right: 10px;
            transform: scale(1.2);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Checkout</h2>
    <form method="POST" action="process_transaction.php">
        <label>Name: <input type="text" name="name" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label>Contact: <input type="text" name="contact" required></label>
        <label>Address: <textarea name="address" required></textarea></label>
        <label>Pincode: <input type="text" name="pincode" required></label>
        
        <h3>Select Payment Method</h3>
        <div class="radio-group">
            <label><input type="radio" name="payment_method" value="cod" required> Cash on Delivery (COD)</label>
            <label><input type="radio" name="payment_method" value="online" required> Online Payment</label>
        </div>
        
        <button type="submit" class="btn">Proceed to Payment</button>
    </form>
</div>

