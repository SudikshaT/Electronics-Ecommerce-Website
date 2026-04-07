<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "user_auth";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Order Details
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : null;
$total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

if (!$order_id) {
    header("Location: cart.php");
    exit();
}

// UPI Payment Details
$upi_id = "preethii652@oksbi"; // Your UPI ID
$qr_code = "images/qrcode.jpeg"; // QR Code Image Path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #0d0d0d;
            color: white;
            padding: 20px;
        }
        .payment-box {
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px #ff1744;
            margin-top: 20px;
        }
        .btn {
            background: linear-gradient(45deg, #ff1744, #ffeb3b);
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 10px;
            font-weight: bold;
        }
        .btn:hover {
            background: linear-gradient(45deg, #ffeb3b, #ff1744);
            color: black;
            box-shadow: 0 0 15px #ffeb3b, 0 0 20px #ff1744;
        }
        input {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ff1744;
            margin-top: 10px;
            width: 80%;
        }
    </style>
</head>
<body>

<h2>Complete Your Payment</h2>

<div class="payment-box">
    <h3>Scan QR Code for UPI Payment</h3>
    <img src="<?php echo $qr_code; ?>" alt="QR Code" width="200">
    
    <p><b>UPI ID:</b> <?php echo $upi_id; ?></p>
    
    <form method="POST" action="store_transaction.php">
        <label>Enter Transaction ID:</label><br>
        <input type="text" name="transaction_id" required>
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <br><br>
        <button type="submit" class="btn">Submit Payment</button>
    </form>
</div>

</body>
</html>
