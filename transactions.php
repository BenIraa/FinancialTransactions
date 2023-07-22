<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_transaction'])) {
    // Step 1: Capture Transaction Details
    $date = $_POST['date'];
    $description = $_POST['description'];
    $account_id = $_POST['account_id'];
    $type = $_POST['type'];
    $debit = $_POST['debit_account_id'];
    $credit = $_POST['credit_account_id'];
    $amount = $_POST['amount'];

    // Step 2: Insert Transaction into "transactions" Table
    $sql_insert_transaction = "INSERT INTO transactions (date, description, account_id, type, debit_account_id, credit_account_id, amount) VALUES ('$date', '$description', '$account_id', '$type', $debit, $credit, $amount)";

    if (mysqli_query($connection, $sql_insert_transaction)) {
        // Transaction inserted successfully

        // Step 3: Record Journal Entry and Update Account Balances
        // Note: For simplicity, we assume the account_id for debit and credit accounts are already provided in the form.
        $debit_account_id = $_POST['debit_account_id'];
        $credit_account_id = $_POST['credit_account_id'];

        if ($type === 'Debit') {
            // Debit transaction
            $sql_update_debit_account = "UPDATE accounts SET account_balance = account_balance + $amount WHERE account_id = $account_id";
            $sql_update_credit_account = "UPDATE accounts SET account_balance = account_balance - $amount WHERE account_id = $credit_account_id";
        } else {
            // Credit transaction
            $sql_update_debit_account = "UPDATE accounts SET account_balance = account_balance - $amount WHERE account_id = $debit_account_id";
            $sql_update_credit_account = "UPDATE accounts SET account_balance = account_balance + $amount WHERE account_id = $account_id";
        }

        mysqli_query($connection, $sql_update_debit_account);
        mysqli_query($connection, $sql_update_credit_account);

        // Redirect to the same page to display the updated transactions and account balances
        header('Location: transactions.php');
        exit();
    } else {
        // Failed to insert transaction
        // Handle the error
    }
}

// Fetch transactions
$sql_fetch_transactions = "SELECT * FROM transactions";
$result_transactions = mysqli_query($connection, $sql_fetch_transactions);

// Fetch accounts
$sql_fetch_accounts = "SELECT * FROM accounts";
$result_accounts = mysqli_query($connection, $sql_fetch_accounts);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <style>
        /* Your CSS styles for the specific page */
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #333;
        }

       
        form {
            width: 60%;
            margin: auto;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="number"],
        form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form select {
            height: 36px;
        }

        form input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 80%;
            margin: auto;
            margin-top: 30px;
            margin-right: 10px;
            border-collapse: collapse;
            text-align: left;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <center><h2>Transactions</h2></center>

    <!-- Transaction Form -->
    <form method="POST">
        <label for="date">Date:</label>
        <input type="date" name="date" required>

        <label for="description">Description:</label>
        <input type="text" name="description" required>

        <label for="account_id">Account:</label>
        <select name="account_id" required>
            <option value="" disabled selected>Select Account</option>
            <?php
            while ($row_accounts = mysqli_fetch_assoc($result_accounts)) {
                echo '<option value="' . $row_accounts['account_id'] . '">' . $row_accounts['account_name'] . '</option>';
            }
            ?>
        </select>

        <label for="type">Transaction Type:</label>
        <select name="type" required>
            <option value="" disabled selected>Select Transaction Type</option>
            <option value="Debit">Debit</option>
            <option value="Credit">Credit</option>
        </select>
        <label for="debit_account_id">Debit Account:</label>
        <select name="debit_account_id" required>
            <option value="" disabled selected>Select Debit Account</option>
            <?php
            mysqli_data_seek($result_accounts, 0); // Reset result pointer to the beginning
            while ($row_accounts = mysqli_fetch_assoc($result_accounts)) {
                echo '<option value="' . $row_accounts['account_id'] . '">' . $row_accounts['account_name'] . '</option>';
            }
            ?>
        </select>

        <label for="credit_account_id">Credit Account:</label>
        <select name="credit_account_id" required>
            <option value="" disabled selected>Select Credit Account</option>
            <?php
            mysqli_data_seek($result_accounts, 0); // Reset result pointer to the beginning
            while ($row_accounts = mysqli_fetch_assoc($result_accounts)) {
                echo '<option value="' . $row_accounts['account_id'] . '">' . $row_accounts['account_name'] . '</option>';
            }
            ?>
        </select>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" min="0" step="0.01" required>

        <!-- Additional input fields for debit and credit accounts -->
       

        <input type="submit" name="add_transaction" value="Add Transaction">
    </form>

    <!-- Display Transactions -->
    <h3>Transaction History</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Description</th>
            <!-- <th>Account Name</th> -->
            <th>Transaction Type</th>
            <th>Debited Account</th>
            <th>Credit Account</th>
            <th>Account</th>

        </tr>
        <?php
        while ($row_transactions = mysqli_fetch_assoc($result_transactions)) {
            echo '<tr>';
            echo '<td>' . $row_transactions['transaction_id'] . '</td>';
            echo '<td>' . $row_transactions['date'] . '</td>';
            echo '<td>' . $row_transactions['description'] . '</td>';
            $debit_account_name = '';
            $credit_account_name = '';
            $accountname = '';

            // Fetch debit and credit account names based on account IDs
            $debit_account_query = mysqli_query($connection, "SELECT account_name FROM accounts WHERE account_id = {$row_transactions['debit_account_id']}");
            $credit_account_query = mysqli_query($connection, "SELECT account_name FROM accounts WHERE account_id = {$row_transactions['credit_account_id']}");
            $accountname_query = mysqli_query($connection, "SELECT account_name FROM accounts WHERE account_id = {$row_transactions['account_id']}");

            if ($debit_account_query) {
                $debit_account_row = mysqli_fetch_assoc($debit_account_query);
                if (isset($debit_account_row['account_name'])) {
                    $debit_account_name = $debit_account_row['account_name'];
                } else {
                    // Handle case when 'account_name' key is not present
                    $debit_account_name = 'N/A';
                }
            }

            if ($credit_account_query) {
                $credit_account_row = mysqli_fetch_assoc($credit_account_query);
                if (isset($credit_account_row['account_name'])) {
                    $credit_account_name = $credit_account_row['account_name'];
                } else {
                    // Handle case when 'account_name' key is not present
                    $credit_account_name = 'N/A';
                }
            }

            
            // echo '<td>' . $debit_account_name . '</td>';
            echo '<td>' . $row_transactions['type'] . '</td>';
            // Fetch debit and credit account names based on account IDs
       
            echo '<td>' . $debit_account_name . '</td>';
            echo '<td>' . $credit_account_name . '</td>';
            echo '<td>' . $row_transactions['amount'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
