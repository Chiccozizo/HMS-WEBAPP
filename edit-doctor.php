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

// Check if the doctor ID is provided in the URL
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No doctor ID provided.";
    header("Location: view-doctor.php");
    exit();
}

$doctor_id = $_GET['id'];

// Fetch the doctor's current data from the database
$doctor_query = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($doctor_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Doctor not found.";
    header("Location: view-doctor.php");
    exit();
}

$doctor = $result->fetch_assoc();

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
    <title>Edit Doctor</title>
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
        <h1>Edit Doctor</h1>
        <form method="post" action="doctor-update.php">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">

            <label>Doctor name</label>
            <input type="text" placeholder="Doctor name" required name="doctor_name"
                value="<?php echo $doctor['name']; ?>">

            <label>Contact</label>
            <input type="text" placeholder="Contact number" required name="contact"
                value="<?php echo $doctor['contact']; ?>">

            <label>Specialisation</label>
            <input type="text" placeholder="Specialisation" required name="special"
                value="<?php echo $doctor['special']; ?>">

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