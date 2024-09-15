<?php
// Start the session
session_start();

// Check if the session variable 'username' is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}

// Check for success or error messages
$successMessage = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the session messages
unset($_SESSION['success']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>HMS-WepApp</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

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

    .form-background {
        background-color: rgb(24, 89, 168);
    }
    </style>
</head>

<body class="bg-gray-100">

    <?php include 'navbar.php'; ?>

    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="form-background p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-white text-2xl font-bold mb-4">Add Doctor</h1>
            <form method="post" action="doctor-add.php">
                <label class="block text-white mb-2">Doctor name</label>
                <input type="text" placeholder="Doctor name" required name="doctor_name"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <label class="block text-white mb-2">Contact</label>
                <input type="text" placeholder="Contact number" required name="contact"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <label class="block text-white mb-2">Specialisation</label>
                <input type="text" placeholder="Specialisation" required name="special"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <input id="submit" type="submit" value="Save" class="w-full">
            </form>
        </div>
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