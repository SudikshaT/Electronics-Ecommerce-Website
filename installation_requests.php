<?php
session_start();
include 'db_connect.php'; // Ensure this connects to your database

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$selected_items = $_SESSION['selected_items'] ?? [];

// Convert selected items to a comma-separated string
$electronic_item = implode(", ", $selected_items);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $problem_description = $_POST['problem_description'];
    $contact_number = $_POST['contact_number'];
    $image_path = '';

    // Handle image upload or capture
    if (!empty($_FILES['uploaded_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["uploaded_image"]["name"]);
        move_uploaded_file($_FILES["uploaded_image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    } elseif (!empty($_POST['captured_image'])) {
        $image_data = $_POST['captured_image'];
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = base64_decode($image_data);
        $image_name = "uploads/" . uniqid() . ".png";
        file_put_contents($image_name, $image_data);
        $image_path = $image_name;
    }

    if ($image_path) {
        $stmt = $conn->prepare("INSERT INTO installation_requests (username, electronic_item, image_path, problem_description, contact_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $electronic_item, $image_path, $problem_description, $contact_number);

        if ($stmt->execute()) {
            echo "<script>alert('Product Installation request submitted successfully!'); window.location.href='thank_you.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please capture or upload an image before submitting.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture/Upload Image & Submit Request</title>
    <style>
        @keyframes glow {
            0% { box-shadow: 0 0 10px #ff0000; }
            50% { box-shadow: 0 0 20px #ff3333; }
            100% { box-shadow: 0 0 10px #ff0000; }
        }

        @keyframes floating {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        body {
            background: #000;
            color: #fff;
            text-align: center;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }

        h2 {
            margin-top: 20px;
            text-shadow: 0 0 10px #ff0000, 0 0 20px #ff4d4d;
            animation: glow 2s infinite;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.6);
            animation: floating 3s infinite ease-in-out;
        }

        video, canvas, img {
            width: 100%;
            max-width: 320px;
            display: block;
            margin: 15px auto;
            border-radius: 10px;
            border: 3px solid #ff0000;
            animation: glow 2s infinite alternate;
        }

        .input-field {
            width: 90%;
            padding: 12px;
            margin: 10px auto;
            border-radius: 5px;
            border: none;
            text-align: center;
            background: #222;
            color: white;
            font-size: 16px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
            transition: 0.3s;
        }

        .input-field:focus {
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.8);
            transform: scale(1.05);
        }

        .capture-btn, .submit-btn {
            width: 90%;
            padding: 15px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 10px;
            text-transform: uppercase;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
        }

        .capture-btn {
            background: linear-gradient(45deg, #ff0000, #ff4d4d);
            color: white;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.6);
        }

        .capture-btn::before, .submit-btn::before {
            content: "";
            position: absolute;
            top: -5px;
            left: -5px;
            width: calc(100% + 10px);
            height: calc(100% + 10px);
            border: 2px solid #ff0000;
            animation: glitch 0.5s infinite linear alternate;
            opacity: 0.7;
        }

        @keyframes glitch {
            0% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            50% { transform: translateX(3px); }
            75% { transform: translateX(-3px); }
            100% { transform: translateX(0); }
        }

        .capture-btn:hover, .submit-btn:hover {
            transform: scale(1.08);
        }

        .submit-btn {
            background: linear-gradient(45deg, #00ff00, #00cc00);
            color: black;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.6);
        }

        .submit-btn::before {
            border-color: #00ff00;
        }
    </style>
</head>
<body>

    <h2>Selected Electronics: <?php echo htmlspecialchars($electronic_item); ?></h2>

    <div class="container">
        <video id="video" autoplay></video>
        <button class="capture-btn" onclick="captureImage()">Capture Image</button>
        <canvas id="canvas" style="display:none;"></canvas>
        <img id="capturedImg" src="#" style="display:none;">

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="captured_image" id="imageData">
            <p>OR</p>
            <input type="file" name="uploaded_image" accept="image/*" class="input-field">
            
            <textarea name="problem_description" class="input-field" placeholder="Describe the problem..." required></textarea>
            <input type="text" name="contact_number" class="input-field" placeholder="Enter your contact number" required>
            <button class="submit-btn" type="submit" name="submit">Submit</button>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const capturedImg = document.getElementById('capturedImg');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                alert("Camera access denied! Please allow camera permissions.");
            });

        function captureImage() {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL("image/png");
            capturedImg.src = imageData;
            capturedImg.style.display = 'block';
            document.getElementById('imageData').value = imageData;
        }
    </script>

</body>
</html>
