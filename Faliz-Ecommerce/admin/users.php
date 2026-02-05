<?php
include 'auth_session.php';
require_once '../includes/db.php';

// Handle Add User Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_user') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    // Check if email exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        header("Location: users.php?error=Email already registered");
        exit();
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        if ($conn->query($sql) === TRUE) {
            header("Location: users.php?msg=User created successfully");
            exit();
        } else {
            header("Location: users.php?error=" . urlencode($conn->error));
            exit();
        }
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: users.php?msg=User deleted successfully");
    exit();
}

// Fetch Users
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="ml-64 w-full p-8 lg:p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">User Management</h2>
                <p class="text-gray-500">Manage customer accounts and permissions.</p>
            </div>
            <button onclick="toggleModal('addUserModal')" class="bg-black text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg text-sm flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Add New User
            </button>
        </header>

        <?php if(isset($_GET['error'])): ?>
        <div class="mb-8 bg-red-50 text-red-500 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($_GET['error']) ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['msg'])): ?>
        <div class="mb-8 bg-green-50 text-green-600 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($_GET['msg']) ?>
        </div>
        <?php endif; ?>

        <!-- Users Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-widest border-b border-gray-100">
                        <th class="p-6">User</th>
                        <th class="p-6">Role</th>
                        <th class="p-6">Joined</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-400 uppercase">
                                    <?= substr($row['username'], 0, 1) ?>
                                </div>
                                <div>
                                    <p class="font-bold text-black"><?= $row['username'] ?></p>
                                    <p class="text-xs text-gray-400"><?= $row['email'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <?php if($row['role'] == 'admin'): ?>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-black text-white">Admin</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500">Customer</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-6 text-sm font-medium text-gray-500">
                            <?= date('M d, Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="user-edit.php?id=<?= $row['id'] ?>" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-black hover:text-white flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <?php if($row['role'] != 'admin'): // Prevent deleting self/admin ?>
                                <a href="users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- ADD USER MODAL -->
    <div id="addUserModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 opacity-0 visibility-hidden transition-all duration-300" style="visibility: hidden;">
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100 transform scale-95 transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Add New User</h2>
                <button onclick="toggleModal('addUserModal')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-times text-gray-500"></i>
                </button>
            </div>
            
            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="add_user">
                
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Username / Full Name</label>
                    <input type="text" name="username" required placeholder="e.g. John Doe" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Email Address</label>
                    <input type="email" name="email" required placeholder="e.g. john@example.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Role</label>
                    <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition appearance-none cursor-pointer">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="pt-2 flex gap-4">
                    <button type="submit" class="flex-1 bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">Create User</button>
                    <button type="button" onclick="toggleModal('addUserModal')" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-xl font-bold hover:bg-gray-200 transition text-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.style.visibility === 'hidden') {
                modal.style.visibility = 'visible';
                modal.classList.remove('opacity-0', 'visibility-hidden');
                modal.querySelector('div').classList.remove('scale-95');
                modal.querySelector('div').classList.add('scale-100');
            } else {
                modal.style.visibility = 'hidden';
                modal.classList.add('opacity-0', 'visibility-hidden');
                modal.querySelector('div').classList.remove('scale-100');
                modal.querySelector('div').classList.add('scale-95');
            }
        }
    </script>
</body>
</html>
