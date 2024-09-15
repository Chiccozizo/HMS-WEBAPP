<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}
include 'db_connection/db_connection.php';

$id = $_GET['id'];

// Delete the doctor from the database
$delete_query = "DELETE FROM doctors WHERE id = $id";
if ($conn->query($delete_query) === TRUE) {
    $_SESSION['status'] = [
        'type' => 'success',
        'title' => 'Deleted!',
        'text' => 'The doctor has been deleted.',
    ];
} else {
    $_SESSION['status'] = [
        'type' => 'error',
        'title' => 'Error!',
        'text' => 'There was an error deleting the doctor.',
    ];
}

$conn->close();
header('Location: view-doctor.php');
exit;
?>