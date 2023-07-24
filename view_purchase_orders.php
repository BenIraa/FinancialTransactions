<!DOCTYPE html>
<html>
<head>
    <title>View Purchase Orders</title>
    <style>
        /* Your CSS styles for the specific page */
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #333;
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

        /* Style the status dropdown */
        .status-dropdown {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Style the button */
        .button-container {
            text-align: center;
        }

        .create-invoice-button {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
            background-color: #007BFF;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Purchased Orders</h2>
    <table class="invoice-table">
        <tr>
            <th>Purchase Order ID</th>
            <th>Order Date</th>
            <th>Vendor ID</th>
            <th>Amount</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
            // Database connection (replace with your database credentials)
            $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

            // Check if the connection was successful
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch the purchase order data from the database
            $sql = "SELECT * FROM purchase_orders";
            $result = mysqli_query($connection, $sql);

            // Check if the query was executed successfully
            if (!$result) {
                die("Error executing query: " . mysqli_error($connection));
            }

            // Loop through each row of data and display it in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['purchase_order_id']}</td>";
                echo "<td>{$row['order_date']}</td>";
                echo "<td>{$row['vendor_id']}</td>";
                echo "<td>{$row['amount']}</td>";

                // Get the product name from the completed_purchase_orders table based on the product_id
                $product_id = $row['product_id'];
                $sql_product = "SELECT product_name FROM completed_purchase_orders 
                                INNER JOIN products ON completed_purchase_orders.product_id = products.product_id
                                WHERE completed_purchase_orders.product_id = $product_id";
                $result_product = mysqli_query($connection, $sql_product);

                // Check if the query was executed successfully and if any rows were returned
                if (!$result_product || mysqli_num_rows($result_product) == 0) {
                    $product_name = "N/A"; // Set a default value if the product is not found
                } else {
                    $product_name = mysqli_fetch_assoc($result_product)['product_name'];
                }

                echo "<td>$product_name</td>";
                echo "<td>{$row['quantity']}</td>";

                // Create a dropdown for the status with 'completed' and 'uncompleted' options
                echo '<td>';
                echo '<select class="status-dropdown">';
                echo '<option value="uncompleted" ' . ($row['invoice_generated'] == 0 ? 'selected' : '') . '>Uncompleted</option>';
                echo '<option value="completed" ' . ($row['invoice_generated'] == 1 ? 'selected' : '') . '>Completed</option>';
                echo '</select>';
                echo '</td>';

                // Add the "Create Invoice" button for uncompleted orders
                echo '<td class="button-container">';
                if ($row['invoice_generated'] == 0) {
                    // Show the "Create Invoice" button for uncompleted orders
                    echo '<a href="create_purchase_invoice.php?purchase_order_id=' . $row['purchase_order_id'] . '">';
                    echo '<button class="create-invoice-button">Create Invoice</button>';
                    echo '</a>';

                    // Automatically delete the row from the "purchase_orders" table when the "Create Invoice" button is clicked
                    echo '<script>';
                    echo 'document.querySelector(".create-invoice-button").addEventListener("click", function() {';
                    echo '  var purchase_order_id = ' . $row['purchase_order_id'] . ';';
                    echo '  console.log("Order ID: " + purchase_order_id);'; // Add this line for debugging
                    echo '  var xhr = new XMLHttpRequest();';
                    echo '  xhr.open("POST", "delete_purchase_order.php", true);';
                    echo '  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");';
                    echo '  xhr.onreadystatechange = function () {';
                    echo '    console.log("ReadyState: " + xhr.readyState);'; // Add this line for debugging
                    echo '    console.log("Status: " + xhr.status);'; // Add this line for debugging
                    echo '    console.log("Response: " + xhr.responseText);'; // Add this line for debugging
                    echo '    if (xhr.readyState === XMLHttpRequest.DONE) {';
                    echo '      if (xhr.status === 200) {';
                    echo '        console.log("Successfully deleted order.");'; // Add this line for debugging
                    echo '        location.reload();';
                    echo '      } else {';
                    echo '        console.log("Failed to delete the purchase order.");'; // Add this line for debugging
                    echo '        alert("Failed to delete the purchase order.");';
                    echo '      }';
                    echo '    }';
                    echo '  };';
                    echo '  xhr.send(purchase_order_id=" + encodeURIComponent(purchase_order_id));';
                    echo '});';
                    echo '</script>';
                }
                echo '</td>';
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>
