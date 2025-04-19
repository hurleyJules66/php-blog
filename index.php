<?php
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Hapa Kule</title>
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

        body, html {
            height: 100%;
            margin: 0;
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transition: 0.3s ease;
        }

        .post-title {
            font-weight: bold;
            font-size: 1.25rem;
        }

        .post-snippet {
            font-size: 0.95rem;
            color: #555;
        }

        .sidebar-card {
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>

<div class="layout-wrapper">

    <?php include 'includes/header.php'; ?>

    <main class="py-4">
        <div class="container">
            <div class="row">
                <!-- Main Blog Content -->
                <div class="col-md-8">
                    <h2 class="mb-4 text-primary">📰 Recent Posts</h2>

                    <?php
                    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0):
                        while($row = $result->fetch_assoc()):
                    ?>
                        <div class="card mb-4 shadow-sm post-card">
                            <div class="card-body">
                                <a href="post.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                                    <div class="post-title"><?= htmlspecialchars($row['title']) ?></div>
                                </a>
                                <p class="post-snippet mt-2"><?= substr(htmlspecialchars($row['content']), 0, 160) . '...' ?></p>
                            </div>
                            <div class="card-footer text-muted small">
                                Posted on <?= $row['created_at'] ?>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else:
                        echo "<p class='text-danger'>No posts found.</p>";
                    endif;
                    ?>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="card sidebar-card mb-4 p-3 shadow-sm">
                        <h5 class="text-secondary">👨‍💻 About This Blog</h5>
                        <p>This is a simple blog project built with PHP and Bootstrap. Posts are managed via an admin dashboard.</p>
                        <hr>
                        <a href="admin/login.php" class="btn btn-outline-dark w-100">🔐 Admin Login</a>
                    </div>

                    <div class="card sidebar-card p-3 shadow-sm">
                        <h6 class="text-muted">✨ Built by Hurley Jules</h6>
                        <small>Powered by PHP, Bootstrap & MySQL</small>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
