<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['feedback']);
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

    if (!empty($username) && !empty($email) && !empty($feedback) && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO feedback (username, email, message, rating) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssi", $username, $email, $feedback, $rating);
            if ($stmt->execute()) {
                // Redirect to avoid form resubmission on refresh
                header("Location: feedback.php?success=1");
                exit();
            } else {
                $message = "Something went wrong. Please try again.";
            }
            $stmt->close();
        } else {
            $message = "Database error. Please contact support.";
        }
    } else {
        $message = "All fields and a rating (1-5) are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #0d0d0d;
            color: white;
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
            background: rgba(20, 20, 20, 0.9);
            display: inline-block;
            width: 40%;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff1744;
            background: rgba(255, 23, 68, 0.2);
            color: white;
        }
        .stars i {
            font-size: 30px;
            cursor: pointer;
            color: gray;
        }
        .stars i.active {
            color: #ffeb3b;
        }
        .btn {
            background-color: #ff1744;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #ffeb3b;
            color: black;
        }
        .home-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px;
            background: #ff1744;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-btn:hover {
            background: #ffeb3b;
            color: black;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Give Us Your Feedback</h2>

        <?php if (isset($_GET['success'])) { ?>
            <p style="color: #ffeb3b;">Thank you for your feedback!</p>
        <?php } else { ?>

            <?php if (!empty($message)) { echo "<p style='color: red;'>$message</p>"; } ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="feedback" rows="4" placeholder="Write your feedback here..." required></textarea>
                <input type="hidden" name="rating" id="rating" value="0">
                <div class="stars">
                    <i class="fas fa-star" onclick="setRating(1)"></i>
                    <i class="fas fa-star" onclick="setRating(2)"></i>
                    <i class="fas fa-star" onclick="setRating(3)"></i>
                    <i class="fas fa-star" onclick="setRating(4)"></i>
                    <i class="fas fa-star" onclick="setRating(5)"></i>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        <?php } ?>

        <a href="index.html" class="home-btn">Home</a>
    </div>

    <script>
        function setRating(star) {
            document.getElementById("rating").value = star;
            let stars = document.querySelectorAll(".stars i");
            stars.forEach((s, index) => {
                s.classList.toggle("active", index < star);
            });
        }
    </script>
</body>
</html>
