<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16 min-h-[60vh]">
    <div class="container mx-auto px-4 lg:px-6">
        <h1 class="text-4xl font-black tracking-tighter mb-12">My Wishlist.</h1>

        <?php if (empty($_SESSION['wishlist'])): ?>
            <div class="text-center py-20 bg-gray-50 rounded-3xl">
                <i class="fa-regular fa-heart text-6xl text-gray-200 mb-6"></i>
                <p class="text-xl text-gray-400 font-bold mb-8">No favorites yet.</p>
                <a href="shop.php" class="bg-black text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">Explore Collection</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($_SESSION['wishlist'] as $item): ?>
                <div class="group relative">
                    <!-- Product Image -->
                    <div class="aspect-[4/5] bg-gray-50 rounded-3xl overflow-hidden mb-4 relative">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                        
                        <!-- Remove Button -->
                        <a href="wishlist_action.php?action=remove&id=<?= $item['id'] ?>" class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition shadow-sm z-10" title="Remove">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </a>
                    </div>
                    
                    <!-- Details -->
                    <div>
                        <h3 class="font-bold text-lg mb-1 truncate"><?= htmlspecialchars($item['name']) ?></h3>
                        <div class="flex items-center justify-between">
                            <span class="font-black text-lg">$<?= htmlspecialchars($item['price']) ?></span>
                            <a href="product-details.php?id=<?= $item['id'] ?>" class="text-xs font-bold uppercase border-b border-black pb-0.5 hover:text-gray-600 hover:border-gray-600 transition">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
