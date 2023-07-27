<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['account_id'])) {
    $account_id = $_GET['account_id'];

    // You can redirect to the update form page passing the account_id as a parameter
    header("Location: update_form.php?account_id=$account_id");
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
