<?php
session_start();
include 'db.php';  // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if election_id is provided in the URL
if (!isset($_GET['election_id'])) {
    die("Election ID not provided.");
}

$election_id = $_GET['election_id'];

// Fetch election details
$stmt = $pdo->prepare("SELECT * FROM elections WHERE id = :election_id");
$stmt->bindParam(':election_id', $election_id);
$stmt->execute();
$election = $stmt->fetch();

// If election doesn't exist, show an error
if (!$election) {
    die("Election not found.");
}

// Fetch candidates for the selected election
$stmt = $pdo->prepare("SELECT * FROM candidates WHERE election_id = :election_id");
$stmt->bindParam(':election_id', $election_id);
$stmt->execute();
$candidates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for Election</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <span>Election Voting System</span>
    <a href="dashboard.php" class="back-btn">&#8592; </a>
</div>



    <div class="container">
        <h2>Vote for <?php echo $election['name']; ?></h2>
        <p><?php echo $election['description']; ?></p>

        <form action="submit_vote.php" method="POST">
            <input type="hidden" name="election_id" value="<?php echo $election_id; ?>">

            <h3>Select Candidate:</h3>
            
            <?php if (count($candidates) > 0): ?>
                <div class="candidate-list">
                    <?php foreach ($candidates as $candidate): ?>
                        <div>
                            <input type="radio" name="candidate_id" value="<?php echo $candidate['id']; ?>" id="candidate_<?php echo $candidate['id']; ?>" required>
                            <label for="candidate_<?php echo $candidate['id']; ?>"><?php echo $candidate['name']; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit">Submit Vote</button>
                </div>
            <?php else: ?>
                <p class="no-candidates">No candidates available for this election.</p>
            <?php endif; ?>

        </form>
    </div>
</body>
</html>
