<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>


<?php
include '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("No post ID provided.");
}

// Fetch the post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    die("Post not found.");
}

// Handle form update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Blog Post</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <p>
            <label>Title:</label><br>
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" style="width:100%;" required>
        </p>
        <p>
            <label>Content:</label><br>
            <textarea name="content" rows="10" style="width:100%;" required><?= htmlspecialchars($post['content']) ?></textarea>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
</body>
</html>
