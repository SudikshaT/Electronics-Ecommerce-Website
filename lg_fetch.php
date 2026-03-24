<?php
// Get the selected category from the URL
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'Unknown';

// Sample product data for each category
$products = [
    "TV" => [
        ["name" => "Samsung QLED 4K", "image" => "tv1.png", "price" => "₹75,999"],
        ["name" => "Samsung Crystal UHD", "image" => "tv2.png", "price" => "₹52,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv3.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv4.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv5.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv6.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv7.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv8.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv9.png", "price" => "₹75,999"],
        ["name" => "Samsung QLED 4K", "image" => "tv10.png", "price" => "₹75,999"],
    ],
    "Fridge" => [
        ["name" => "Samsung Double Door", "image" => "fr1.png", "price" => "₹32,499"],
        ["name" => "Samsung Side-by-Side", "image" => "fr2.png", "price" => "₹58,999"],
        ["name" => "Samsung Double Door", "image" => "fr3.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr4.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr5.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr6.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr7.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr8.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr9.png", "price" => "₹32,499"],
        ["name" => "Samsung Double Door", "image" => "fr10.png", "price" => "₹32,499"],
    ],
    "AC" => [
        ["name" => "Samsung Split AC", "image" => "ac1.png", "price" => "₹45,999"],
        ["name" => "Samsung Inverter AC", "image" => "ac2.png", "price" => "₹41,999"],
    ],
    "Washing Machine" => [
        ["name" => "Samsung Front Load", "image" => "washing1.png", "price" => "₹29,499"],
        ["name" => "Samsung Top Load", "image" => "washing2.png", "price" => "₹18,999"],
    ]
];

// Get the products for the selected category
$selectedProducts = $products[$category] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $category ?> Products</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: #111;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .back-arrow {
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .navbar h2 {
            color: #ff1744;
            text-shadow: 0 0 10px #ff1744;
            margin: 0 auto;
        }

        /* Product List */
        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }

        .product-card {
            background: #111;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 250px;
            border: 2px solid #ff1744;
            box-shadow: 0 0 10px #ff1744;
            transition: 0.3s;
        }

        .product-card:hover {
            box-shadow: 0 0 20px #ffeb3b;
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }

        .product-name {
            font-size: 18px;
            margin: 10px 0;
            color: #ff1744;
            text-shadow: 0 0 5px #ff1744;
        }

        .product-price {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            background: #ff1744;
            color: white;
            padding: 8px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ffeb3b;
            color: black;
        }

        .fav-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: white;
        }

        .fav-btn.active {
            color: red;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <span class="back-arrow" onclick="goBack()">←</span>
    <h2>Products</h2>
</div>

<!-- Products Section -->
<div class="products-container">
    <?php if (!empty($selectedProducts)) : ?>
        <?php foreach ($selectedProducts as $product) : ?>
            <div class="product-card">
                <img src="./images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="product-price"><?= htmlspecialchars($product['price']) ?></div>
                <div class="buttons">
                    <button class="btn">Add to Cart</button>
                    <button class="btn">Buy Now</button>
                    <button class="fav-btn" onclick="toggleFavorite(this)">❤️</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No products found for <?= htmlspecialchars($category) ?>.</p>
    <?php endif; ?>
</div>

<script>
    function goBack() {
        window.history.back();
    }

    function toggleFavorite(button) {
        button.classList.toggle("active");
    }
</script>

</body>
</html>
