<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];

    $db = getDbConnection();
    $stmt = $db->prepare("INSERT INTO employees (name, department, position) VALUES (:name, :department, :position)");

    $stmt->execute(['name' => $name, 'department' => $department, 'position' => $position]);
    header('Location: view_employees.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Add Employee</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Employee Name" required>
            <input type="text" name="department" placeholder="Department" required>
            <input type="text" name="position" placeholder="Position" required>
            <button type="submit">Add Employee</button>
        </form>
    </div>
</body>

</html>