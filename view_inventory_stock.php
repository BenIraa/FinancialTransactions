<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the "completed_purchase_orders" table
$sql = "SELECT * FROM completed_purchase_orders";
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($connection));
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Stock</title>
    <style>
        /* Your CSS styles for the specific page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            margin-right: 10px ;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Inventory Stock</h2>

    <!-- Display the table with data from the "completed_purchase_orders" table -->
    <table>
        <tr>
            <th>Order ID</th>
            <th>Vendor ID</th>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Order Date</th>
            <th>Completed Date</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['order_id'] . '</td>';
            echo '<td>' . $row['vendor_id'] . '</td>';
            echo '<td>' . $row['product_id'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . $row['order_date'] . '</td>';
            echo '<td>' . $row['completed_date'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
