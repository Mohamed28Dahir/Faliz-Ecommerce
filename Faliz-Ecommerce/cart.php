<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Bag | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16 min-h-[60vh]">
    <div class="container mx-auto px-4 lg:px-6">
        <h1 class="text-4xl font-black tracking-tighter mb-12">Shopping Bag.</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="text-center py-20 bg-gray-50 rounded-3xl">
                <i class="fa-solid fa-basket-shopping text-6xl text-gray-200 mb-6"></i>
                <p class="text-xl text-gray-400 font-bold mb-8">Your bag is empty.</p>
                <a href="shop.php" class="bg-black text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Cart Items -->
                <div class="lg:w-2/3 space-y-6">
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $key => $item): 
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    ?>
                    <div class="flex gap-6 items-center p-6 border border-gray-100 rounded-3xl hover:shadow-lg transition bg-white relative group">
                        <div class="w-24 h-32 rounded-xl bg-gray-50 overflow-hidden flex-shrink-0">
                            <img src="<?= $item['image'] ?>" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($item['name']) ?></h3>
                                <a href="cart_action.php?action=remove&key=<?= $key ?>" class="text-gray-300 hover:text-red-500 transition px-2">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">
                                Size: <span class="font-bold text-black"><?= $item['size'] ?></span> &nbsp;|&nbsp; 
                                Color: <span class="uppercase font-bold text-black text-xs"><?= $item['color'] ?></span>
                            </p>
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-bold text-gray-400 tracking-widest uppercase">Qty: <?= $item['qty'] ?></span>
                                <span class="font-black text-xl font-Outfit">$<?= number_format($subtotal, 2) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-gray-50 p-8 rounded-3xl sticky top-24">
                        <h3 class="text-xl font-bold mb-6">Order Summary</h3>
                        <div class="space-y-4 mb-8 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span class="font-bold text-black">$<?= number_format($total, 2) ?></span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping</span>
                                <span class="font-bold text-black">Free</span>
                            </div>
                            <div class="flex justify-between text-xl font-black pt-4 border-t border-gray-200">
                                <span>Total</span>
                                <span>$<?= number_format($total, 2) ?></span>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <a href="payment.php" class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg flex justify-between items-center px-6 group">
                                <span>Checkout</span>
                                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                        <p class="text-center text-[10px] text-gray-400 mt-4 uppercase font-bold tracking-widest">
                            <i class="fa-solid fa-lock mr-1"></i> Secure Payment
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
