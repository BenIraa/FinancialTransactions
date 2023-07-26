<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize arrays to store debited and credited account details
$debitedAccounts = [];
$creditedAccounts = [];

// Retrieve data from the transactions table along with the account names
$sql = "SELECT transactions.account_id, accounts.account_name, transactions.type, transactions.amount 
        FROM transactions
        INNER JOIN accounts ON transactions.account_id = accounts.account_id";
$result = mysqli_query($connection, $sql);

// Process the transactions and calculate debited and credited account totals
while ($row = mysqli_fetch_assoc($result)) {
    $account_id = $row['account_id'];
    $account_name = $row['account_name'];
    $amount = $row['amount'];
    $type = $row['type'];

    if ($type === 'Debit') {
        if (isset($debitedAccounts[$account_id])) {
            $debitedAccounts[$account_id]['amount'] += $amount;
        } else {
            $debitedAccounts[$account_id] = ['account_name' => $account_name, 'amount' => $amount];
        }
    } elseif ($type === 'Credit') {
        if (isset($creditedAccounts[$account_id])) {
            $creditedAccounts[$account_id]['amount'] += $amount;
        } else {
            $creditedAccounts[$account_id] = ['account_name' => $account_name, 'amount' => $amount];
        }
    }
}
// Print SQL query result


// Close the database connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Trial Balance</title>
    <style>
        body {
            font-family: 'nunito', sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <h2>Trial Balance</h2>
    <table>
        <tr>
            <th>Account</th>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
        </tr>
        <?php
        // Loop through debited accounts to display data
        foreach ($debitedAccounts as $account_id => $accountDetails) {
            $account_name = $accountDetails['account_name'];
            $debitAmount = $accountDetails['amount'];
            $creditAmount = isset($creditedAccounts[$account_id]) ? $creditedAccounts[$account_id]['amount'] : 0;
            echo "<tr>";
            echo "<td>$account_name</td>";
            echo "<td>$debitAmount</td>";
            echo "<td>$creditAmount</td>";
            echo "</tr>";
        }

        // Loop through credited accounts to display data
        foreach ($creditedAccounts as $account_id => $accountDetails) {
            if (!isset($debitedAccounts[$account_id])) {
                $account_name = $accountDetails['account_name'];
                $creditAmount = $accountDetails['amount'];
                echo "<tr>";
                echo "<td>$account_name</td>";
                echo "<td>0</td>";
                echo "<td>$creditAmount</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
