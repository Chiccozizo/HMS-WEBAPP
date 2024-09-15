<?php
// Include the database connection file
include 'db_connection/db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize user input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to select user with the given username and password
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    
    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the user exists
        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redirect to a protected page
        } else {
            header("Location: index.php?error=1"); // Redirect to index page with an error parameter
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>