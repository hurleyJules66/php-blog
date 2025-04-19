<?php include '../config/db.php'; ?>

<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>


<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>
    <h2>Add New Blog Post</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <p>
            <label>Title:</label><br>
            <input type="text" name="title" required style="width: 100%;">
        </p>
        <p>
            <label>Content:</label><br>
            <textarea name="content" rows="10" required style="width: 100%;"></textarea>
        </p>
        <p>
            <button type="submit">Publish</button>
        </p>
    </form>
</body>
</html>
