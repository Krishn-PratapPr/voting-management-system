<?php
session_start();
include 'db.php';  // Ensure this includes the database connection

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch available elections from the database
$stmt = $pdo->prepare("SELECT * FROM elections");
$stmt->execute();
$elections = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <span>Welcome,
            <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></span>
    </div>

    <div class="container">
        <h2>Available Elections</h2>
        <?php if (count($elections) > 0): ?>
            <ul class="election-list">
                <?php foreach ($elections as $election): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($election['name']); ?></strong><br>
                        <?php echo htmlspecialchars($election['description']); ?><br>
                        <a href="vote.php?election_id=<?php echo htmlspecialchars($election['id']); ?>">Vote Now</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No elections available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Logout Button at the bottom -->
    <div class="logout-container">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>

</html>