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
        $stmt = $conn->prepare("INSERT INTO product_replacement_requests (username, electronic_item, image_path, problem_description, contact_number) VALUES (?, ?, ?, ?, ?)");
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
        /* General Styles */
        body {
            background: #121212;
            color: #fff;
            font-family: 'Arial', sans-serif;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            scroll-behavior: smooth;
        }

        h2 {
            font-size: 32px;
            color: #39ff14;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(57, 255, 20, 0.8);
        }

        /* Container Styles */
        .container {
            background: #1e1e1e;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 0 30px rgba(57, 255, 20, 0.7);
            width: 90%;
            max-width: 800px;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            overflow-y: auto;
        }

        /* Video and Image Styling */
        video, canvas, img {
            display: block;
            margin: 20px auto;
            border: 2px solid #39ff14;
            border-radius: 10px;
        }

        /* Form Elements in Single Line */
        .form-element {
            margin: 10px;
            display: inline-block;
            width: auto;
        }

        /* Input Fields Styling with Different Neon Effects */
        .input-field, .submit-btn, input[type="file"], textarea {
            padding: 15px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            color: #fff;
            background-color: #333;
            margin: 10px;
            width: 200px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .input-field {
            background-color: #2e2e2e;
            box-shadow: 0 0 10px rgba(57, 255, 20, 0.9);
        }

        .input-field:focus {
            border: 2px solid #39ff14;
            box-shadow: 0 0 20px rgba(57, 255, 20, 0.9);
        }

        .submit-btn {
            background: #39ff14;
            box-shadow: 0 0 20px rgba(57, 255, 20, 0.9);
        }

        .submit-btn:hover {
            background: #ff007f;
            box-shadow: 0 0 20px rgba(255, 0, 127, 0.7);
        }

        input[type="file"] {
            background: #ff007f;
            box-shadow: 0 0 20px rgba(255, 0, 127, 0.7);
        }

        input[type="file"]:hover {
            background: #ff5ac6;
            box-shadow: 0 0 25px rgba(255, 90, 198, 0.8);
        }

        textarea {
            background: #333;
            box-shadow: 0 0 20px rgba(57, 255, 20, 0.8);
        }

        textarea:focus {
            border: 2px solid #ff007f;
            box-shadow: 0 0 30px rgba(255, 0, 127, 0.7);
        }

        /* Button Styling */
        .submit-btn {
            background: #39ff14;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 20px;
            transition: 0.3s;
            box-shadow: 0 0 15px #39ff14;
        }

        .submit-btn:hover {
            background: #ff007f;
            box-shadow: 0 0 20px rgba(255, 0, 127, 0.7);
        }

    </style>
</head>
<body>

    <div class="container">
        <!-- Selected Electronics at the top -->
        <h2>Selected Electronics: <?php echo htmlspecialchars($electronic_item); ?></h2>

        <!-- Video Stream for Capturing Image -->
        <video id="video" width="320" height="240" autoplay></video>
        <button onclick="captureImage()">Capture Image</button>
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
        <img id="capturedImg" src="#" style="display:none;" width="320" height="240">

        <!-- Form for Image Upload and Other Details -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-element">
                <input type="hidden" name="captured_image" id="imageData">
            </div>
            <div class="form-element">
                <p>OR</p>
            </div>
            <div class="form-element">
                <input type="file" name="uploaded_image" accept="image/*">
            </div>
            <div class="form-element">
                <textarea name="problem_description" class="input-field" placeholder="Describe the problem..." required></textarea>
            </div>
            <div class="form-element">
                <input type="text" name="contact_number" class="input-field" placeholder="Enter your contact number" required>
            </div>
            <div class="form-element">
                <button class="submit-btn" type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const capturedImg = document.getElementById('capturedImg');

        // Request access to the user's webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                alert("Camera access denied! Please allow camera permissions.");
            });

        // Function to capture image from video stream
        function captureImage() {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL("image/png"); // Fixed the image format
            capturedImg.src = imageData;
            capturedImg.style.display = 'block';
            document.getElementById('imageData').value = imageData;
        }
    </script>

</body>
</html>
