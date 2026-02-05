<?php include 'includes/products.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faliz. | Summer Style Sensations</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .hero-bg { background-color: #eaf1f9; }
        .glass-header { 
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero-bg py-20 lg:py-32 overflow-hidden">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="max-w-xl text-center lg:text-left">
                    <h1 class="text-6xl lg:text-8xl font-bold leading-none mb-8">Summer Style<br>Sensations.</h1>
                    <p class="text-lg text-gray-600 mb-10 max-w-md mx-auto lg:mx-0">Having plain clothing makes you look ordinary. We can assist you in choosing the right dresses with Faiza.</p>
                    <a href="shop.php" class="inline-block bg-black text-white px-10 py-4 rounded-full font-semibold hover:bg-gray-800 transition-all transform hover:-translate-y-1">Shop Now</a>
                </div>
                <div class="relative group">
                    <div class="w-[350px] h-[450px] lg:w-[550px] lg:h-[600px] rounded-[40px] overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000&auto=format&fit=crop" alt="Hero" class="w-full h-full object-cover">
                    </div>
                    <!-- Decorative Dots -->
                    <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 flex space-x-3">
                        <div class="w-12 h-3 bg-black rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar -->
    <section class="py-16 border-b border-gray-100">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex items-center gap-5">
                    <div class="text-4xl"><i class="fa-solid fa-earth-americas"></i></div>
                    <div>
                        <h3 class="font-bold">Worldwide Shipping</h3>
                        <p class="text-sm text-gray-500">World Wide Free Shipping.</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="text-4xl"><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <h3 class="font-bold">Secured Payment</h3>
                        <p class="text-sm text-gray-500">Safe & Secured Payments.</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="text-4xl"><i class="fa-solid fa-rotate-left"></i></div>
                    <div>
                        <h3 class="font-bold">30-Days Free Returns</h3>
                        <p class="text-sm text-gray-500">Within 30 Days for an Exchange.</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="text-4xl"><i class="fa-solid fa-gift"></i></div>
                    <div>
                        <h3 class="font-bold">Surprise Gift</h3>
                        <p class="text-sm text-gray-500">Free gift cards & vouchers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="py-20 lg:py-24">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                <!-- Category Item -->
                <?php
                $categories = [
                    ['name' => "Dresses", 'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=400'],
                    ['name' => "Shoes", 'img' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=400'],
                    ['name' => "Bags", 'img' => 'https://images.unsplash.com/photo-1584917033904-47b08753f173?q=80&w=400'],
                    ['name' => "Accessories", 'img' => 'https://images.unsplash.com/photo-1535633302723-997f858d4d5e?q=80&w=400'],
                    ['name' => "Jewelry", 'img' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=400']
                ];
                foreach ($categories as $cat):
                ?>
                <div class="relative group h-[300px] lg:h-[400px] rounded-2xl overflow-hidden cursor-pointer">
                    <img src="<?= $cat['img'] ?>" alt="<?= $cat['name'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/10 flex flex-col items-center justify-end pb-8">
                        <h3 class="text-white font-bold text-xl mb-4 drop-shadow-lg"><?= $cat['name'] ?></h3>
                        <a href="shop.php?category=<?= $cat['name'] ?>" class="bg-white text-black text-xs font-bold py-2.5 px-6 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">Shop Now</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Trending Products -->
    <section class="pb-24 lg:pb-32">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Trending product</h2>
                <p class="text-gray-500">Follow the most popular trends and get exclusive items from Faiza shop.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                // Shuffle and pick 4 trending items from the dataset
                $trending = array_slice($all_products, 0, 8); 
                foreach($trending as $product):
                ?>
                <div class="group">
                    <div class="relative rounded-3xl overflow-hidden mb-6 aspect-[4/5]">
                        <a href="product-details.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                            <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>
                        <?php if($product['old_price']): ?>
                            <span class="absolute top-4 left-4 bg-red-500 text-white text-[11px] font-bold px-3 py-1 rounded-full">-22% sale</span>
                        <?php endif; ?>
                        
                        <div class="absolute inset-x-0 bottom-0 p-4 transition-all duration-300 transform translate-y-full group-hover:translate-y-0">
                            <div class="glass-header rounded-2xl p-4 flex justify-center space-x-3">
                                <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-black hover:text-white transition shadow-lg"><i class="fa-regular fa-heart"></i></button>
                                <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-black hover:text-white transition shadow-lg"><i class="fa-solid fa-cart-shopping"></i></button>
                                <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-black hover:text-white transition shadow-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="product-details.php?id=<?= $product['id'] ?>" class="block group">
                            <h3 class="text-[17px] font-medium mb-2 group-hover:text-gray-600 transition"><?= $product['name'] ?></h3>
                        </a>
                        <div class="flex items-center gap-3">
                            <?php if($product['old_price']): ?>
                                <span class="text-gray-400 line-through text-sm">$<?= $product['old_price'] ?></span>
                            <?php endif; ?>
                            <span class="font-bold text-black font-lg">$<?= $product['price'] ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
