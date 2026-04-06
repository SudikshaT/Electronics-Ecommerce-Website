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
        $stmt = $conn->prepare("INSERT INTO maintenance_requests (username, electronic_item, image_path, problem_description, contact_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $electronic_item, $image_path, $problem_description, $contact_number);

        if ($stmt->execute()) {
            echo "<script>alert('Maintenance request submitted successfully!'); window.location.href='thank_you.php';</script>";
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
        body {
            background: #000;
            color: #fff;
            text-align: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            font-size: 26px;
            text-shadow: 0 0 15px #ff00ff;
        }
        .container {
            margin-top: 30px;
            padding: 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
            width: 80%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        video, canvas, img {
            display: block;
            margin: 10px auto;
            border: 3px solid #00ffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.7);
        }
        button {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 10px #ff00ff;
        }
        button:hover {
            background: linear-gradient(45deg, #00ffff, #ff00ff);
            box-shadow: 0 0 20px #00ffff;
            transform: scale(1.1);
        }
        .input-field {
            width: 90%;
            padding: 12px;
            margin: 10px auto;
            border-radius: 8px;
            border: 2px solid #ff00ff;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
            outline: none;
            transition: all 0.3s ease-in-out;
            font-size: 16px;
        }
        .input-field:focus {
            border-color: #00ffff;
            box-shadow: 0 0 10px #00ffff;
        }
        .submit-btn {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            color: white;
            border: none;
            padding: 15px 35px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 50px;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 20px #ff00ff;
            position: relative;
            overflow: hidden;
        }
        .submit-btn:hover {
            background: linear-gradient(45deg, #00ffff, #ff00ff);
            box-shadow: 0 0 30px #00ffff;
            transform: scale(1.1);
        }
        .submit-btn::after {
            content: "";
            position: absolute;
            width: 300%;
            height: 300%;
            top: 50%;
            left: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: transform 0.5s ease-out;
        }
        .submit-btn:active::after {
            transform: translate(-50%, -50%) scale(1);
        }
    </style>
</head>
<body>

    <h2>Selected Electronics: <?php echo htmlspecialchars($electronic_item); ?></h2>

    <div class="container">
        <video id="video" width="320" height="240" autoplay></video>
        <button onclick="captureImage()">Capture Image</button>
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
        <img id="capturedImg" src="#" style="display:none;" width="320" height="240">

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="captured_image" id="imageData">
            <p style="font-size: 18px; margin-top: 10px; color: #ff00ff;">OR</p>
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
            const imageData = canvas.toDataURL("uploads/png");
            capturedImg.src = imageData;
            capturedImg.style.display = 'block';
            document.getElementById('imageData').value = imageData;
        }
    </script>

</body>
</html>
