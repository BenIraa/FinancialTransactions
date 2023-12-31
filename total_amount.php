<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Total Amount of Business</title>
    <style>
        /* Your CSS styles for the page */
        body {
            font-family: 'Nunito', sans-serif;
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
    include 'db_connection.php';

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
