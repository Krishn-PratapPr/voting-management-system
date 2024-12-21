<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard if already logged in
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Welcome to the Voting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        .container {
            padding: 50px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Welcome to the Online Voting System</h1>
    </div>

    <div class="container">
        <p>Welcome to the online voting system. Please log in to vote or register if you don't have an account.</p>
        <a href="login.php" class="button">Login</a>
        <a href="register.php" class="button">Register</a>
    </div>

</body>
</html>
