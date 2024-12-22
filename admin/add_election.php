<?php
session_start();
include '../db.php';  // Include your database connection
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: adminlogin.php');
    exit;
}
// Add Election Process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_election'])) {
    $election_name = $_POST['election_name'];
    $election_description = $_POST['election_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Insert election into the database
    $stmt = $pdo->prepare("INSERT INTO elections (name, description, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$election_name, $election_description, $start_date, $end_date]);

    // Set session message for success
    $_SESSION['message'] = "Election added successfully!";

    // Redirect after successfully adding election
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Election</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        /* Additional Styles for Add Election Page */
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            height: 100px;
            box-sizing: border-box;
        }

        input[type="date"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        button[type="submit"] {
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            input, textarea, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="admin.php" class="back-btn">&#8592;</a>
    <span class="admin-title">Admin Panel</span>
</div>

<div class="container">
    <h2>Add New Election</h2>
    <form method="POST">
        <input type="text" name="election_name" placeholder="Election Name" required>
        <textarea name="election_description" placeholder="Election Description" required></textarea>
        <input type="date" name="start_date" required>
        <input type="date" name="end_date" required>
        <button type="submit" name="add_election">Add Election</button>
    </form>

    <a href="admin.php" class="back-btn">Back to Admin Panel</a>
</div>
</body>
</html>
