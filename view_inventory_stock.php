<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<?php
// Establish a database connection (replace with your database credentials)
include 'db_connection.php';

// Fetch data from the "completed_purchase_orders" table
$sql = "SELECT completed_purchase_orders.*, products.product_name 
        FROM completed_purchase_orders 
        INNER JOIN products ON completed_purchase_orders.product_id = products.product_id";
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
            font-family: 'Nunito', sans-serif;
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
        /* Style the "Sell" link */
        .td a {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .sell-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Purchases</h2>

    <!-- Display the table with data from the "completed_purchase_orders" table -->
    <table>
        <tr>
            <th>Order ID</th>
            <th>Vendor ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Order Date</th>
            <th>Completed Date</th>
            <th>Sell</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['order_id'] . '</td>';
            echo '<td>' . $row['vendor_id'] . '</td>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . $row['order_date'] . '</td>';
            echo '<td>' . $row['completed_date'] . '</td>';
            echo '<td><a href="sell_product.php?id=' . $row['product_id'] . '">Sell</a></td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
