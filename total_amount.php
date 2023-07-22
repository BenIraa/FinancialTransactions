<!DOCTYPE html>
<html>
<head>
    <title>Total Amount of Business</title>
    <style>
        /* Your CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
        }

        h1,h4 {
            text-align: center;
            color: #333;
        }

        .total-amount {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <?php
    // Establish a database connection (replace with your database credentials)
    $connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

    // Check if the connection was successful
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch the account_balance for accounts named "Bank" and "Cash" from the accounts table
    $sql = "SELECT SUM(account_balance) AS total_amount FROM accounts WHERE account_name IN ('Bank', 'Cash')";
    $result = mysqli_query($connection, $sql);

    // Check if the query was successful
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_amount = $row['total_amount'];
    } else {
        $total_amount = 0;
    }

    // Close the database connection
    mysqli_close($connection);
    ?>

    <h1>Total Amount of Business</h1>
    <div>
        <h4>Both in Bank and Cash</h4>

    </div>
    <div class="total-amount">
        Total Amount: <?php echo $total_amount; ?>
    </div>
</body>
</html>
