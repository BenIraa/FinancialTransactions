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
    <h2>Sold Products</h2>

    <!-- Display the table with data from the "sold_products" table -->
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity Sold</th>
            <th>Price (Existing)</th>
            <th>Sold Price</th>
            <th>Date Sold</th>
        </tr>
        <?php
        // Establish a database connection (replace with your database credentials)
        $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

        // Check if the connection was successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the sold product data from the "sold_products" table
        $sql = "SELECT sp.product_id, p.product_name, sp.quantity_sold, cp.quantity, cp.amount, sp.price, sp.date_sold
                FROM sold_products sp
                JOIN completed_purchase_orders cp ON sp.product_id = cp.product_id
                JOIN products p ON sp.product_id = p.product_id";
        $result = mysqli_query($connection, $sql);

        // Check if the query was successful
        if (!$result) {
            die("Error fetching data: " . mysqli_error($connection));
        }

        // Loop through each row of data and display it in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['quantity_sold'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['date_sold'] . '</td>';
            echo '</tr>';
        }

        // Close the database connection
        mysqli_close($connection);
        ?>
    </table>
</body>
</html>
