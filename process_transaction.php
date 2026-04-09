<?php
session_start();
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$host = 'localhost';
$user = 'root'; 
$password = ''; 
$database = 'user_auth';

// Connect to MySQL (without selecting a database)
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Now, select the database
$conn->select_db($database);

// Create Orders Table if not exists
$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    contact VARCHAR(20),
    address TEXT,
    pincode VARCHAR(10),
    payment_method VARCHAR(50),
    transaction_id VARCHAR(255) DEFAULT NULL,
    order_summary TEXT,
    total_price DECIMAL(10,2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Orders table is ready.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $payment_method = $_POST['payment_method'];
    $order_summary = json_encode($cartItems);
    $total_price = array_sum(array_column($cartItems, 'price'));
    $transaction_id = $payment_method === 'online' ? uniqid('txn_') : NULL;

    // Insert Order into Database
    $stmt = $conn->prepare("INSERT INTO orders (name, email, contact, address, pincode, payment_method, transaction_id, order_summary, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssd", $name, $email, $contact, $address, $pincode, $payment_method, $transaction_id, $order_summary, $total_price);

    if ($stmt->execute()) {
        $_SESSION['order_id'] = $conn->insert_id;
        if ($payment_method === 'cod') {
            header("Location: cash_on_delivery.php");
        } else {
            header("Location: online_payment.php");
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
