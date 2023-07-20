<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accounting System Dashboard</title>
    <style>
        /* Your dashboard and sidebar CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .dashboard-container {
            /* Your dashboard container styles */
        }

        .sidebar {
            width: 200px;
            height: 100%;
            background-color: #333;
            padding: 20px;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 220px; /* Adjust this to give space for the sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Include the sidebar content -->

    <div class="content">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <!-- Your dashboard content here -->
        <p>This is your accounting system dashboard.</p>
        <p>You can add transactions, generate reports, and perform various accounting tasks here.</p>
    </div>
</body>
</html>
