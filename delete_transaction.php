<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the transaction_id is provided in the URL
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Fetch the transaction from the database to get account information
    $sql_fetch_transaction = "SELECT * FROM transactions WHERE transaction_id = $transaction_id";
    $result_transaction = mysqli_query($connection, $sql_fetch_transaction);

    if (mysqli_num_rows($result_transaction) === 1) {
        $row_transaction = mysqli_fetch_assoc($result_transaction);
        $account_id = $row_transaction['account_id'];
        $type = $row_transaction['type'];
        $amount = $row_transaction['amount'];

        // Delete the transaction from the transactions table
        $sql_delete_transaction = "DELETE FROM transactions WHERE transaction_id = $transaction_id";
        mysqli_query($connection, $sql_delete_transaction);

        // Update the account balances based on the transaction type
        if ($type === 'Debit') {
            $sql_update_account = "UPDATE accounts SET account_balance = account_balance - $amount WHERE account_id = $account_id";
        } else {
            $sql_update_account = "UPDATE accounts SET account_balance = account_balance + $amount WHERE account_id = $account_id";
        }

        mysqli_query($connection, $sql_update_account);

        // Redirect back to the ledger page to display the updated transactions and account balances
        header('Location: account_list.php');
        exit();
    } else {
        // Transaction not found
        // Handle the error
        echo "Transaction not found.";
    }
} else {
    // Invalid request
    echo "Invalid request.";
}
?>
