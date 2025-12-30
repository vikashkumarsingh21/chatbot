<?php
$conn = new mysqli("localhost", "root", "", "ngo_chatbot");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
