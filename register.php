<?php
// Establish a database connection (replace with your database credentials)
include 'db_connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Insert user data into the "users" table
    $query = "INSERT INTO users (username, password, full_name, email, role) 
              VALUES ('$username', '$password', '$full_name', '$email', '$role')";

    if (mysqli_query($connection, $query)) {
        // Get the user_id of the newly registered user
        $user_id = mysqli_insert_id($connection);

        // Create a single set of tables for all users
       
        // Create the sold_products table
        $createTableSoldProductsQuery = "CREATE TABLE IF NOT EXISTS sold_products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            product_name VARCHAR(255),
            quantity_sold INT,
            price DECIMAL(10, 2),
            date_sold DATE
        )";
        mysqli_query($connection, $createTableSoldProductsQuery);

        // Create the completed_purchase_orders table
        $createTableCompletedPurchaseOrdersQuery = "CREATE TABLE IF NOT EXISTS completed_purchase_orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            product_name VARCHAR(255),
            quantity INT,
            amount DECIMAL(10, 2),
            date_purchased DATE
        )";
        mysqli_query($connection, $createTableCompletedPurchaseOrdersQuery);

        // Repeat the above steps for all the other tables you have
        $createTableAccount = "CREATE TABLE IF NOT EXISTS accounts (`account_id` int(11) NOT NULL,
        `account_name` varchar(100) NOT NULL,
        `account_type` varchar(50) NOT NULL,
        `account_balance` float NOT NULL DEFAULT 0
      ) ";
        mysqli_query($connection, $createTableAccount);

        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>



