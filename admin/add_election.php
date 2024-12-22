<?php
include '../db.php';  // Include your database connection

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
    <link rel="stylesheet" href="../style.css">  <!-- Link to your CSS file -->
</head>
<body>
<div class="navbar">
    <span class="admin-title">Admin Panel</span>
    <a href="../admin.php" class="back-btn">&#8592; </a>
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
