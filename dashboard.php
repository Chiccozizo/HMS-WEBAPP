<?php
// Start the session
session_start();

// Check if the session variable 'username' is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>HMS-WebApp</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <?php include 'navbar.php'; ?>

    <!-- Dashboard Links -->
    <div class="container mx-auto py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Doctor Box -->
            <div class="m-4">
                <!-- Added margin here -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <a href="view-doctor.php">
                        <img src="images/doc.png" class="h-24 w-24 mx-auto mb-4" alt="Doctor">
                        <h2 class="text-xl font-semibold">Doctor</h2>
                    </a>
                </div>
            </div>

            <!-- Patient Box -->
            <div class="m-4">
                <!-- Added margin here -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <a href="view-patient.php">
                        <img src="images/patient.png" class="h-24 w-24 mx-auto mb-4" alt="Patient">
                        <h2 class="text-xl font-semibold">Patient</h2>
                    </a>
                </div>
            </div>

            <!-- Appointment Box -->
            <div class="m-4">
                <!-- Added margin here -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <a href="view-appointment.php">
                        <img src="images/appointment.jpeg" class="h-24 w-24 mx-auto mb-4" alt="Appointment">
                        <h2 class="text-xl font-semibold">Appointment</h2>
                    </a>
                </div>
            </div>

        </div>
    </div>


</body>

</html>