<?php
include '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("No post ID provided.");
}

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
