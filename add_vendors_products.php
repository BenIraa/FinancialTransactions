<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to store form input data for vendors
$vendor_name = $contact_person = $phone = $email = "";

// Handle form submissions for adding a new vendor
if (isset($_POST['add_vendor'])) {
    $vendor_name = $_POST['vendor_name'];
    $contact_person = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Insert the new vendor into the "vendors" table
    $sql = "INSERT INTO vendors (vendor_name, contact_person, phone, email) VALUES ('$vendor_name', '$contact_person', '$phone', '$email')";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        // Vendor added successfully
        // You can redirect to a success page or display a success message here
    } else {
        // Failed to add vendor
        // You can redirect to an error page or display an error message here
    }
}

// Initialize variables to store form input data for products
$product_name = $description = $unit_price = "";

// Handle form submissions for adding a new product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $unit_price = $_POST['unit_price'];

    // Insert the new product into the "products" table
    $sql = "INSERT INTO products (product_name, description, unit_price) VALUES ('$product_name', '$description', '$unit_price')";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        // Product added successfully
        // You can redirect to a success page or display a success message here
    } else {
        // Failed to add product
        // You can redirect to an error page or display an error message here
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Vendors and Products</title>
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

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Add Vendors and Products</h2>
    <!-- Form for adding a new vendor -->
    <form method="post">
        <h3>Add New Vendor</h3>
        <input type="text" name="vendor_name" placeholder="Vendor Name" required>
        <input type="text" name="contact_person" placeholder="Contact Person" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="submit" name="add_vendor" value="Add Vendor">
    </form>

    <!-- Form for adding a new product -->
    <form method="post">
        <h3>Add New Product</h3>
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="text" name="unit_price" placeholder="Unit Price" required>
        <input type="submit" name="add_product" value="Add Product">
    </form>
</body>
</html>
