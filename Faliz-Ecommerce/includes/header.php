<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-white border-b border-gray-100 py-6 sticky top-0 z-50">
    <div class="container mx-auto px-4 lg:px-6">
        <nav class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="index.php" class="text-3xl font-black tracking-tighter text-black">faliz.</a>
            </div>
            
            <!-- Navigation -->
            <ul class="hidden md:flex items-center space-x-10 text-[15px] font-medium text-black">
                <li><a href="index.php" class="hover:text-gray-600">Home</a></li>
                <li><a href="shop.php" class="hover:text-gray-600">Shop</a></li>
                <li><a href="about.php" class="hover:text-gray-600">About us</a></li>
                <li><a href="contact.php" class="hover:text-gray-600">Contact</a></li>
            </ul>
            
            <!-- Utility Icons -->
            <div class="flex items-center space-x-6 text-black">
                <a href="#" class="text-xl hover:opacity-70"><i class="fa-solid fa-magnifying-glass"></i></a>
                <?php 
                    $cart_count = 0;
                    if(isset($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $item) {
                            $cart_count += $item['qty'];
                        }
                    }
                ?>
                
                <!-- Login/Profile Button -->
                <?php if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <a href="profile.php" class="text-[14px] font-bold hover:text-gray-600 transition tracking-tight flex items-center gap-2">
                        <i class="fa-regular fa-user"></i> My Account
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-[14px] font-bold hover:text-gray-600 transition tracking-tight">Login</a>
                <?php endif; ?>
                
                <!-- Cart -->
                <a href="cart.php" class="text-xl hover:opacity-70 relative">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold font-sans"><?= $cart_count ?></span>
                </a>
            </div>
        </nav>
    </div>
</header>
