<?php include 'auth_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="ml-64 w-full p-8 lg:p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">Dashboard Overview</h2>
                <p class="text-gray-500">Welcome back, Administrator.</p>
            </div>
            <div class="flex items-center gap-4 relative">
                <div class="text-right mr-2">
                    <p class="font-bold text-sm">Admin User</p>
                    <p class="text-xs text-gray-400">Super Admin</p>
                </div>
                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-xl font-bold text-gray-500">
                    A
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <?php
        require_once '../includes/db.php';
        
        // Fetch Counts
        $sales_res = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status='Completed'");
        $sales_row = $sales_res->fetch_assoc();
        $total_sales = $sales_row['total'] ?? 0;

        $orders_res = $conn->query("SELECT count(*) as count FROM orders");
        $orders_row = $orders_res->fetch_assoc();
        $total_orders = $orders_row['count'];

        $products_res = $conn->query("SELECT count(*) as count FROM products");
        $products_row = $products_res->fetch_assoc();
        $total_products = $products_row['count'];

        $users_res = $conn->query("SELECT count(*) as count FROM users WHERE role='customer'");
        $users_row = $users_res->fetch_assoc();
        $total_users = $users_row['count'];
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Stat Card 1 -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Sales</p>
                    <h3 class="text-3xl font-black">$<?= number_format($total_sales, 2) ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <!-- Stat Card 2 -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Orders</p>
                    <h3 class="text-3xl font-black"><?= $total_orders ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Products</p>
                    <h3 class="text-3xl font-black"><?= $total_products ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            <!-- Stat Card 4 -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Customers</p>
                    <h3 class="text-3xl font-black"><?= $total_users ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Sales Chart -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-6">Sales Analytics</h3>
                <canvas id="salesChart"></canvas>
            </div>
            
            <!-- Category Distribution (Pie Chart) -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-6">Inventory Distribution</h3>
                <div class="h-64 flex justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders Placeholder -->
        <h3 class="text-xl font-bold mb-6">Recent Activity</h3>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
            <i class="fa-regular fa-clipboard text-4xl mb-4 opacity-50"></i>
            <p>No recent orders found.</p>
        </div>

    </main>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sales Chart (Dummy Data for visual matching until real orders exist)
        const ctxSales = document.getElementById('salesChart');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [1200, 1900, 3000, 5000, 2300, 3400],
                    borderColor: 'black',
                    backgroundColor: 'rgba(0,0,0,0.05)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Category Chart (Dynamic from DB)
        <?php
        // Fetch Category Data
        $cat_res = $conn->query("SELECT category, count(*) as count FROM products GROUP BY category");
        $cat_labels = [];
        $cat_data = [];
        while($row = $cat_res->fetch_assoc()) {
            $cat_labels[] = $row['category'];
            $cat_data[] = $row['count'];
        }
        ?>
        const ctxCat = document.getElementById('categoryChart');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($cat_labels) ?>,
                datasets: [{
                    data: <?= json_encode($cat_data) ?>,
                    backgroundColor: [
                        '#111', '#555', '#999', '#ccc', '#eee'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { position: 'bottom' } 
                }
            }
        });
    </script>

</body>
</html>
