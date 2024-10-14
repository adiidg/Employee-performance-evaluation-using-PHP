<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';
$db = getDbConnection();
$stmt = $db->query("SELECT * FROM employee_reviews");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Employee Reviews</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Criterion ID</th>
                <th>Score</th>
                <th>Created At</th>
            </tr>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo $review['id']; ?></td>
                    <td><?php echo $review['employee_id']; ?></td>
                    <td><?php echo $review['criterion_id']; ?></td>
                    <td><?php echo $review['score']; ?></td>
                    <td><?php echo $review['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>