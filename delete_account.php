<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['account_id'])) {
    $account_id = $_GET['account_id'];

    // Delete the account from the "accounts" table
    $sql_delete_account = "DELETE FROM accounts WHERE account_id = $account_id";

    if (mysqli_query($connection, $sql_delete_account)) {
        // Account deleted successfully

        // You can redirect to the accounts.php page or display a success message here
        header('Location: accounts.php');
        exit();
    } else {
        // Failed to delete account
        // You can redirect to an error page or display an error message here
    }
}

// Close the database connection
mysqli_close($connection);
?>
