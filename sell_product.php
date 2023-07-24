<!-- sell_product.php -->

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

    // Validation and selling process will be done here
    // ...
    // Insert the sale data into the product_sales table
    // Update the remaining quantity in the completed_purchase_orders table
    // ...
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sell Product</title>
    <!-- Your CSS styles here -->
    <style>
                body {
            font-family: Arial, sans-serif;
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
