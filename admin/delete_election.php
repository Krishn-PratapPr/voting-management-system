<?php
session_start();
include '../db.php';  // Include your database connection
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: adminlogin.php');
    exit;
}

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
