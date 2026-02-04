<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

$admin_id = $_SESSION['admin'];
$success_message = "";
$error_message = "";

// Fetch Admin Data (Username + Profile Picture)
$stmt = $conn->prepare("SELECT username, profile_pic FROM admin WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_data = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Database error: " . $conn->error);
}

// Ensure admin data is not null
$username = isset($admin_data['username']) ? htmlspecialchars($admin_data['username']) : 'Admin';
$profile_pic = isset($admin_data['profile_pic']) ? $admin_data['profile_pic'] : 'default.png';

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $upload_dir = "uploads/";

    // Handle Profile Picture Upload
    if (!empty($_FILES["profile_pic"]["name"])) {
        $file_name = basename($_FILES["profile_pic"]["name"]);
        $target_file = $upload_dir . time() . "_" . $file_name; // Unique file name
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
            } else {
                $error_message = "Error uploading file.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    if (!empty($name)) {
        if ($password) {
            $query = "UPDATE admin SET username=?, password=?, profile_pic=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $name, $password, $profile_pic, $admin_id);
        } else {
            $query = "UPDATE admin SET username=?, profile_pic=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $name, $profile_pic, $admin_id);
        }

        if ($stmt->execute()) {
            $success_message = "Profile Updated Successfully!";
            $username = $name;
        } else {
            $error_message = "Error updating profile.";
        }
        $stmt->close();
    } else {
        $error_message = "Name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(255, 0, 0, 0.5);
        }
        h2 {
            color: #ff4444;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff4444;
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        input {
            background: #2e2e2e;
            color: white;
        }
        button {
            background: #ff4444;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Profile</h2>
        <?php if ($success_message) echo "<p style='color: green;'>$success_message</p>"; ?>
        <?php if ($error_message) echo "<p style='color: red;'>$error_message</p>"; ?>
        
        <img src="<?= $profile_pic ?>" class="profile-pic" alt="Profile Picture">

        <<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= $username ?>" required>
    <input type="password" name="password" placeholder="New Password (optional)">
    <input type="file" name="profile_pic" accept="image/*">
    <button type="submit">Update</button>
</form>

<!-- Back Button -->
<button onclick="window.history.back()">Back</button>

    </div>
</body>
</html>
