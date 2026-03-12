<?php
$conn = new mysqli("localhost", "root", "", "user_auth");
$hashed_password = password_hash("admin123", PASSWORD_DEFAULT);
$sql = "INSERT INTO admin (username, password) VALUES ('admin', '$hashed_password')";
$conn->query($sql);
$conn->close();
?>
