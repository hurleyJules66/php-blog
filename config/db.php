<?php
$host = "localhost";
$user = "root"; // Or your cPanel username
$pass = "";     // Or your MySQL password
$dbname = "blog_db";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
