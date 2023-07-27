<?php
// Establish a database connection (replace with your database credentials)
include 'db_connection.php';
// Check if the connection was successful

if (isset($_GET['account_id'])) {
    $account_id = $_GET['account_id'];

    // Fetch the account details from the database
    $sql_fetch_account = "SELECT * FROM accounts WHERE account_id = $account_id";
    $result_fetch_account = mysqli_query($connection, $sql_fetch_account);
    $row_account = mysqli_fetch_assoc($result_fetch_account);

    // You can display the update form here with the fetched account details
    // For example:
    echo '<form method="post">';
    echo '<input type="hidden" name="account_id" value="' . $row_account['account_id'] . '">';
    echo '<input type="text" name="account_name" placeholder="Account Name" required value="' . htmlspecialchars($row_account['account_name']) . '">';
    echo '<select name="account_type" required>';
    // ... Display the select options (similar to the form in accounts.php) ...
    echo '</select>';
    echo '<input type="number" name="account_balance" value="' . $row_account['account_balance'] . '">';
    echo '<input type="submit" name="update_account" value="Update Account">';
    echo '</form>';
}

// Close the database connection
mysqli_close($connection);
?>
