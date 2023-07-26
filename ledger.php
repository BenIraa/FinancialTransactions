<?php
// ledger.php

// Check if the account_id is present in the URL query parameters
if (isset($_GET['account_id'])) {
    $account_id = $_GET['account_id'];

    // Replace the following lines with your database connection and query code
    // Fetch the account_name from the accounts table using the $account_id
    // Example query: SELECT account_name FROM accounts WHERE account_id = $account_id
    // $account_name = ...; // Fetch account name from the database

    // Dummy data for demonstration purposes (replace with your actual data retrieval)
    $account_name = "Sample Account"; // Replace this with fetched account_name from the database

    // Fetch transactions data for the selected account from the database
    // Example query: SELECT * FROM transactions WHERE account_id = $account_id
    // $transactions = ...; // Fetch transactions data from the database

    // Dummy transactions data for demonstration purposes (replace with your actual data retrieval)
    $transactions = array(
        array('transaction_id' => 1, 'date' => '2023-07-01', 'description' => 'Transaction 1', 'debit' => 100, 'credit' => 0),
        array('transaction_id' => 2, 'date' => '2023-07-02', 'description' => 'Transaction 2', 'debit' => 0, 'credit' => 50),
        array('transaction_id' => 3, 'date' => '2023-07-03', 'description' => 'Transaction 3', 'debit' => 75, 'credit' => 0),
        // Add more transactions data as needed
    );

    // Calculate the account balance
    $account_balance = 0;
    foreach ($transactions as $transaction) {
        $account_balance += ($transaction['debit'] - $transaction['credit']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ledger - <?php echo $account_name; ?></title>
    <!-- Your CSS styles here -->
    <style>
        /* Your custom styles for the ledger page */
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h1>Ledger - <?php echo $account_name; ?></h1>

    <!-- Display transactions in a table -->
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo $transaction['transaction_id']; ?></td>
                <td><?php echo $transaction['date']; ?></td>
                <td><?php echo $transaction['description']; ?></td>
                <td><?php echo $transaction['debit']; ?></td>
                <td><?php echo $transaction['credit']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Display the account balance -->
    <p>Account Balance: <?php echo $account_balance; ?></p>

</body>
</html>

<?php
} else {
    // If account_id is not present in the URL, handle the error or redirect to another page
    // For example:
    echo '<title>Ledger - Account ID not provided</title>';
    // You can display an error message or redirect the user to another page.
}
?>
