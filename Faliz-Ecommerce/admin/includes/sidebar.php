<?php
// Get current page filename to highlight active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-black text-white min-h-screen fixed left-0 top-0 z-50">
    <div class="p-8">
        <h1 class="text-3xl font-black tracking-tighter">faliz.</h1>
        <p class="text-[10px] uppercase font-bold text-gray-400 mt-1 tracking-widest">Admin Panel</p>
    </div>

    <nav class="px-4 space-y-2 mt-8">
        <!-- Dashboard -->
        <a href="index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium <?= $current_page == 'index.php' ? 'bg-gray-900 text-white shadow-inner' : 'text-gray-400 hover:text-white hover:bg-gray-800' ?>">
            <i class="fa-solid fa-chart-pie w-6"></i>
            Dashboard
        </a>

        <!-- Products -->
        <a href="products.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium <?= $current_page == 'products.php' || $current_page == 'product-edit.php' ? 'bg-gray-900 text-white shadow-inner' : 'text-gray-400 hover:text-white hover:bg-gray-800' ?>">
            <i class="fa-solid fa-box w-6"></i>
            Products
        </a>

        <!-- Orders -->
        <a href="orders.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium <?= $current_page == 'orders.php' ? 'bg-gray-900 text-white shadow-inner' : 'text-gray-400 hover:text-white hover:bg-gray-800' ?>">
            <i class="fa-solid fa-cart-shopping w-6"></i>
            Orders
        </a>

        <!-- Customers -->
        <a href="users.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium <?= $current_page == 'users.php' || $current_page == 'user-edit.php' ? 'bg-gray-900 text-white shadow-inner' : 'text-gray-400 hover:text-white hover:bg-gray-800' ?>">
            <i class="fa-solid fa-users w-6"></i>
            Customers
        </a>
    </nav>

    <div class="absolute bottom-8 left-0 right-0 px-4">
        <a href="../logout.php" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-gray-900 rounded-xl transition font-bold text-sm">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Logout
        </a>
    </div>
</aside>
