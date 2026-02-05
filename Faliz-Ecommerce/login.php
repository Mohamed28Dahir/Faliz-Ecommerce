<?php
session_start();
require_once 'includes/db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    // --- LOGIN LOGIC ---
    if ($action === 'login') {
        $email = $conn->real_escape_string($_POST['login_email']);
        $password = $_POST['login_password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Check password (plaintext for existing admin, seeded logic)
            // Ideally use password_verify() for new users if hashed
            if ($password === $row['password']) {
                if ($row['role'] === 'admin') {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $row['email'];
                    $_SESSION['admin_username'] = $row['username'];
                    header("Location: admin/index.php"); // Redirect Admins
                    exit();
                } else {
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: index.php"); // Redirect Customers
                    exit();
                }
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Account not found with this email.";
        }
    }

    // --- REGISTER LOGIC ---
    elseif ($action === 'register') {
        $name = $conn->real_escape_string($_POST['reg_name']);
        $email = $conn->real_escape_string($_POST['reg_email']);
        $password = $conn->real_escape_string($_POST['reg_password']); // Plaintext for consistent demo

        // Check if email exists
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $error = "Email already registered. Please login.";
        } else {
            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$name', '$email', '$password', 'customer')";
            if ($conn->query($sql) === TRUE) {
                $success = "Account created! You can now login.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow: hidden; }
        .login-image {
            background-image: url('assets/img/login-bg.png');
            background-size: cover;
            background-position: center;
        }
        
        /* Smooth Toggle Logic (No-JS) */
        .auth-content { display: none; }
        #tab-login:checked ~ .auth-container .login-content { display: block; }
        #tab-register:checked ~ .auth-container .register-content { display: block; }

        /* Tab Activation Styling */
        #tab-login:checked ~ .auth-container .tab-link-login { color: black; border-bottom-color: black; }
        #tab-register:checked ~ .auth-container .tab-link-register { color: black; border-bottom-color: black; }

        @media (max-width: 1024px) {
            body { overflow: auto; }
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

<main class="min-h-screen flex flex-col lg:flex-row relative">
    <!-- Hidden Radio Controls -->
    <input type="radio" name="auth-tab" id="tab-login" class="hidden" checked>
    <input type="radio" name="auth-tab" id="tab-register" class="hidden">

    <!-- Left: Immersive Visual Area -->
    <div class="hidden lg:block lg:w-3/5 login-image relative">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute bottom-20 left-20 text-white max-w-lg">
            <a href="index.php" class="text-4xl font-black tracking-tighter mb-12 inline-block">faliz.</a>
            <h1 class="text-6xl font-black leading-tight mb-6 tracking-tighter">Elevate Your Lifestyle.</h1>
            <p class="text-xl font-light opacity-90 leading-relaxed">Join our community of fashion enthusiasts and discover the art of modern elegance.</p>
        </div>
    </div>

    <!-- Right: Minimalist Auth Area -->
    <div class="w-full lg:w-2/5 flex flex-col justify-center px-8 lg:px-20 py-12 relative bg-white auth-container">
        <!-- Mobile Logo -->
        <div class="lg:hidden mb-8">
            <a href="index.php" class="text-3xl font-black tracking-tighter">faliz.</a>
        </div>

        <div class="max-w-md w-full mx-auto">
            <!-- Navigation Toggles -->
            <div class="flex space-x-10 mb-12 border-b-2 border-gray-50">
                <label for="tab-login" class="tab-link-login cursor-pointer pb-4 text-sm font-black uppercase tracking-[0.2em] text-gray-300 transition-all border-b-2 border-transparent">Login</label>
                <label for="tab-register" class="tab-link-register cursor-pointer pb-4 text-sm font-black uppercase tracking-[0.2em] text-gray-300 transition-all border-b-2 border-transparent">Register</label>
            </div>

            <!-- Forms Layer -->
            <?php if($error): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-500 text-sm font-bold text-center">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-600 text-sm font-bold text-center">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST" class="space-y-8">
                
                <!-- LOGIN CONTENT -->
                <div class="auth-content login-content animate-in fade-in duration-500">
                    <div class="mb-10">
                        <h2 class="text-4xl font-black tracking-tighter mb-4">Welcome back.</h2>
                        <p class="text-gray-400 font-medium">Please enter your credentials to access your account.</p>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="text-[11px] uppercase font-black tracking-[0.2em] text-gray-400 block mb-3">Email Address</label>
                            <input type="email" name="login_email" placeholder="name@domain.com" 
                                   class="w-full border-b-2 border-gray-100 py-4 focus:outline-none focus:border-black transition-colors bg-transparent text-lg font-medium placeholder:text-gray-200">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-[11px] uppercase font-black tracking-[0.2em] text-gray-400 block">Password</label>
                                <a href="#" class="text-[11px] uppercase font-black tracking-widest text-gray-300 hover:text-black transition-colors">Forgot?</a>
                            </div>
                            <input type="password" name="login_password" placeholder="••••••••" 
                                   class="w-full border-b-2 border-gray-100 py-4 focus:outline-none focus:border-black transition-colors bg-transparent text-lg font-medium placeholder:text-gray-200">
                        </div>
                        <div class="pt-4">
                            <button type="submit" name="action" value="login" class="w-full bg-black text-white py-6 rounded-full font-black text-lg hover:bg-gray-800 transition-all transform hover:-translate-y-1 shadow-2xl tracking-tight">
                                Log In to Account
                            </button>
                        </div>
                    </div>
                </div>

                <!-- REGISTER CONTENT -->
                <div class="auth-content register-content animate-in fade-in duration-500">
                    <div class="mb-10">
                        <h2 class="text-4xl font-black tracking-tighter mb-4">Create Account.</h2>
                        <p class="text-gray-400 font-medium">Be part of the exclusive fashion community.</p>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="text-[11px] uppercase font-black tracking-[0.2em] text-gray-400 block mb-3">Full Name</label>
                            <input type="text" name="reg_name" placeholder="John Doe" 
                                   class="w-full border-b-2 border-gray-100 py-4 focus:outline-none focus:border-black transition-colors bg-transparent text-lg font-medium placeholder:text-gray-200">
                        </div>
                        <div>
                            <label class="text-[11px] uppercase font-black tracking-[0.2em] text-gray-400 block mb-3">Email Address</label>
                            <input type="email" name="reg_email" placeholder="name@domain.com" 
                                   class="w-full border-b-2 border-gray-100 py-4 focus:outline-none focus:border-black transition-colors bg-transparent text-lg font-medium placeholder:text-gray-200">
                        </div>
                        <div>
                            <label class="text-[11px] uppercase font-black tracking-[0.2em] text-gray-400 block mb-3">Create Password</label>
                            <input type="password" name="reg_password" placeholder="••••••••" 
                                   class="w-full border-b-2 border-gray-100 py-4 focus:outline-none focus:border-black transition-colors bg-transparent text-lg font-medium placeholder:text-gray-200">
                        </div>
                        <div class="pt-4">
                            <button type="submit" name="action" value="register" class="w-full bg-black text-white py-6 rounded-full font-black text-lg hover:bg-gray-800 transition-all transform hover:-translate-y-1 shadow-2xl tracking-tight">
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- Utility Footer -->
        <div class="lg:absolute lg:bottom-10 lg:left-20 lg:right-20 mt-20 flex flex-col md:flex-row justify-between items-center text-[10px] font-black uppercase tracking-widest text-gray-300 gap-4">
            <p>&copy; 2026 Faliz Enterprise</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-black transition-colors">Privacy</a>
                <a href="#" class="hover:text-black transition-colors">Terms</a>
                <a href="#" class="hover:text-black transition-colors">Help</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>
