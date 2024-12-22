<?php
include '../db.php';  // Correct path to db.php

if (isset($_GET['id'])) {
    $election_id = $_GET['id'];

    // Fetch election data
    $stmt = $pdo->prepare("SELECT * FROM elections WHERE id = ?");
    $stmt->execute([$election_id]);
    $election = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated data
        $election_name = $_POST['election_name'];
        $election_description = $_POST['election_description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Update election in database
        $stmt = $pdo->prepare("UPDATE elections SET name = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->execute([$election_name, $election_description, $start_date, $end_date, $election_id]);

        $_SESSION['message'] = "Election updated successfully!";
        header('Location: view_elections.php');
        exit;
    }
} else {
    echo "Election ID is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Election</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="navbar">
    <span class="admin-title">Admin Panel</span>
    <a href="../admin.php" class="back-btn">&#8592; </a>
</div>
<div class="container">
    <h2>Edit Election</h2>
    <form method="POST">
        <input type="text" name="election_name" value="<?php echo $election['name']; ?>" required>
        <textarea name="election_description" required><?php echo $election['description']; ?></textarea>
        <input type="date" name="start_date" value="<?php echo $election['start_date']; ?>" required>
        <input type="date" name="end_date" value="<?php echo $election['end_date']; ?>" required>
        <button type="submit">Update Election</button>
    </form>

    <a href="view_elections.php" class="back-btn">Back to Elections</a>
</div>

</body>
</html>
