<?php
include '../db.php';  // Correct path to db.php

if (isset($_GET['id'])) {
    $election_id = $_GET['id'];

    // Delete election from the database
    $stmt = $pdo->prepare("DELETE FROM elections WHERE id = ?");
    $stmt->execute([$election_id]);

    $_SESSION['message'] = "Election deleted successfully!";
    header('Location: view_elections.php');
    exit;
} else {
    echo "Election ID is missing.";
}
?>
