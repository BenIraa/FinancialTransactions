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
    <title>Record Journal Entry</title>
    <style>
        
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
    </style>
  
</head>
<body>
<?php include 'sidebar.php'; ?>
    <h2>Record Journal Entry</h2>
    <form action="record_journal_entry.php" method="post">
        <label>Entry Date:</label>
        <input type="date" name="entry_date" required>

        <label>Account:</label>
        <input type="text" name="account" required>

        <label>Description:</label>
        <input type="text" name="description" required>

        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" required>

        <input type="submit" value="Record Journal Entry">
    </form>
</body>
</html>
