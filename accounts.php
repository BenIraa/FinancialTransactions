<?php
// Start the session
session_start();


// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<?php
// Establish a database connection (replace with your database credentials)
include 'db_connection.php';

// Initialize variables to store form input data
$account_name = $account_type = "";
$errors = array();

// Handle form submissions for adding a new account
if (isset($_POST['add_account'])) {
    $account_name = $_POST['account_name'];
    $account_type = $_POST['account_type'];
    $account_balance = $_POST['account_balance'];

    // Validate form input
    if (empty($account_name)) {
        $errors[] = "Account name is required";
    }

    if (empty($account_type)) {
        $errors[] = "Account type is required";
    }

    // if (empty($account_balance)) {
    //     $errors[] = "Account Balance type is required";
    // }

    // Insert the new account into the "accounts" table if there are no errors
    if (empty($errors)) {
        $sql = "INSERT INTO accounts (account_name, account_type,account_balance ) VALUES ('$account_name', '$account_type', '$account_balance')";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            // Account added successfully
            // You can redirect to a success page or display a success message here
            $account_name = $account_type = ""; // Clear form input after successful submission
        } else {
            // Failed to add account
            // You can redirect to an error page or display an error message here
        }
    }
}

// Fetch all existing accounts from the "accounts" table
$sql = "SELECT * FROM accounts";
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching accounts: " . mysqli_error($connection));
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accounts</title>
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
            font-family: 'Nunito', sans-serif;
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 4px;
            
        }

        form label {
            font-family: 'Nunito', sans-serif;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        select,
        input[type="submit"],
        input[type="number"] {
            font-family: 'Nunito', sans-serif;
            width: 98%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: gray;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }



        table {
            width: 80%;
            margin: 20px auto;
            margin-right:10px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
         /* Style for the "Delete" link */
        a.delete-link {
            color: #f00; /* Set the color to red */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Make the text bold */
            margin-right: 5px; /* Add some spacing to the right */
        }

        /* Style for the "Delete" link on hover */
        a.delete-link:hover {
            text-decoration: none; /* Add underline on hover */
        }
            /* Style for the "Update" link */
        a.update-link {
            color: #007bff; /* Set the color to blue */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Make the text bold */
        }

        /* Style for the "Update" link on hover */
        a.update-link:hover {
            text-decoration: underline; /* Add underline on hover */
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Accounts</h2>

    <!-- Form for adding a new account -->
    <form method="post">
        <input type="text" name="account_name" placeholder="Account Name" required value="<?php echo htmlspecialchars($account_name); ?>">
        <select name="account_type" required>
            <option value="" disabled selected>Select Account Type</option>
            <option value="Asset" <?php if ($account_type === 'Asset') echo 'selected'; ?>>Asset</option>
            <option value="Liability" <?php if ($account_type === 'Liability') echo 'selected'; ?>>Liability</option>
            <option value="Equity" <?php if ($account_type === 'Equity') echo 'selected'; ?>>Equity</option>
            <option value="Income" <?php if ($account_type === 'Income') echo 'selected'; ?>>Income</option>
            <option value="Expense" <?php if ($account_type === 'Expense') echo 'selected'; ?>>Expense</option>
            <option value="cogs" <?php if ($account_type === 'COGS') echo 'selected'; ?>>Cost of Good sold</option>
            <option value="Other" <?php if ($account_type === 'Other') echo 'selected'; ?>>Other</option>
            <option value="Other_income" <?php if ($account_type === 'Otherincome') echo 'selected'; ?>>Other Income</option>
        </select>
        <label for="account_balance">Account Balance:</label>
        <input type="number" name="account_balance"  value="0"  >
        <input type="submit" name="add_account" value="Add Account">
        <?php
        // Display validation errors, if any
        if (!empty($errors)) {
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li style="color: red;">' . $error . '</li>';
            }
            echo '</ul>';
        }
        ?>
    </form>

    <!-- Display the table with existing accounts -->
    <table>
        <tr>
            <th>Account ID</th>
            <th>Account Name</th>
            <th>Account Type</th>
            <th>Account Balance</th>
            <th>Actions</th>
            
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['account_id'] . '</td>';
            echo '<td>' . $row['account_name'] . '</td>';
            echo '<td>' . $row['account_type'] . '</td>';
            echo '<td>' . $row['account_balance'] . '</td>';
            
            // Add delete button with a link to delete_account.php passing the account_id as a parameter
            echo '<td><a class="delete-link" href="delete_account.php?account_id=' . $row['account_id'] . '">Delete</a></td>';
            // echo '<a class="update-link" href="update_account.php?account_id=' . $row['account_id'] . '">Update</a>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
