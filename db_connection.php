<?php
// Replace with your database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'accounting_system';

// Establish a database connection
$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
