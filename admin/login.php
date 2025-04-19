<?php
session_start();

$USER = "admin";
$PASS = "admin"; // Change this to your own password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $USER && $password === $PASS) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f1f5f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-box {
        background: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #0f172a;
    }

    label {
        font-weight: 500;
        display: block;
        margin-bottom: 6px;
        margin-top: 15px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 1rem;
    }

    button {
        margin-top: 20px;
        width: 100%;
        background-color: #3b82f6;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background-color: #2563eb;
    }

    .error {
        color: red;
        text-align: center;
        margin-top: 10px;
    }
</style>


</head>
<body>
<div class="login-box">
<a href="../index.php">🏠 Back to Site</a>
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
