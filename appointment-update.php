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
    $appointment_id = $_POST['appointment_id'];
    $doctor_name = $_POST['doctor_name'];
    $patient_name = $_POST['patient_name'];
    $date = $_POST['date'];

    // Update the appointment's information in the database
    $update_query = "UPDATE appointments SET doctor_name = ?, patient_name = ?, date = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $doctor_name, $patient_name, $date, $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = [
            'type' => 'success',
            'title' => 'Updated!',
            'text' => 'The appointment has been updated.',
        ];
    } else {
        $_SESSION['status'] = [
            'type' => 'error',
            'title' => 'Error!',
            'text' => 'The appointment failed to be updated.',
        ];
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to the view appointment page
    header("Location: view-appointment.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: view-appointment.php");
    exit();
}