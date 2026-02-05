<?php
session_start();

// Database Connection
require_once '../includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // In a real production app, use password_verify($password, $row['password'])
        // For this demo with the seeded 'admin123' (plaintext), we check directly.
        // IF you update to hashed passwords later, switch to password_verify.
        if ($password === $row['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Access Denied. Admin account not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black tracking-tighter mb-2">faliz.</h1>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Admin Portal</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-50 text-red-500 text-sm font-bold p-4 rounded-xl mb-6 text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Email Address</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition font-medium">
            </div>
            
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition font-medium">
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition transform hover:-translate-y-1 shadow-lg">
                Access Dashboard
            </button>
        </form>

        <p class="text-center mt-8 text-xs text-gray-400">
            &copy; 2026 Faliz Enterprise. Internal Use Only.
        </p>
    </div>

</body>
</html>
