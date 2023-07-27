<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ledger - <?php echo $account_name; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 30%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <?php
    // Establish a database connection (replace with your database credentials)
    include 'db_connection.php';
    // Retrieve all transactions for the selected account from the transactions table
    if (isset($_GET['account_id'])) {
        $account_id = $_GET['account_id'];
        $account_query = "SELECT * FROM accounts WHERE account_id = $account_id";
        $result_account = mysqli_query($connection, $account_query);

        if (mysqli_num_rows($result_account) > 0) {
            $account_row = mysqli_fetch_assoc($result_account);
            $account_name = $account_row['account_name'];
        } else {
            echo '<p>Account not found.</p>';
            exit;
        }

        // Retrieve transactions for the selected account
        $transactions_query = "SELECT * FROM transactions WHERE account_id = $account_id ORDER BY date ASC";
        $result_transactions = mysqli_query($connection, $transactions_query);
    } else {
        echo '<p>No account selected.</p>';
        exit;
    }

    // Close the database connection
    mysqli_close($connection);
    ?>

    <h1>Ledger - <?php echo $account_name; ?></h1>
    <center>
    <table>
        <tr>
            <th>Date</th>
            <th>Dr Amount</th>
            <th>Cr Amount</th>
        </tr>
        <?php
        $debit_total = 0;
        $credit_total = 0;
        while ($transaction_row = mysqli_fetch_assoc($result_transactions)) {
            $debit = $transaction_row['type'] === 'Debit' ? $transaction_row['amount'] : '';
            $credit = $transaction_row['type'] === 'Credit' ? $transaction_row['amount'] : '';

            $debit_total += $transaction_row['type'] === 'Debit' ? $transaction_row['amount'] : 0;
            $credit_total += $transaction_row['type'] === 'Credit' ? $transaction_row['amount'] : 0;

            echo "<tr>";
            echo "<td>{$transaction_row['date']}</td>";
            echo "<td>{$debit}</td>";
            echo "<td>{$credit}</td>";
            echo "</tr>";
        }

        // Calculate the balance
        $balance = $debit_total - $credit_total;

        // Calculate the adjusted total amounts
        if ($debit_total > $credit_total) {
            $adjusted_debit_total = $debit_total + min(0, abs($balance));
            $adjusted_credit_total = $debit_total > 0 ? $debit_total : 0;
        } else {
            $adjusted_debit_total = $credit_total > 0 ? $credit_total : 0;
            $adjusted_credit_total = $credit_total + max(0, $balance);
        }

        // Display the balance row
        echo "<tr>";
        echo "<td><strong>c/b</strong></td>";
        echo "<td><strong>";
        if ($balance >= 0) {
            echo $balance;
        } else {
            echo '';
        }
        echo "</strong></td>";
        echo "<td><strong>";
        if ($balance < 0) {
            echo abs($balance);
        } else {
            echo '';
        }
        echo "</strong></td>";
        echo "</tr>";

        // Display the totals row
        echo "<tr>";
        echo "<td><strong>Totals</strong></td>";
        echo "<td><strong>$adjusted_debit_total</strong></td>";
        echo "<td><strong>$adjusted_credit_total</strong></td>";
        echo "</tr>";
        ?>
    </table>
    </center>
</body>
</html>
