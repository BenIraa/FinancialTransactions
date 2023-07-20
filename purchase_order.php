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
    <title>Create Purchase Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <h2>Create Purchase Order</h2>
    <form action="create_purchase_order.php" method="post">
        <label>Vendor:</label>
        <select name="vendor_id" required>
            <!-- Retrieve and populate vendor options from the database -->
            <?php
            // Establish a database connection (replace with your database credentials)
            $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

            // Retrieve vendors from the database
            $query = "SELECT vendor_id, vendor_name FROM vendors";
            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['vendor_id'] . '">' . $row['vendor_name'] . '</option>';
            }

            // Close the database connection
            mysqli_close($connection);
            ?>
        </select><br>

        <label>Order Date:</label>
        <input type="date" name="order_date" required><br>

        <label>Product:</label>
        <select name="product_id" required>
            <!-- Retrieve and populate product options from the database -->
            <?php
            // Establish a database connection (replace with your database credentials)
            $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

            // Retrieve products from the database
            $query = "SELECT product_id, product_name FROM products";
            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['product_id'] . '">' . $row['product_name'] . '</option>';
            }

            // Close the database connection
            mysqli_close($connection);
            ?>
        </select><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label>Unit Price:</label>
        <input type="number"  name="amount" required><br>

        <input type="submit" value="Create Purchase Order">
    </form>
</body>
</html>
