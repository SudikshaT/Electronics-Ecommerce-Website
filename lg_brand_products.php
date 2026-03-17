<?php
// Define categories manually
$categories = [
    ["name" => "TV", "image" => "tv1.png", "rating" => "⭐⭐⭐⭐☆", "description" => "Experience stunning visuals with 4K and OLED displays."],
    ["name" => "Fridge", "image" => "fr1.png", "rating" => "⭐⭐⭐⭐⭐", "description" => "Keep your food fresh with the latest cooling technology."],
    ["name" => "AC", "image" => "tv2.png", "rating" => "⭐⭐⭐⭐☆", "description" => "Beat the heat with energy-efficient air conditioning."],
    ["name" => "Washing Machine", "image" => "fr2.png", "rating" => "⭐⭐⭐⭐⭐", "description" => "Powerful washing machines with smart technology."]
];

// Define sliding images
$slidingImages = ["slide1.jpg", "slide2.jpg", "slide3.jpg"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LG Products</title>
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
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #111;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .navbar h2 {
            color: #ff1744;
            text-shadow: 0 0 10px #ff1744;
            margin: 0 auto;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .search-bar input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 2px solid #ff1744;
            background: black;
            color: white;
        }

        /* Slider */
        .slider-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            height: 300px;
            margin: 20px 0;
        }

        .slides {
            display: flex;
            width: 300%;
            animation: slideAnimation 9s infinite;
        }

        .slide {
            width: 100%;
            transition: transform 1s ease-in-out;
        }

        .slide img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        @keyframes slideAnimation {
            0% { transform: translateX(0%); }
            33% { transform: translateX(-100%); }
            66% { transform: translateX(-200%); }
            100% { transform: translateX(0%); }
        }

        /* Categories Section */
        .categories {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .category-item {
            display: flex;
            align-items: center;
            width: 100%;
            background: #111;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #ff1744;
            box-shadow: 0 0 15px #ff1744;
            transition: 0.3s;
        }

        .category-item:hover {
            box-shadow: 0 0 20px #ffeb3b;
        }

        .category-item img {
            width: 40%;
            height: 200px;
            object-fit: cover;
        }

        .category-info {
            padding: 20px;
            text-align: left;
            width: 60%;
        }

        .category-info h3 {
            margin: 0;
            color: #ff1744;
            text-shadow: 0 0 5px #ff1744;
        }

        .category-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <span class="back-arrow" onclick="goBack()">←</span>
    <h2>LG</h2>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<style>
    .back-arrow {
        font-size: 24px;
        cursor: pointer;
        color: white;
    }
</style>

<!-- Search Bar -->
<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search for electronics..." onkeyup="filterCategories()">
</div>

<!-- Slider -->
<div class="slider-container">
    <div class="slides">
        <?php foreach ($slidingImages as $image) : ?>
            <div class="slide">
                <img src="./images/<?= htmlspecialchars($image) ?>" alt="Slide Image">
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Categories Section -->
<div class="categories" id="categoriesContainer">
    <?php foreach ($categories as $category) : ?>
        <a href="lg_fetch.php?category=<?= urlencode($category['name']) ?>" class="category-item" data-category="<?= strtolower($category['name']) ?>">
            <img src="./images/<?= htmlspecialchars($category['image']) ?>" alt="<?= htmlspecialchars($category['name']) ?>">
            <div class="category-info">
                <h3><?= htmlspecialchars($category['name']) ?></h3>
                <p><?= htmlspecialchars($category['rating']) ?></p>
                <p><?= htmlspecialchars($category['description']) ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<script>
    function filterCategories() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let categories = document.querySelectorAll(".category-item");

        categories.forEach(category => {
            let categoryName = category.getAttribute("data-category");
            if (categoryName.includes(input)) {
                category.style.display = "flex"; // Show matching category
            } else {
                category.style.display = "none"; // Hide non-matching category
            }
        });
    }
</script>

</body>
</html>
