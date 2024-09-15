<?php
// Start the session
session_start();

// Check if the session variable 'username' is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}

// Include the database connection file
include 'db_connection/db_connection.php';

// Check if the patient ID is provided in the URL
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No patient ID provided.";
    header("Location: view-patient.php");
    exit();
}

$patient_id = $_GET['id'];

// Fetch the patient's current data from the database
$patient_query = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($patient_query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Patient not found.";
    header("Location: view-patient.php");
    exit();
}

$patient = $result->fetch_assoc();

// Check for success or error messages
$successMessage = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the session messages
unset($_SESSION['success']);
unset($_SESSION['error']);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Patient</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    #submit {
        background-color: rgba(91, 149, 15, 1);
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    #submit:hover {
        background-color: rgba(91, 149, 15, 0.8);
    }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="add-box">
        <h1>Edit Patient</h1>
        <form method="post" action="patient-update.php">
            <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">

            <label>Patient Name</label>
            <input type="text" placeholder="Patient name" required name="patient_name"
                value="<?php echo $patient['name']; ?>">

            <label>Contact</label>
            <input type="text" placeholder="Contact number" required name="contact"
                value="<?php echo $patient['phone']; ?>">

            <label>Address</label>
            <input type="text" placeholder="Address" required name="address" value="<?php echo $patient['address']; ?>">

            <br><br>

            <input id="submit" type="submit" value="Update">
        </form>
    </div>

    <!-- Display SweetAlert based on the session variable -->
    <?php if ($successMessage): ?>
    <script>
    Swal.fire({
        title: 'Success!',
        text: '<?php echo $successMessage; ?>',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    </script>
    <?php elseif ($errorMessage): ?>
    <script>
    Swal.fire({
        title: 'Error!',
        text: '<?php echo $errorMessage; ?>',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    </script>
    <?php endif; ?>

</body>

</html>