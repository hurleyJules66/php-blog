<?php
include 'config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Post ID is missing.");
}

// Fetch post from database
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

// Handle comment submission
if (isset($_POST['submit_comment'])) {
    $name = trim($_POST['name']);
    $comment = trim($_POST['comment']);

    if ($name && $comment) {
        $stmt = $conn->prepare("INSERT INTO comments (post_id, name, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $name, $comment);
        $stmt->execute();
        $stmt->close();
        header("Location: post.php?id=$id&page=1"); // Refresh to prevent form resubmission
        exit();
    }
}
//Handle comment submission

if (!$post) {
    die("Post not found.");
}
?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - Hapa Kule</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
header {
    background-color: #343a40;
    color: white;
    padding: 20px 0;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

header h1 {
    margin: 0;
    font-size: 2rem;
}
</style>

</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><small>Posted on <?= $post['created_at'] ?></small></p>
    <div>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    </div>
    <p><a href="index.php">← Back to Home</a></p>

<!--comments part-->
    <hr>
    <h3 class="mt-5 mb-4 text-primary">Comments</h3>

<?php
// Pagination Setup
$comments_per_page = 3;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $comments_per_page;

// Count total comments
$count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM comments WHERE post_id = ?");
$count_stmt->bind_param("i", $id);
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_assoc();
$total_comments = $count_result['total'];
$total_pages = ceil($total_comments / $comments_per_page);

// Fetch limited comments
$stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC LIMIT ?, ?");
$stmt->bind_param("iii", $id, $offset, $comments_per_page);
$stmt->execute();
$comments = $stmt->get_result();
?>

<?php while($c = $comments->fetch_assoc()): ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($c['name']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
            <p class="card-subtitle text-muted small"><?= $c['created_at'] ?></p>
        </div>
    </div>
<?php endwhile; ?>


<?php if ($total_pages > 1): ?>
    <nav aria-label="Comment pages" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="post.php?id=<?= $id ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>


<h4 class="mt-5 text-success">Leave a Comment</h4>
<form method="POST" class="mt-3">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Comment</label>
        <textarea name="comment" rows="4" class="form-control" required></textarea>
    </div>
    <button type="submit" name="submit_comment" class="btn btn-primary">Post Comment</button>
</form>


<?php
 while($c = $comments->fetch_assoc()): ?>
    <div style="margin-bottom:15px; padding:10px; background:#f9fafb; border-left: 4px solid #3b82f6;">
        <strong><?= htmlspecialchars($c['name']) ?></strong>
        <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
        <small style="color:#6b7280;"><?= $c['created_at'] ?></small>
    </div>
<?php endwhile; ?>

<!-- comments part -->

</div>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
