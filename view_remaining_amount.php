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

// Fetch the remaining balance from the "capital_contributions" table
$sql_contributions = "SELECT amount FROM capital_contributions";
$result_contributions = mysqli_query($connection, $sql_contributions);
$row_contributions = mysqli_fetch_assoc($result_contributions);
$remaining_balance = $row_contributions['amount'];

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Remaining Amount</title>
    <style>
                /* CSS reset to remove default margin and padding */
                body, h2, h3, p, table {
            margin: 0;
            padding: 0;
        }

        /* Center the content */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        /* Additional styling for the remaining balance section and the contribution table */
        .remaining-balance {
            
            margin-bottom: 20px;
            margin-right: 80px;
        }

        .contribution-table {
            border-collapse: collapse;
            width: 100%;
        }

        .contribution-table th, .contribution-table td {
            border: 1px solid #ccc;
            padding: 8px;
            
        }

        .contribution-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>View Remaining Amount</h2>
    <h6>Capital Contributions Table</h6>
    <br>
    <table class="contribution-table">
        <tr>
            <th>Contribution ID</th>
            <th>Amount</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php
        // Establish a new database connection for fetching the contribution table data
        $connection_contribution = mysqli_connect('localhost', 'root', '', 'accounting_system');
        if (!$connection_contribution) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the data from the "capital_contributions" table
        $sql_contribution = "SELECT * FROM capital_contributions";
        $result_contribution = mysqli_query($connection_contribution, $sql_contribution);

        // Loop through the contribution data and display it in the table
        while ($row_contribution = mysqli_fetch_assoc($result_contribution)) {
            echo "<tr>";
            echo "<td>{$row_contribution['contribution_id']}</td>";
            echo "<td>{$row_contribution['amount']}</td>";
            // Add more columns as needed
            echo "</tr>";
        }

        // Close the database connection for the contribution table
        mysqli_close($connection_contribution);
        ?>
    </table>
</body>
</html>
