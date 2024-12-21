<?php
session_start();
include 'db.php';  // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the data from the form
$election_id = $_POST['election_id'];
$candidate_id = $_POST['candidate_id'];

// Insert the vote (you can handle voting logic here or update the candidate's vote count)
$stmt = $pdo->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = :candidate_id");
$stmt->bindParam(':candidate_id', $candidate_id);
$stmt->execute();

// Redirect to the dashboard or a success page
header('Location: dashboard.php');
exit;
