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
        $stmt = $conn->prepare("INSERT INTO cleaning_requests (username, electronic_item, image_path, problem_description, contact_number) VALUES (?, ?, ?, ?, ?)");
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
        /* Global Styles */
        body {
            background: #111;
            color: #fff;
            text-align: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto; /* Allow scrolling */
        }

        h2 {
            color: #ff4b4b;
            font-size: 30px;
            margin-top: 50px;
            text-shadow: 0 0 10px rgba(255, 75, 75, 0.7);
        }

        .container {
            margin-top: 50px;
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #1a1a1a;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 75, 75, 0.5);
            flex-grow: 1; /* Allow container to expand and allow scrolling */
        }

        video, canvas, img {
            display: block;
            margin: 10px auto;
            border-radius: 10px;
            border: 3px solid #ff4b4b;
            box-shadow: 0 0 20px rgba(255, 75, 75, 0.6);
        }

        button {
            background: #ff4b4b;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 20px;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            text-transform: uppercase;
            box-shadow: 0 0 15px rgba(255, 75, 75, 0.7);
        }

        button:hover {
            background: #ff7373;
            box-shadow: 0 0 25px rgba(255, 75, 75, 1);
        }

        .input-field {
            width: 80%;
            padding: 12px;
            margin: 15px auto;
            border-radius: 10px;
            border: 2px solid #ff4b4b;
            background: #333;
            color: #fff;
            font-size: 16px;
            text-align: center;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #ff7373;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 75, 75, 0.6);
        }

        textarea {
            width: 80%;
            padding: 15px;
            margin: 15px auto;
            border-radius: 10px;
            border: 2px solid #ff4b4b;
            background: #333;
            color: #fff;
            font-size: 16px;
            height: 120px;
            transition: border-color 0.3s ease;
            resize: none;
        }

        textarea:focus {
            border-color: #ff7373;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 75, 75, 0.6);
        }

        .form-actions {
            margin-top: 30px;
        }

        p {
            font-size: 18px;
            color: #bbb;
            margin: 20px 0;
        }

        /* Add media queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 90%;
            }

            .input-field, textarea, button {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <h2>Selected Electronics: <?php echo htmlspecialchars($electronic_item); ?></h2>

    <div class="container">
        <!-- Video capture -->
        <video id="video" width="320" height="240" autoplay></video>
        <button onclick="captureImage()">Capture Image</button>
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
        <img id="capturedImg" src="#" style="display:none;" width="320" height="240">

        <!-- Form to submit request -->
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

        // Access the user's camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                alert("Camera access denied! Please allow camera permissions.");
            });

        // Capture the image from the video stream
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
