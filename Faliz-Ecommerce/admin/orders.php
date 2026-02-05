<?php
include 'auth_session.php';
require_once '../includes/db.php';

// Handle Status Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: orders.php?msg=Order status updated");
    exit();
}

// Fetch Orders
$sql = "SELECT orders.*, users.username as customer_name, users.email 
        FROM orders 
        LEFT JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management | Admin</title>
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
                <h2 class="text-3xl font-bold mb-2">Order Management</h2>
                <p class="text-gray-500">Track and manage customer orders.</p>
            </div>
            
            <?php if(isset($_GET['msg'])): ?>
            <div class="bg-green-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg animate-in fade-in flex items-center gap-2">
                <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($_GET['msg']) ?>
            </div>
            <?php endif; ?>
        </header>

        <!-- Orders Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-widest border-b border-gray-100">
                        <th class="p-6">Order ID</th>
                        <th class="p-6">Customer</th>
                        <th class="p-6">Date</th>
                        <th class="p-6">Total</th>
                        <th class="p-6">Status</th>
                        <th class="p-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-6 font-bold text-black">#<?= str_pad($row['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td class="p-6">
                                <p class="font-bold text-sm"><?= $row['customer_name'] ?></p>
                                <p class="text-xs text-gray-400"><?= $row['email'] ?></p>
                            </td>
                            <td class="p-6 text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($row['created_at'])) ?>
                                <br><span class="text-xs"><?= date('h:i A', strtotime($row['created_at'])) ?></span>
                            </td>
                            <td class="p-6 font-bold text-black">$<?= number_format($row['total_amount'], 2) ?></td>
                            <td class="p-6">
                                <?php 
                                    $statusColor = 'bg-gray-100 text-gray-500';
                                    if($row['status'] == 'Completed') $statusColor = 'bg-green-100 text-green-600';
                                    if($row['status'] == 'Pending') $statusColor = 'bg-yellow-100 text-yellow-600';
                                    if($row['status'] == 'Shipped') $statusColor = 'bg-blue-100 text-blue-600';
                                ?>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?= $statusColor ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <form method="POST" class="inline-block relative group">
                                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="appearance-none bg-gray-50 hover:bg-gray-200 cursor-pointer rounded-lg text-xs font-bold py-2 px-3 pr-8 focus:outline-none focus:ring-2 focus:ring-black transition">
                                        <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Shipped" <?= $row['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                        <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="Cancelled" <?= $row['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-500 pointer-events-none"></i>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400 italic">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
