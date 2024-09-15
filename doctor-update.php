<?php
// Start the session
session_start();

if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}
// Include the database connection file
include 'db_connection/db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $doctor_name = $_POST['doctor_name'];
    $contact = $_POST['contact'];
    $special = $_POST['special'];

    // Update the doctor's information in the database
    $update_query = "UPDATE doctors SET name = ?, contact = ?, special = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $doctor_name, $contact, $special, $doctor_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = [
            'type' => 'success',
            'title' => 'Updated!',
            'text' => 'The doctor has been Updated.',
        ];
    } else {
        $_SESSION['status'] = [
            'type' => 'Failed',
            'title' => 'Error!',
            'text' => 'The doctor failed to be updated.',
        ];
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to the view doctor page
    header("Location: view-doctor.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: view-doctor.php");
    exit();
}