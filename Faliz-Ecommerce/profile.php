<?php
session_start();
require_once 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'];
$user_email = $_SESSION['user_email'];

// Fetch User Orders
$orders = [];
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16 min-h-[60vh]">
    <div class="container mx-auto px-4 lg:px-6">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter mb-2">My Account.</h1>
                <p class="text-gray-500">Welcome back, <span class="font-bold text-black"><?= htmlspecialchars($user_name) ?></span></p>
            </div>
            <a href="logout.php" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold text-sm transition text-gray-600">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Account Details -->
            <div class="bg-gray-50 rounded-3xl p-8 h-fit">
                <h3 class="text-xl font-bold mb-6">Profile Details</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-1">Full Name</p>
                        <p class="font-medium"><?= htmlspecialchars($user_name) ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-1">Email Address</p>
                        <p class="font-medium"><?= htmlspecialchars($user_email) ?></p>
                    </div>
                    <div class="pt-4">
                        <button class="text-sm font-bold border-b border-black pb-0.5 hover:opacity-70">Edit Information</button>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="lg:col-span-2">
                <h3 class="text-xl font-bold mb-6">Order History</h3>
                
                <?php if(empty($orders)): ?>
                    <div class="border-2 border-dashed border-gray-100 rounded-3xl p-12 text-center">
                        <i class="fa-solid fa-bag-shopping text-4xl text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-medium mb-6">You haven't placed any orders yet.</p>
                        <a href="shop.php" class="bg-black text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-800 transition inline-block">Start Shopping</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach($orders as $order): ?>
                        <div class="border border-gray-100 rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center hover:shadow-lg transition gap-4">
                            <div class="flex items-center gap-6 w-full sm:w-auto">
                                <div class="w-12 h-12 rounded-full bg-black/5 flex items-center justify-center text-lg">
                                    📦
                                </div>
                                <div>
                                    <p class="font-bold text-lg">Order #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></p>
                                    <p class="text-xs text-gray-400 font-medium"><?= date('F j, Y', strtotime($order['created_at'])) ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-8 w-full sm:w-auto justify-between sm:justify-end">
                                <span class="font-black text-lg font-Outfit">$<?= number_format($order['total_amount'], 2) ?></span>
                                
                                <?php 
                                    $statusColor = 'bg-gray-100 text-gray-500';
                                    if($order['status'] == 'Completed') $statusColor = 'bg-green-100 text-green-600';
                                    if($order['status'] == 'Pending') $statusColor = 'bg-yellow-100 text-yellow-600';
                                    if($order['status'] == 'Shipped') $statusColor = 'bg-blue-100 text-blue-600';
                                ?>
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest <?= $statusColor ?>">
                                    <?= $order['status'] ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
