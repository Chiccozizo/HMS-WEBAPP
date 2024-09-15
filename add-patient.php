<?php
// Start the session
session_start();

if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}
?>

<!DOCTYPE html>
<html>

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

<body>

    <?php include 'navbar.php'; ?>

    <div class="flex justify-center items-center min-h-screen bg-gray-100 pt-16">
        <!-- Added pt-16 for top padding -->
        <div class="form-background p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-white text-2xl font-bold mb-4">Add Patient</h1>

            <form method="post" action="patient-add.php">
                <label class="block text-white mb-2">Patient name</label>
                <input type="text" placeholder="patient name" required name="name"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <label class="block text-white mb-2">Age</label>
                <input type="number" placeholder="Age" required name="age"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <label class="block text-white mb-2">Gender</label>
                <select required name="gender" class="w-full p-2 mb-4 rounded border border-gray-300">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <label class="block text-white mb-2">Address</label>
                <input type="text" placeholder="physical address" required name="address"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <label class="block text-white mb-2">Phone number</label>
                <input type="text" placeholder="phone number" required name="phone"
                    class="w-full p-2 mb-4 rounded border border-gray-300">

                <input id="submit" type="submit" value="Submit" class="w-full mt-4">
            </form>
        </div>
    </div>

    <?php
    // Display success or error message if available
    if (isset($_SESSION['success_message'])) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: '" . $_SESSION['success_message'] . "',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
        unset($_SESSION['success_message']); // Clear message after displaying
    }

    if (isset($_SESSION['error_message'])) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: '" . $_SESSION['error_message'] . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
        unset($_SESSION['error_message']); // Clear message after displaying
    }
    ?>
</body>

</html>