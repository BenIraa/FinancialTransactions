<?php
// Database connection (replace with your credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve accounts from the database
$sql = "SELECT * FROM accounts";
$result = mysqli_query($connection, $sql);

// Create separate arrays for different account types
$assets = [];
$liabilities = [];
$equity = [];
$income = [];
$expenses = [];

// Categorize accounts based on account type
while ($row = mysqli_fetch_assoc($result)) {
    switch ($row['account_type']) {
        case 'Asset':
            $assets[] = $row;
            break;
        case 'Liability':
            $liabilities[] = $row;
            break;
        case 'Equity':
            $equity[] = $row;
            break;
        case 'Income':
            $income[] = $row;
            break;
        case 'Expense':
            $expenses[] = $row;
            break;
        default:
            // Handle other account types as needed
            break;
    }
}

// Calculate total balances for each category (e.g., total assets, total liabilities, etc.)
$totalAssets = 0;
foreach ($assets as $asset) {
    $totalAssets += $asset['account_balance'];
}

// Calculate other totals as needed

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Balance Sheet</title>
    <!-- Your CSS styles for the balance sheet here -->
    <style>
        /* Add your CSS styles for the balance sheet */
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
    <h1>Balance Sheet</h1>

    <!-- Display the balance sheet table -->
    <table>
        <tr>
            <th>Asset Accounts</th>
            <th>Amount</th>
        </tr>
        <?php foreach ($assets as $asset) : ?>
            <tr>
                <td><?php echo $asset['account_name']; ?></td>
                <td><?php echo $asset['account_balance']; ?></td>
            </tr>
        <?php endforeach; ?>
        <!-- Repeat the same structure for other account types (liabilities, equity, income, expenses) -->
        <!-- Display total balances for each category -->
        <tr>
            <td>Total Assets</td>
            <td><?php echo $totalAssets; ?></td>
        </tr>
        <!-- Display other totals as needed -->
    </table>
</body>
</html>
