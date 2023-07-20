<?php
// Check if the "order_id" parameter is provided
if (!isset($_POST['purhase_order_id']) || empty($_POST['purchase_order_id'])) {
    die('Invalid request. Please provide a valid purchase order ID.');
}

$order_id = $_POST['purchase_order_id'];

// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Perform the deletion operation (assuming you have a primary key named "order_id" in the "purchase_orders" table)
$sql = "DELETE FROM purchase_orders WHERE purchase_order_id = $order_id";
$result = mysqli_query($connection, $sql);

// Close the database connection
mysqli_close($connection);

// Return a response to indicate the success or failure of the deletion
if ($result) {
    echo "success";
} else {
    echo "error";
}
?>
