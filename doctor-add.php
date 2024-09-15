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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize user input
    $doctor_name = $conn->real_escape_string($_POST['doctor_name']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $special = $conn->real_escape_string($_POST['special']);
    
    // Prepare the SQL query to insert data into the doctors table
    $sql = "INSERT INTO doctors (name, contact, special, created_at) VALUES (?, ?, ?, NOW())";
    
    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $doctor_name, $contact, $special);
        
        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Doctor added successfully!";
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

// Redirect back to the add-doctor.php page
header("Location: add-doctor.php");
exit();
?>