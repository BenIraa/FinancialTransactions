<?php
// Start a new session
session_start();

// Establish a database connection (replace with your database credentials)
$connection = mysqli_connect('localhost', 'root', '', 'accounting_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the user's hashed password from the database
    $query = "SELECT user_id, password FROM users WHERE username='$username'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, store user ID in the session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;

            // Redirect to the dashboard or homepage
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}

// Close the database connection
mysqli_close($connection);
?>
