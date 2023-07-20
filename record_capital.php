<?php
// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get capital contribution data from the form
    $contributor_name = $_POST['contributor_name'];
    $contribution_date = $_POST['contribution_date'];
    $capital_amount = $_POST['capital_amount'];

    // Insert capital contribution data into the "capital_contributions" table
    $query = "INSERT INTO capital_contributions (contributor_name, contribution_date, amount) 
              VALUES ('$contributor_name', '$contribution_date', '$capital_amount')";

    if (mysqli_query($connection, $query)) {
        echo "Capital contribution recorded successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>
