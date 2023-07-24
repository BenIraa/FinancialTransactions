<?php
// Retrieve the product ID from the URL parameter
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    // Redirect back to the inventory stock page if product ID is not provided
    header("Location: view_inventory_stock.php");
    exit;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $quantityToSell = (int)$_POST['quantity'];
    $soldPrice = (float)$_POST['sold_price'];
    $dateSold = $_POST['date'];

    // Establish a new database connection (replace with your database credentials)
    $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

    // Check if the connection was successful
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch the available quantity of the selected product from the completed_purchase_orders table
    $sql = "SELECT quantity FROM completed_purchase_orders WHERE product_id = $product_id";
    $result = mysqli_query($connection, $sql);

    // Check if the product exists in the completed_purchase_orders table
    if (mysqli_num_rows($result) === 0) {
        echo '<p>Selected product does not exist or is not available for sale.</p>';
    } else {
        $row = mysqli_fetch_assoc($result);
        $availableQuantity = (int)$row['quantity'];

        // Check if the quantity to sell is valid
        if ($quantityToSell > $availableQuantity) {
            echo '<center><p style="color:red;">Cannot sell more quantity than available.</p></center>';
        } else {
            // Insert the sale data into the sold_products table
            $sql = "INSERT INTO sold_products (product_id, quantity_sold, price, date_sold) VALUES ($product_id, $quantityToSell, $soldPrice, '$dateSold')";
            mysqli_query($connection, $sql);

            // Update the remaining quantity in the completed_purchase_orders table
            $remainingQuantity = $availableQuantity - $quantityToSell;
            $sql = "UPDATE completed_purchase_orders SET quantity = $remainingQuantity WHERE product_id = $product_id";
            mysqli_query($connection, $sql);
            // Calculate the total sale amount (price * quantity) for the sale
            $totalSaleAmount = $soldPrice * $quantityToSell;

            // Update the sales amount in the accounts table
            // $sql = "UPDATE accounts SET account_balance = account_balance + $totalSaleAmount WHERE account_name = 'Sales'";
            // mysqli_query($connection, $sql);

            // Display success message
            echo '<p>Product sold successfully.</p>';
        }
    }

    // Close the database connection
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sell Product</title>
    <!-- Your CSS styles here -->
    <style>
                body {
            font-family: 'Nunito', sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        form {
            width: 50%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h1>Sell Product</h1>
    <form method="post">
        <!-- The form for selling product will be created here -->
        <!-- Include product details here based on the $product_id -->

        <label for="quantity">Quantity to Sell:</label>
        <input type="number" name="quantity" required>

        <label for="sold_price">Sold Price:</label>
        <input type="number" name="sold_price" step="0.01" required>

        <label for="date">Date of Sale:</label>
        <input type="date" name="date" required>

        <button type="submit">Sell</button>
    </form>
</body>
</html>
