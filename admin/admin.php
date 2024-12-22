<?php
session_start();
include '../db.php';  // Include your database connection

// Redirect to admin login if not logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: adminlogin.php');
    exit;
}

// Fetch elections for the select dropdown (if needed)
$electionsStmt = $pdo->prepare("SELECT * FROM elections");
$electionsStmt->execute();
$elections = $electionsStmt->fetchAll();

// Check if an election is selected via GET request
$election_id = isset($_GET['election_id']) ? $_GET['election_id'] : null;

// Fetch election results for the selected election
$results = [];
if ($election_id) {
    $stmt = $pdo->prepare("SELECT e.id AS election_id, e.name AS election_name, c.name AS candidate_name, c.votes 
                           FROM elections e
                           LEFT JOIN candidates c ON e.id = c.election_id
                           WHERE e.id = ?");
    $stmt->execute([$election_id]);
    $results = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Election Results</title>
    <link rel="stylesheet" href="style.css">  <!-- Link to your CSS file -->
</head>
<body>

<!-- Admin Header -->
<div class="admin-header">
    <span class="admin-title">Admin Panel</span>
</div>

<div class="container">
    <h2>Admin Panel - Election Results</h2>

    <!-- Links to Add Election, Add Candidate, and View Elections -->
    <a href="admin/add_election.php" class="button">Add Election</a>
    <a href="admin/add_candidate.php" class="button">Add Candidate</a>
    <a href="admin/view_candidates.php" class="button">View Candidates</a>
    <a href="admin/view_elections.php" class="button">View Elections</a>

    <!-- Election Selection Dropdown -->
    <form method="GET" action="admin.php">
        <label for="election">Choose an Election:</label>
        <select name="election_id" id="election" onchange="this.form.submit()">
            <option value="">Select an Election</option>
            <?php foreach ($elections as $election): ?>
                <option value="<?php echo $election['id']; ?>" <?php echo ($election['id'] == $election_id) ? 'selected' : ''; ?>>
                    <?php echo $election['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($election_id): ?>
        <!-- Election Results Table for the selected election -->
        <h3>Results for: 
            <?php echo htmlspecialchars($elections[array_search($election_id, array_column($elections, 'id'))]['name']); ?>
        </h3>

        <?php if (count($results) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['candidate_name']); ?></td>
                            <td><?php echo $result['votes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No candidates or results available for this election.</p>
        <?php endif; ?>
    <?php endif; ?>

</div>

</body>
</html>
