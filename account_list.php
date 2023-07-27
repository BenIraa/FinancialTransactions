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
    <title>Account List</title>
    <style>
        body {
            font-family: 'nunito', sans-serif;
            background-color: #f2f2f2;
            margin-left: 250px;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        li {
            margin: 10px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
            width: 200px;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        a {
            text-decoration: none;
            color: #007bff;
            
            font-size: 18px;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <?php
    include 'db_connection.php';

    // Retrieve all accounts from the accounts table
    $accounts_query = "SELECT * FROM accounts";
    $result_accounts = mysqli_query($connection, $accounts_query);
    ?>

    <h1>Account List</h1>
    <ul>
        <?php while ($account_row = mysqli_fetch_assoc($result_accounts)) { ?>
            <li>
                <a href="ledger.php?account_id=<?php echo $account_row['account_id']; ?>">
                    <?php echo $account_row['account_name']; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
