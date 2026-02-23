<?php
$servername = "localhost";  // XAMPP default server
$username = "root";         // Default XAMPP MySQL user
$password = "";             // No password for XAMPP by default
$database = "user_auth";    // ✅ Use the correct database that contains both tables

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
