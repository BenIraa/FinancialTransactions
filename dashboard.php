<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Accounting System Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <style>
        /* Your dashboard and sidebar CSS styles */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .dashboard-container {
            /* Your dashboard container styles */
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }

        .dashboard-card {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            width: 300px;
        }

        .dashboard-card h3 {
            margin: 0;
        }

        .content {
            margin-left: 250px; /* Adjust this to give space for the sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Include the sidebar content -->

    <div class="content">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="dashboard-container">
            <!-- Your dashboard content here -->
            <div class="dashboard-card">
                <h3>Total Transactions</h3>
                <canvas id="totalTransactionsChart" width="300" height="150"></canvas>
            </div>

            <div class="dashboard-card">
                <h3>Transaction Types</h3>
                <canvas id="transactionTypesChart" width="300" height="150"></canvas>
            </div>

            <div class="dashboard-card">
                <h3>Account Balances</h3>
                <canvas id="accountBalancesChart" width="300" height="150"></canvas>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample data for the charts
        const totalTransactionsData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Total Transactions',
                data: [65, 59, 80, 81, 56, 55],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        };

        const transactionTypesData = {
            labels: ['Debit', 'Credit'],
            datasets: [{
                data: [75, 25],
                backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(75, 192, 192, 0.6)'],
            }]
        };

        const accountBalancesData = {
            labels: ['Account 1', 'Account 2', 'Account 3', 'Account 4'],
            datasets: [{
                label: 'Account Balances',
                data: [4000, 2500, 6000, 3500],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
            }]
        };

        // Chart configuration
        const chartConfig = {
            type: 'bar',
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Create charts
        const totalTransactionsChart = new Chart(document.getElementById('totalTransactionsChart'), {
            ...chartConfig,
            data: totalTransactionsData
        });

        const transactionTypesChart = new Chart(document.getElementById('transactionTypesChart'), {
            ...chartConfig,
            type: 'pie',
            data: transactionTypesData
        });

        const accountBalancesChart = new Chart(document.getElementById('accountBalancesChart'), {
            ...chartConfig,
            data: accountBalancesData
        });
    </script>
</body>
</html>