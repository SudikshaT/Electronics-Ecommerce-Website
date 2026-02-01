<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all required fields exist
    if (isset($_POST['name'], $_POST['price'], $_POST['image'])) {
        $product_name = $_POST['name'];
        $product_price = $_POST['price'];
        $product_image = $_POST['image'];
        $product_quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Generate a unique ID for the product in the cart
        $product_id = md5($product_name . time());

        // Add product to cart with unique ID
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => $product_quantity
        ];

        // Set success message
        $_SESSION['message'] = "Product added to cart successfully!";
    } else {
        $_SESSION['message'] = "Error: Missing product details!";
    }

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>
