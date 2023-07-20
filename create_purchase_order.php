<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get purchase order data from the form
    $vendor_id = $_POST['vendor_id'];
    $order_date = $_POST['order_date'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['amount'];

    // Insert purchase order data into the database table
    $query = "INSERT INTO purchase_orders (vendor_id, order_date,product_id, quantity,amount) 
              VALUES ('$vendor_id','$order_date', '$product_id', '$quantity','$price ')";

    if (mysqli_query($connection, $query)) {
        echo "Purchase order created successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>
