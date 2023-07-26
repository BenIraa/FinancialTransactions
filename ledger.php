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
    <?php
    // Establish a database connection (replace with your database credentials)
    $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

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
        $balance = 0;
        while ($transaction_row = mysqli_fetch_assoc($result_transactions)) {
            $debit = $transaction_row['type'] === 'Debit' ? $transaction_row['amount'] : '';
            $credit = $transaction_row['type'] === 'Credit' ? $transaction_row['amount'] : '';

            $balance += $transaction_row['amount'];

            echo "<tr>";
            echo "<td>{$transaction_row['date']}</td>";
            echo "<td>{$debit}</td>";
            echo "<td>{$credit}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </center>
</body>
</html>
