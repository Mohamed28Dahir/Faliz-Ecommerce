<?php
include 'auth_session.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: users.php"); exit(); }

// Update Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $_POST['role'];
    
    // Check if password field is filled
    $password_sql = "";
    if (!empty($_POST['password'])) {
        // Plaintext for demo as established, or password_hash() if we upgraded
        $password = $_POST['password']; 
        $password_sql = ", password='$password'";
    }

    $sql = "UPDATE users SET username='$username', email='$email', role='$role' $password_sql WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: users.php?msg=User updated successfully");
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}

// Fetch User
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-lg border border-gray-100">
        <h2 class="text-2xl font-bold mb-6">Edit User</h2>
        
        <form method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Username</label>
                    <input type="text" name="username" value="<?= $user['username'] ?>" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Email Address</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Role</label>
                    <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                        <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="flex-1 bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">Save Changes</button>
                <a href="users.php" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-xl font-bold hover:bg-gray-200 transition text-center">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
