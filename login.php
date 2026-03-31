<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password with `password_verify()`
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username; // Set session
            header("Location: login_success.php"); // Redirect to login success page
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password'); window.location.href='login.html';</script>";
    }
}
?>
