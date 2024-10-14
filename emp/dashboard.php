<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';
$db = getDbConnection();

// Fetch employees to display
$stmt = $db->query("SELECT * FROM employees");
$employees = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Navigation or Options Section -->
        <nav>
            <ul>
                <li><a href="view_reviews.php">View Reviews</a></li>
                <li><a href="add_employee.php">Add Employee</a></li>
                <li><a href="add_criterion.php">Add Performance Criterion</a></li>
                <li><a href="analytics.php">View Analytics</a></li>

                <!-- Add other options as necessary -->
            </ul>
        </nav>

        <h2>Employee List</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['id']); ?></td>
                    <td><?php echo htmlspecialchars($employee['name']); ?></td>
                    <td>
                        <form action="add_review.php" method="GET">
                            <input type="hidden" name="employee_id"
                                value="<?php echo htmlspecialchars($employee['id']); ?>">
                            <button type="submit">Add Review</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>