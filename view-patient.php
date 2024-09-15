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

// Fetch patients
$patients = [];
$patient_query = "SELECT id, name, age, gender, address, phone FROM patients";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="table-container mx-8 mt-20">
        <table class="min-w-full bg-white border border-gray-200">
            <caption class="py-3 text-white" style="background-color: rgb(24, 89, 168);">
                List of Patients
            </caption>
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Name</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Age</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Gender</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Address</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Phone</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $patient['name']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $patient['age']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $patient['gender']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $patient['address']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $patient['phone']; ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <div class="flex space-x-2">
                            <a href="edit-patient.php?id=<?php echo $patient['id']; ?>" class="text-blue-500">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="text-red-500" onclick="confirmDelete(<?php echo $patient['id']; ?>)">
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
                window.location.href = "delete-patient.php?id=" + id;
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