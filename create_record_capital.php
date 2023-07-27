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

// Fetch data from the "contribution_capital" table
$sql = "SELECT * FROM capital_contributions";
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($connection));
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Record Capital</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
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

        input[type="text"],
        input[type="date"],
        input[type="number"] {
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

        table {
            width: 80%;
            margin: 20px auto;
            margin-right: 20px;
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
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <h2>Create Record Capital</h2>
    <form action="record_capital.php" method="post">
        <label>Contributor Name:</label>
        <input type="text" name="contributor_name" required>

        <label>Contribution Date:</label>
        <input type="date" name="contribution_date" required>

        <label>Capital Amount:</label>
        <input type="number" step="0.01" name="capital_amount" required>

        <input type="submit" value="Record Capital Contribution">
    </form>

    <!-- Display the table with data from the "contribution_capital" table -->
    <table>
        <tr>
            <th>Contribution ID</th>
            <th>Contributor Name</th>
            <th>Amount</th>
            <th>Date</th>
            <!-- Add more columns if needed -->
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['contribution_id'] . '</td>';
            echo '<td>' . $row['contributor_name'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . $row['contribution_date'] . '</td>';
            // Add more columns if needed
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
