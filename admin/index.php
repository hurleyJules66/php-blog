<?php include '../config/db.php'; ?>

<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin - Hapa Kule</title>
</head>
<body>

<div style="text-align:right; padding:10px;">
    <a href="../index.php">🏠 View Site</a> |
    <a href="logout.php">🚪 Logout</a>
</div>

    <h2>Admin Dashboard</h2>
    <p><a href="add.php">+ Add New Post</a></p>

    <h3>All Posts</h3>
    <ul>
        <?php
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()):
        ?>
            <li>
                <?= htmlspecialchars($row['title']) ?> |
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?');">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
    

</body>
</html>
