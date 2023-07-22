<?php
// Check if the "purchase_order_id" parameter is provided
if (!isset($_GET['purchase_order_id']) || empty($_GET['purchase_order_id'])) {
    die('Invalid request. Please select a valid purchase order.');
}

$purchase_order_id = $_GET['purchase_order_id'];

// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the purchase order details for the given "purchase_order_id"
$sql = "SELECT * FROM purchase_orders WHERE purchase_order_id = $purchase_order_id";
$result = mysqli_query($connection, $sql);

// Check if the purchase order with the provided "purchase_order_id" exists
if (mysqli_num_rows($result) == 0) {
    die('Invalid request. Purchase order not found.');
}

// Retrieve the purchase order details
$purchase_order = mysqli_fetch_assoc($result);

// Insert the purchase order data into the "completed_purchase_orders" table
$insert_sql = "INSERT INTO completed_purchase_orders (vendor_id, product_id, quantity, amount, order_date)
               VALUES ('{$purchase_order['vendor_id']}', '{$purchase_order['product_id']}', '{$purchase_order['quantity']}',
                       '{$purchase_order['amount']}', '{$purchase_order['order_date']}')";
mysqli_query($connection, $insert_sql);

// Delete the purchase order from the "purchase_orders" table
$delete_sql = "DELETE FROM purchase_orders WHERE purchase_order_id = $purchase_order_id";
mysqli_query($connection, $delete_sql);

// Close the database connection
mysqli_close($connection);

// Redirect back to the "create_purchase_invoice.php" page after completing the payment
header('Location: view_inventory_stock.php');
exit();
?>
