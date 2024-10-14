<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';
$db = getDbConnection();
$stmt = $db->query("SELECT * FROM employees");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Employees List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo $employee['id']; ?></td>
                    <td><?php echo $employee['name']; ?></td>
                    <td><?php echo $employee['department']; ?></td>
                    <td><?php echo $employee['position']; ?></td>
                    <td>
                        <a href="add_review.php?employee_id=<?php echo $employee['id']; ?>">Add Review</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>