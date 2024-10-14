<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';
$db = getDbConnection();

// Fetch data for analytics
$stmt = $db->query("SELECT e.id as employee_id, e.name, AVG(r.score) as average_score 
                    FROM employees e 
                    LEFT JOIN employee_reviews r ON e.id = r.employee_id 
                    GROUP BY e.id");
$analyticsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h1>Performance Analytics</h1>
        <canvas id="performanceChart"></canvas>

        <script>
            // Prepare data for the chart
            const labels = <?php echo json_encode(array_column($analyticsData, 'name')); ?>;
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Average Score',
                    data: <?php echo json_encode(array_column($analyticsData, 'average_score')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar', // You can change this to 'line', 'pie', etc.
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Average Score'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Employees'
                            }
                        }
                    }
                }
            };

            const performanceChart = new Chart(
                document.getElementById('performanceChart'),
                config
            );
        </script>
    </div>
</body>

</html>