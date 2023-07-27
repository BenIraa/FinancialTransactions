<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<?php
include 'db_connection.php';

// Retrieve accounts from the database
$sql = "SELECT * FROM accounts";
$inventory = "SELECT * FROM sold_products";
$result = mysqli_query($connection, $sql);
$result_inventory = mysqli_query($connection, $inventory);

$inventory = " SELECT * FROM completed_purchase_orders";
$result_inventory = mysqli_query($connection, $inventory);
$purchaseDetails = [];
$totalPurchases = 0;
while ($row = mysqli_fetch_assoc($result_inventory)) {
    $purchaseDetails[] = $row;
    $totalPurchases += ($row['amount'] * $row['quantity']);
}
// retrive total remaining quantity
$remaining = "SELECT sp.*, cpo.amount
              FROM sold_products sp
              JOIN completed_purchase_orders cpo ON sp.product_id = cpo.product_id";
$result_remaining = mysqli_query($connection, $remaining);
$remainingQuantityDetails = [];
$soldQuantityAmount = 0;
while ($row = mysqli_fetch_assoc($result_remaining)) {
    $remainingQuantityDetails[] = $row;
    $soldQuantityAmount += ($row['amount'] * $row['quantity_sold']);
}
$TotalRemainingQuantityAmount = $totalPurchases - $soldQuantityAmount;

// Create separate arrays for different account types
$assets = [];
$liabilities = [];
$equity = [];
$income = [];
$expenses = [];
$inventoryAmount = 0;
$soldProducts = []; // Variable to store the total amount of completed_purchase_orders
$purchaseDetails = [];
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

// Calculate total balances for each category
$totalAssets = 0;
foreach ($assets as $asset) {
    $totalAssets += $asset['account_balance'];
}

$totalLiabilities = 0;
foreach ($liabilities as $liability) {
    $totalLiabilities += $liability['account_balance'];
}

$totalEquity = 0;
foreach ($equity as $equityAccount) {
    $totalEquity += $equityAccount['account_balance'];
}

$totalIncome = 0;
foreach ($income as $incomeAccount) {
    $totalIncome += $incomeAccount['account_balance'];
}

$totalExpenses = 0;
foreach ($expenses as $expense) {
    $totalExpenses += $expense['account_balance'];
}

// Calculate the total amount of completed_purchase_orders as assets
$sql = "SELECT SUM(quantity * amount) AS total_amount FROM completed_purchase_orders";
$result = mysqli_query($connection, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $inventoryAmount = (float)$row['total_amount'];
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Balance Sheet</title>
    <!-- Your CSS styles for the balance sheet here -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
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

        <!-- Display the completed_purchase_orders as assets -->
        <tr>
            <td>closing Inventory</td>
            <td><?php echo $TotalRemainingQuantityAmount; ?></td>
        </tr>
        <tr>
            <td>Total Assets</td>
            <td><b><?php echo $totalAssets; ?></b></td>
        </tr>

        <!-- Display the liabilities -->
        <tr>
            <td><b>Liabilities</b></td>
            <!-- <th>Amount</th> -->
        </tr>
        <?php foreach ($liabilities as $liability) : ?>
            <tr>
                <td><?php echo $liability['account_name']; ?></td>
                <td><?php echo $liability['account_balance']; ?></td>
            </tr>
            
        <?php endforeach; ?>
        <tr>
            <td>Total Liabilities</td>
            <td><b><?php echo $totalLiabilities; ?></b></td>
        </tr>

        <!-- Display the equity -->
        <tr>
            <td><b>Equity</b></td>
            <!-- <th>Amount</th> -->
        </tr>
        <?php foreach ($equity as $equityAccount) : ?>
            <tr>
                <td><?php echo $equityAccount['account_name']; ?></td>
                <td><b><?php echo $equityAccount['account_balance']; ?></b></td>
            </tr>
        <?php endforeach; ?>   
        <tr>
            <td>Total Equity</td>
            <td><b><?php echo $totalEquity; ?></b></td>
        </tr>
       
    </table>
</body>
</html>