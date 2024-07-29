
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else{
// Fetch leave trends
function fetchLeaveTrends($conn) {
    $sql = "
        SELECT 
            leave_type, 
            COUNT(*) as count, 
            DATE_FORMAT(start_date, '%Y-%m') as month 
        FROM tblleaves
        WHERE status = 'approved'
        GROUP BY leave_type, month 
        ORDER BY month DESC" ;
    
    $result = $conn->query($sql);
    $leave_trends = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $leave_trends[] = $row;
        }
    }
    return $leave_trends;
}
}
$leave_trends = fetchLeaveTrends($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Analytics & Trends</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include('includes/header.php');?>      
<?php include('includes/sidebar.php');?>
    <div class="dashboard">
        <h1>Leave Analytics & Trends</h1>
        <div class="chart-container">
            <canvas id="leaveTrendsChart"></canvas>
        </div>
        <a href="index.php">Back to Dashboard</a>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('leaveTrendsChart').getContext('2d');
            var leaveTrendsData = <?php echo json_encode($leave_trends); ?>;
            
            var labels = [...new Set(leaveTrendsData.map(item => item.month))];
            var datasets = {};
            
            leaveTrendsData.forEach(item => {
                if (!datasets[item.leave_type]) {
                    datasets[item.leave_type] = {
                        label: item.leave_type,
                        data: new Array(labels.length).fill(0),
                        borderColor: getRandomColor(),
                        fill: false
                    };
                }
                var index = labels.indexOf(item.month);
                datasets[item.leave_type].data[index] = item.count;
            });
            
            var data = {
                labels: labels,
                datasets: Object.values(datasets)
            };
            
            new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Leave Trends Over Time'
                    },
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'month'
                            }
                        }
                    }
                }
            });
            
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        });
    </script>
</body>
</html>