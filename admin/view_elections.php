<?php
session_start();
include '../db.php';  // Include your database connection
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: adminlogin.php');
    exit;
}
// Fetch elections data
$stmt = $pdo->prepare("SELECT * FROM elections");
$stmt->execute();
$elections = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Elections</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
<span class="admin-title" style="width:90%">Admin Panel</span>
</div>
<div class="container">
    <h2>All Elections</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($elections as $election): ?>
            <tr>
                <td><?php echo $election['id']; ?></td>
                <td><?php echo $election['name']; ?></td>
                <td><?php echo $election['description']; ?></td>
                <td><?php echo $election['start_date']; ?></td>
                <td><?php echo $election['end_date']; ?></td>
                <td>
                    <a href="edit_election.php?id=<?php echo $election['id']; ?>">Edit</a>
                    <a href="delete_election.php?id=<?php echo $election['id']; ?>" onclick="return confirm('Are you sure you want to delete this election?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin.php" class="back-btn">Back to Admin Panel</a>
</div>

</body>
</html>
