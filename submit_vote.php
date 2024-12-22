<?php
session_start();
include 'db.php';  // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Get the data from the form
$election_id = $_POST['election_id'];
$candidate_id = $_POST['candidate_id'];

// Check if the user has already voted in this election
$stmt = $pdo->prepare("SELECT * FROM votes WHERE user_id = :user_id AND election_id = :election_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':election_id', $election_id);
$stmt->execute();
$existing_vote = $stmt->fetch();

if ($existing_vote) {
    // If the user has already voted, redirect back to the election page with a message
    header("Location: vote_for_election.php?election_id=" . $election_id . "&message=You have already voted.");
    exit;
}

// Insert the vote into the 'votes' table
$stmt = $pdo->prepare("INSERT INTO votes (user_id, election_id, candidate_id) VALUES (:user_id, :election_id, :candidate_id)");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':election_id', $election_id);
$stmt->bindParam(':candidate_id', $candidate_id);
$stmt->execute();

// Update the candidate's vote count
$stmt = $pdo->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = :candidate_id");
$stmt->bindParam(':candidate_id', $candidate_id);
$stmt->execute();

// Redirect to the election page or dashboard with a success message
header("Location: vote_for_election.php?election_id=" . $election_id . "&message=Your vote has been submitted.");
exit;
