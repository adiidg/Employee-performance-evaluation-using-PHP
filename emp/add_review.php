<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Check if employee_id is set in the URL
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
} else {
    echo "Error: Employee ID is required.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criterion_id = $_POST['criterion_id'];
    $score = $_POST['score'];

    // Validate criterion ID
    $db = getDbConnection();
    $stmt = $db->prepare("SELECT * FROM performance_criteria WHERE id = :criterion_id");
    $stmt->execute(['criterion_id' => $criterion_id]);
    $criterion = $stmt->fetch();

    if (!$criterion) {
        echo "Error: The specified criterion does not exist.";
        exit;
    }

    // Validate score
    if (!is_numeric($score) || $score < 0 || $score > 10) { // Adjust range as needed
        echo "Error: Score must be a number between 0 and 10.";
        exit;
    }

    $stmt = $db->prepare("INSERT INTO employee_reviews (employee_id, criterion_id, score) VALUES (:employee_id, :criterion_id, :score)");
    $stmt->execute(['employee_id' => $employee_id, 'criterion_id' => $criterion_id, 'score' => $score]);

    header('Location: view_reviews.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Add Review for Employee ID: <?php echo $employee_id; ?></h2>
        <form method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
            <input type="number" name="criterion_id" placeholder="Criterion ID" required>
            <input type="number" name="score" placeholder="Score" required>
            <button type="submit">Add Review</button>
        </form>
    </div>
</body>

</html>