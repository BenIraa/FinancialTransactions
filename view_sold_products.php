<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Sold Products</title>
    <!-- Your CSS styles here -->
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
            margin-right: 10px;
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
    <h2>Sold Products</h2>

    <!-- Display the table with data from the "sold_products" table -->
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity Sold</th>
            <th>Remainng Quantity </th>
            <th>Price (Existing)</th>
            <th>Sold Price</th>
            <th>Date Sold</th>
            <th>Total</th>
        </tr>
        <?php
        // Establish a database connection (replace with your database credentials)
        $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

        // Check if the connection was successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the sold product data from the "sold_products" table
        $sql = "SELECT sp.product_id, p.product_name, sp.quantity_sold, cp.quantity, cp.amount, sp.price, sp.remaining_quantity, sp.date_sold
                FROM sold_products sp
                JOIN completed_purchase_orders cp ON sp.product_id = cp.product_id
                JOIN products p ON sp.product_id = p.product_id";
        $result = mysqli_query($connection, $sql);

        // Check if the query was successful
        if (!$result) {
            die("Error fetching data: " . mysqli_error($connection));
        }

        // Initialize the total amount variable
        $totalAmount = 0;

        // Loop through each row of data and display it in the table
        while ($row = mysqli_fetch_assoc($result)) {
            // Calculate the total for each row (quantity_sold * price)
            $total = $row['quantity_sold'] * $row['price'];

            echo '<tr>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['quantity_sold'] . '</td>';
            echo '<td>' . $row['remaining_quantity'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['date_sold'] . '</td>';
            echo '<td>' . $total . '</td>';
            echo '</tr>';

            // Add the row total to the total amount
            $totalAmount += $total;
        }

        // Close the database connection
        mysqli_close($connection);
        ?>
    </table>

    <!-- Display the sum of the "Total" column at the end of the table -->
    <p>Total Amount: <?php echo $totalAmount; ?></p>
</body>
</html>
