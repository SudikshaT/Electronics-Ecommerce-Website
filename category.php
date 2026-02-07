<?php
// Define brands manually
$brands = [
    ["brand_name" => "Samsung", "brand_logo" => "samsung.png"],
    ["brand_name" => "Voltas", "brand_logo" => "voltas.png"],
    ["brand_name" => "Bluestar", "brand_logo" => "bluestar.png"],
    ["brand_name" => "Daiken", "brand_logo" => "daikin.png"],
    ["brand_name" => "Ogeneral", "brand_logo" => "ogeneral.png"],
    ["brand_name" => "mitsubishi", "brand_logo" => "mitsubishi.png"],
    ["brand_name" => "Sony", "brand_logo" => "sony.png"],
    ["brand_name" => "Godrej", "brand_logo" => "godrej.png"],
    ["brand_name" => "Panasonic", "brand_logo" => "panasonic.png"],
    ["brand_name" => "Haier", "brand_logo" => "haier.png"],
    ["brand_name" => "LG", "brand_logo" => "lg.png"],
    ["brand_name" => "whirlpool", "brand_logo" => "whirlpool.png"],
     ["brand_name" => "Toshiba", "brand_logo" => "toshiba.png"],
    ["brand_name" => "philips", "brand_logo" => "philips.png"],
    ["brand_name" => "IFB", "brand_logo" => "ifb.png"],
    ["brand_name" => "venus", "brand_logo" => "venus.png"],
    ["brand_name" => "vguard", "brand_logo" => "vguard.png"]
];

// Define Discount and Hot Offers manually
$discounts = ["discount1.png", "discount2.png", "discount3.png"];
$hotOffers = ["offer1.jpg", "offer2.jpg", "offer3.jpg"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Brand</title>
    <style>
        /* General Styling */
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 20%;
            padding: 20px;
            background: #111;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 4px 0 10px rgba(255, 0, 0, 0.5);
        }

        .sidebar h3 {
            margin-bottom: 15px;
            color: #ff1744;
            text-shadow: 0 0 8px #ff1744;
        }

        .sidebar img {
            width: 90%;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
        }

        /* Discount Button */
        .discount-btn {
            margin-top: 30px;
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

        .discount-btn:hover {
            background: #d01133;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.9);
        }

        /* Main Content */
        .main-content {
            width: 80%;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .brand-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        /* Brand Items with Neon Outline */
        .brand-item {
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            background: transparent;
            border: 3px solid #ff1744;
            box-shadow: 0 0 10px #ff1744, 0 0 20px #ff1744, 0 0 30px #ff1744;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .brand-item:hover {
            transform: scale(1.15);
            box-shadow: 0 0 15px #ffeb3b, 0 0 25px #ffeb3b, 0 0 35px #ffeb3b;
        }

        .brand-item img {
            width: 80%;
            height: auto;
            border-radius: 50%;
            background: black;
            padding: 5px;
        }

        /* Back Arrow Button */
        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 10px;
            background: #ff1744;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
        }

        .back-btn:hover {
            background: #d01133;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.9);
        }

        /* Pop-up Effect */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 1);
            text-align: center;
            z-index: 1000;
        }

        .popup h3 {
            color: #ff1744;
            text-shadow: 0 0 10px #ff1744;
        }

        .popup button {
            padding: 8px 12px;
            background: #ff1744;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }

        .popup button:hover {
            background: #d01133;
        }
    </style>
</head>
<body>

<!-- Sidebar for Discount & Hot Offers -->
<div class="sidebar">
    <h3>Discounts</h3>
    <?php foreach ($discounts as $discountImage) : ?>
        <img src="./images/<?= htmlspecialchars($discountImage) ?>" onerror="this.onerror=null; this.src='./images/no-image.jpg';">
    <?php endforeach; ?>

    <!-- Discount Button -->
    <button class="discount-btn" onclick="window.location.href='discounts.php'">View More Discounts</button>


    <h3>Hot Offers</h3>
    <?php foreach ($hotOffers as $hotOfferImage) : ?>
        <img src="./images/<?= htmlspecialchars($hotOfferImage) ?>" onerror="this.onerror=null; this.src='./images/no-image.jpg';">
    <?php endforeach; ?>
</div>

<!-- Main Section for Brands -->
<div class="main-content">
    <button class="back-btn" onclick="goBack()">←</button>

    <h2>Select Your Brand</h2>
    <div class="brand-container">
        <?php foreach ($brands as $brand) : ?>
            <div class="brand-item" onclick="selectBrand('<?= htmlspecialchars($brand['brand_name']) ?>')">
                <img src="./images/logos/<?= htmlspecialchars($brand['brand_logo']) ?>" alt="<?= htmlspecialchars($brand['brand_name']) ?>">
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
function selectBrand(brandName) {
    alert("You selected: " + brandName);

    // Convert brand name to lowercase and replace spaces with underscores
    let formattedBrand = brandName.toLowerCase().replace(/\s+/g, "_");

    // Redirect to the corresponding brand product page
    window.location.href = formattedBrand + "_brand_products.php";
}
</script>

</body>
</html>
