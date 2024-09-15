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

// Fetch doctors
$doctors = [];
$doctor_query = "SELECT id, name FROM doctors";
$result = $conn->query($doctor_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Fetch patients
$patients = [];
$patient_query = "SELECT id, name FROM patients";
$result = $conn->query($patient_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>HMS-WepApp</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
    .form-background {
        background-color: rgb(24, 89, 168);
    }

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

    <div class="flex justify-center items-center min-h-screen bg-gray-100 pt-16">
        <div class="form-background p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-white text-2xl font-bold mb-4">Add Appointment</h1>

            <form method="post" action="appointment-add.php">
                <label class="block text-white mb-2 font-semibold">Doctor Name</label>
                <select name="doctor_id" required class="w-full p-2 mb-4 rounded border border-gray-300 bg-white">
                    <option value="" disabled selected>Select a Doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo $doctor['name']; ?>">
                        <?php echo $doctor['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <label class="block text-white mb-2 font-semibold">Patient Name</label>
                <select name="patient_id" required class="w-full p-2 mb-4 rounded border border-gray-300 bg-white">
                    <option value="" disabled selected>Select a Patient</option>
                    <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo $patient['name']; ?>">
                        <?php echo $patient['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <label class="block text-white mb-2 font-semibold">Date</label>
                <input type="datetime-local" name="appointment_date" required
                    class="w-full p-2 mb-4 rounded border border-gray-300 bg-white">

                <input id="submit" type="submit" value="Submit"
                    class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">
            </form>
        </div>
    </div>

    <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
    <script>
    Swal.fire({
        title: 'Success!',
        text: 'Appointment added successfully!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'add-appointment.php'; // Refresh the page
    });
    </script>
    <?php unset($_SESSION['success']); // Clear the success message ?>
    <?php elseif (isset($_SESSION['error'])): ?>
    <script>
    Swal.fire({
        title: 'Error!',
        text: '<?php echo $_SESSION['error']; ?>',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    </script>
    <?php unset($_SESSION['error']); // Clear the error message ?>
    <?php endif; ?>

</body>

</html>