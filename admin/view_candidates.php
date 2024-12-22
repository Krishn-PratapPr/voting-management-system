<?php
session_start();
include '../db.php';  // Include your database connection
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: adminlogin.php');
    exit;
}
// Fetch candidates data
$stmt = $pdo->prepare("SELECT candidates.id, candidates.name, elections.name AS election_name, candidates.votes
                       FROM candidates
                       JOIN elections ON candidates.election_id = elections.id");
$stmt->execute();
$candidates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Candidates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
<span class="admin-title" style="width:90%">Admin Panel</span>
</div>
<div class="container">
    <h2>All Candidates</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Election</th>
                <th>Votes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($candidates as $candidate): ?>
            <tr>
                <td><?php echo $candidate['id']; ?></td>
                <td><?php echo $candidate['name']; ?></td>
                <td><?php echo $candidate['election_name']; ?></td>
                <td><?php echo $candidate['votes']; ?></td>
                <td>
                    <a href="edit_candidate.php?id=<?php echo $candidate['id']; ?>">Edit</a>
                    <a href="delete_candidate.php?id=<?php echo $candidate['id']; ?>" onclick="return confirm('Are you sure you want to delete this candidate?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin.php" class="back-btn">Back to Admin Panel</a>
</div>

</body>
</html>
