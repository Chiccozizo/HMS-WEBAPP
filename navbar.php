<?php 
if (!isset($_SESSION['username'])) {
    // If not set, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further script execution after redirection
}

?>
<style>
.navbar-fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    /* Ensure it stays above other content */
}

body {
    margin: 0;
    padding-top: 60px;
    /* Adjust this to the height of your navbar */
}
</style>

<div class="menu_bar navbar-fixed">
    <div class="logo-image">
        <img src="1.png" alt="Logo">
    </div>
    <ul class="menu-list">
        <li><a href="dashboard.php">Home</a></li>
        <li>
            <a href="add-doctor.php">Doctor <i class="fas fa-caret-down"></i></a>
            <div class="dropdown_menu">
                <ul>
                    <li><a href="add-doctor.php">Add doctor</a></li>
                    <li><a href="view-doctor.php">View doctors</a></li>
                </ul>
            </div>
        </li>
        <li>
            <a href="add-patient.php">Patient <i class="fas fa-caret-down"></i></a>
            <div class="dropdown_menu">
                <ul>
                    <li><a href="add-patient.php">Add patient</a></li>
                    <li><a href="view-patient.php">View patients</a></li>
                </ul>
            </div>
        </li>
        <li>
            <a href="add-appointment.php">Appointment <i class="fas fa-caret-down"></i></a>
            <div class="dropdown_menu">
                <ul>
                    <li><a href="add-appointment.php">Add appointment</a></li>
                    <li><a href="view-appointment.php">View appointments</a></li>
                </ul>
            </div>
        </li>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>
</div>


<script>
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out of your account.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php'; // Replace with your logout script
        }
    });
}
</script>