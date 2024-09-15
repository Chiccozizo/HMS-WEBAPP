<?php 
// Database connection details
$servername = "localhost";  // or your server name
$username = "root";         // your database username
$password = "";             // your database password
$database = "HMS"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>