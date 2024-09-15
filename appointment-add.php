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

$success = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize user input
    $doctor_id = $conn->real_escape_string($_POST['doctor_id']);
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    
    // Prepare the SQL query to insert data into the appointments table
    $sql = "INSERT INTO appointments (doctor_name, patient_name, date) VALUES (?, ?, ?)";
    
    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $doctor_id, $patient_id, $appointment_date);
        
        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = true; // Set success in session
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();

// Redirect back to the form page
header("Location: add-appointment.php");
exit();