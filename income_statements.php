<?php
// Database connection (replace with your credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from the "sold_products" table
$sql = "SELECT * FROM sold_products";
$result = mysqli_query($connection, $sql);

// Create an array to store sold products data
$soldProducts = [];

// Fetch sold products data and calculate total revenue
$totalRevenue = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $soldProducts[] = $row;
    $totalRevenue += ($row['price'] * $row['quantity_sold']);
}

// Retrieve COGS details from the "accounts" table
$sql = "SELECT * FROM accounts WHERE account_type = 'COGS'";
$result = mysqli_query($connection, $sql);
$cogsDetails = [];
$totalCOGS = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $cogsDetails[] = $row;
    $totalCOGS += $row['account_balance'];
}

// Retrieve expense details from the "accounts" table
$sql = "SELECT * FROM accounts WHERE account_type = 'Expense'";
$result = mysqli_query($connection, $sql);
$expenseDetails = [];
$totalExpenses = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $expenseDetails[] = $row;
    $totalExpenses += $row['account_balance'];
}

// Calculate Gross Profit
$grossProfit = $totalRevenue - $totalCOGS;

// Calculate Operating Income
$operatingIncome = $grossProfit - $totalExpenses;

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Income Statement</title>
    <!-- Your CSS styles for the income statement here -->
    <style>
        /* Add your CSS styles for the income statement */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            margin-right: 10px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h1>Income Statement</h1>

    <!-- Display the income statement table -->
    <table>
        <tr>
            <th>Sales (Revenue)</th>
            <td><?php echo $totalRevenue; ?></td>
        </tr>
        <tr>
            <th colspan="2">Cost of Goods Sold (COGS) Details</th>
        </tr>
        <?php foreach ($cogsDetails as $cogs) : ?>
            <tr>
                <td><?php echo $cogs['account_name']; ?></td>
                <td><?php echo $cogs['account_balance']; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th>Total COGS</th>
            <td>(<?php echo $totalCOGS; ?>)</td>
        </tr>
        <tr>
            <th colspan="2">Expense Details</th>
        </tr>
        <?php foreach ($expenseDetails as $expense) : ?>
            <tr>
                <td><?php echo $expense['account_name']; ?></td>
                <td><?php echo $expense['account_balance']; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th>Total Expenses</th>
            <td>(<?php echo $totalExpenses; ?>)</td>
        </tr>
        <tr>
            <th>Gross Profit</th>
            <td><?php echo $grossProfit; ?></td>
        </tr>
        <tr>
            <th>Operating Income (Profit/Loss)</th>
            <td><?php echo $operatingIncome; ?></td>
        </tr>
    </table>
</body>
</html>
