<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $db = getDbConnection();
    $stmt = $db->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");

    try {
        $stmt->execute(['username' => $username, 'password' => $password]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = "Username already exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error))
            echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>