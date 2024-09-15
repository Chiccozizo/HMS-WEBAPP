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
    $name = $conn->real_escape_string($_POST['name']);
    $age = $conn->real_escape_string($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone = $conn->real_escape_string($_POST['phone']);

    // Prepare the SQL query to insert data into the patients table
    $sql = "INSERT INTO patients (name, age, gender, address, phone, created_at) VALUES (?, ?, ?, ?, ?, NOW())";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssss", $name, $age, $gender, $address, $phone);

        // Execute the statement
        if ($stmt->execute()) {
            // Set session variable to indicate success
            $_SESSION['success_message'] = 'Patient added successfully!';
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();

// Redirect back to the form page
header("Location: add-patient.php");
exit();
?>