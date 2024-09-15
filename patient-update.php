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
    $patient_id = $_POST['patient_id'];
    $patient_name = $_POST['patient_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Update the patient's information in the database
    $update_query = "UPDATE patients SET name = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $patient_name, $contact, $address, $patient_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = [
            'type' => 'success',
            'title' => 'Updated!',
            'text' => 'The patient has been updated.',
        ];
    } else {
        $_SESSION['status'] = [
            'type' => 'error',
            'title' => 'Error!',
            'text' => 'The patient failed to be updated.',
        ];
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to the view patient page
    header("Location: view-patient.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: view-patient.php");
    exit();
}