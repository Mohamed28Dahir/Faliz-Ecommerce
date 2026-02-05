<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit();
}

$cart_items = $_SESSION['cart'];
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$shipping = 0; // Free shipping logic can be added here
$total = $subtotal + $shipping;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16 min-h-[70vh]">
    <div class="container mx-auto px-4 lg:px-6 max-w-6xl">
        <h1 class="text-4xl font-black tracking-tighter mb-12">Secure Payment.</h1>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Payment Form -->
            <div class="flex-1">
                <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-gray-100">
                    <div class="mb-8 flex items-center gap-4">
                        <div class="flex -space-x-2">
                            <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center text-[8px] font-bold border border-white">VISA</div>
                            <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center text-[8px] font-bold border border-white">MC</div>
                            <div class="w-10 h-6 bg-gray-200 rounded flex items-center justify-center text-[8px] font-bold border border-white">AMEX</div>
                        </div>
                        <span class="text-sm text-gray-400 font-medium">Encrypting 256-bit</span>
                    </div>

                    <form action="checkout.php" method="POST" class="space-y-6">
                        <!-- Payment Amount Simulation -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Enter Payment Amount</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-gray-400">$</span>
                                <input type="number" name="total_amount" step="0.01" value="<?= number_format($total, 2, '.', '') ?>" class="w-full bg-gray-50 border-gray-100 rounded-xl pl-8 pr-4 py-4 font-bold focus:ring-black focus:border-black transition text-2xl" required>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 font-medium">Simulated Payment: Confirm the amount to proceed.</p>
                        </div>

                        <button type="submit" class="w-full bg-black text-white h-16 rounded-2xl font-bold text-lg hover:bg-gray-800 transition transform hover:-translate-y-1 shadow-xl flex items-center justify-center gap-3 mt-4">
                            <span>Confirm & Pay</span>
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary (Sidebar) -->
            <aside class="w-full lg:w-96">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 sticky top-32">
                    <h3 class="font-bold text-xl mb-6">Order Summary</h3>
                    
                    <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        <?php foreach($cart_items as $item): ?>
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="<?= $item['image'] ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-sm truncate w-40"><?= htmlspecialchars($item['name']) ?></h4>
                                <p class="text-xs text-gray-500 mb-1"><?= $item['size'] ?> | <?= $item['color'] ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-400">Qty: <?= $item['qty'] ?></span>
                                    <span class="font-bold text-sm">$<?= number_format($item['price'] * $item['qty'], 2) ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="space-y-3 pt-6 border-t border-gray-100 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Shipping</span>
                            <span class="text-green-600 font-bold">Free</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold pt-4 border-t border-gray-100">
                            <span>Total</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
