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

    /* Custom background color class */
    .bg-custom-blue {
        background-color: rgb(24, 89, 168);
    }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <?php if (isset($_GET['error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: 'Invalid username or password.',
        timer: 3000, // Auto close after 3 seconds
        showConfirmButton: false
    });
    </script>
    <?php endif; ?>

    <div class="w-full max-w-md p-8 bg-custom-blue text-white shadow-lg rounded-lg">
        <div class="text-center mb-6">
            <img src="1.png" alt="Logo" class="mx-auto mb-4 w-24 h-24">
            <h1 class="text-2xl font-semibold">Admin Login</h1>
        </div>

        <form method="post" action="login.php" class="space-y-4">
            <div class="flex flex-col">
                <label for="username" class="font-medium">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required
                    class="p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 text-black">
            </div>

            <div class="flex flex-col">
                <label for="password" class="font-medium">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 text-black">
            </div>

            <button id="submit" type="submit"
                class="w-full py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Login</button>
        </form>
    </div>

    <section class="background">
        &nbsp;
    </section>
</body>

</html>