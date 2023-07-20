<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get journal entry data from the form
    $entry_date = $_POST['entry_date'];
    $account = $_POST['account'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    // Insert journal entry data into the "journal_entries" table
    $query = "INSERT INTO journal_entries (entry_date, account, description, amount) 
              VALUES ('$entry_date', '$account', '$description', '$amount')";

    if (mysqli_query($connection, $query)) {
        echo "Journal entry recorded successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>
