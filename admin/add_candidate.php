<?php
include '../db.php';  // Include your database connection

// Fetch elections for the select dropdown
$electionsStmt = $pdo->prepare("SELECT * FROM elections");
$electionsStmt->execute();
$elections = $electionsStmt->fetchAll();

// Add Candidate Process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_candidate'])) {
    $election_id = $_POST['election_id'];
    $candidate_name = $_POST['candidate_name'];

    // Insert candidate into the database
    $stmt = $pdo->prepare("INSERT INTO candidates (election_id, name, votes) VALUES (?, ?, 0)");
    $stmt->execute([$election_id, $candidate_name]);

    // Set session message for success
    $_SESSION['message'] = "Candidate added successfully!";

    // Redirect after successfully adding candidate
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate</title>
    <link rel="stylesheet" href="../style.css">  <!-- Link to your CSS file -->
</head>
<body>
<div class="navbar">
    <span class="admin-title">Admin Panel</span>
    <a href="../admin.php" class="back-btn">&#8592; </a>
</div>
<div class="container">
    <h2>Add New Candidate</h2>
    <form method="POST">
        <select name="election_id" required>
            <option value="">Select Election</option>
            <?php foreach ($elections as $election): ?>
                <option value="<?php echo $election['id']; ?>"><?php echo htmlspecialchars($election['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="candidate_name" placeholder="Candidate Name" required>
        <button type="submit" name="add_candidate">Add Candidate</button>
    </form>

    <a href="admin.php" class="back-btn">Back to Admin Panel</a>
</div>

</body>
</html>
