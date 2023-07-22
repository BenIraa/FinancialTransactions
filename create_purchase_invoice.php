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

// Calculate the total amount for the purchase order
$total_amount = $purchase_order['amount'] * $purchase_order['quantity'];

// Connect to the database to fetch the total capital contributions amount
$sql_contributions = "SELECT SUM(amount) AS total_contributions FROM capital_contributions";
$result_contributions = mysqli_query($connection, $sql_contributions);
$row_contributions = mysqli_fetch_assoc($result_contributions);
$total_capital_contributions = $row_contributions['total_contributions'];

// Calculate the remaining balance
// $remaining_balance = $total_capital_contributions - $total_amount;

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Purchase Invoice</title>
    <style>
        /* Your CSS styles for the specific page */
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .invoice-details {
            width: 50%;
            margin-left: 400px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .invoice-table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            margin-top: 30px;
            margin-right: 10px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .invoice-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Create Purchase Invoice</h2>
    <!-- Existing code for displaying the invoice details -->
    <div class="invoice-details">
        <p>Invoice for Purchase Order ID: <?php echo $purchase_order['purchase_order_id']; ?></p>
        <p>Vendor ID: <?php echo $purchase_order['vendor_id']; ?></p>
        <p>Order Date: <?php echo $purchase_order['order_date']; ?></p>
    </div>

    <table class="invoice-table">
    <tr>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Price/Unit</th>
            <th>Total Amount</th>
        </tr>
        <tr>
            <td><?php echo $purchase_order['product_id']; ?></td>
            <td><?php echo $purchase_order['quantity']; ?></td>
            <td><?php echo $purchase_order['amount']; ?></td>
            <td><?php echo $total_amount; ?></td>
        </tr>
    </table>

    <!-- Display the total amount for the purchase order -->
    <div class="invoice-details">
        <p>Total Amount for Purchase Order: <?php echo $total_amount; ?></p>
    </div>

    <!-- Display the remaining balance -->
    <!-- <div class="invoice-details">
        <p>Remaining Balance: <?php echo $remaining_balance; ?></p>
    </div> -->

    <!-- Add the "Pay Bill" button with the link to mark the purchase order as paid -->
    <div class="invoice-details">
        <?php
        $pay_bill_link = "pay_bill.php?purchase_order_id=" . $purchase_order_id;
        ?>
        <a href="<?php echo $pay_bill_link; ?>">Pay Bill</a>
    </div>
</body>
</html>
