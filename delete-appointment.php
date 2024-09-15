<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}
include 'db_connection/db_connection.php';

$id = $_GET['id'];

// Delete the appointment from the database
$delete_query = "DELETE FROM appointments WHERE id = $id";
if ($conn->query($delete_query) === TRUE) {
    $_SESSION['status'] = [
        'type' => 'success',
        'title' => 'Deleted!',
        'text' => 'The appointment has been deleted.',
    ];
} else {
    $_SESSION['status'] = [
        'type' => 'error',
        'title' => 'Error!',
        'text' => 'The appointment failed to be deleted.',
    ];
}

// Redirect to the view appointment page
header("Location: view-appointment.php");
$conn->close();
exit();