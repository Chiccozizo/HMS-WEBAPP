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

// Fetch appointments
$appointments = [];
$appointment_query = "SELECT id, doctor_name, patient_name, date FROM appointments";
$result = $conn->query($appointment_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS-WebApp - View Appointments</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="table-container mx-8 mt-20">
        <table class="min-w-full bg-white border border-gray-200">
            <caption class="py-3 text-white" style="background-color: rgb(24, 89, 168);">
                List of Appointments
            </caption>
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Doctor Name</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Patient Name</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Date</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $appointment['doctor_name']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $appointment['patient_name']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <?php echo date('Y-m-d H:i', strtotime($appointment['date'])); ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <div class="flex space-x-2">
                            <a href="edit-appointment.php?id=<?php echo $appointment['id']; ?>" class="text-blue-500">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="text-red-500" onclick="confirmDelete(<?php echo $appointment['id']; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete-appointment.php?id=" + id;
            }
        })
    }

    <?php if (isset($_SESSION['status'])): ?>
    Swal.fire({
        icon: '<?php echo $_SESSION['status']['type']; ?>',
        title: '<?php echo $_SESSION['status']['title']; ?>',
        text: '<?php echo $_SESSION['status']['text']; ?>',
    });
    <?php unset($_SESSION['status']); ?>
    <?php endif; ?>
    </script>

</body>

</html>