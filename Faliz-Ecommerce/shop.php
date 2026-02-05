<?php
// Include Database Connection
require_once 'includes/db.php';

// Include Expanded Product Dataset (Now Fetched from DB)
include 'includes/products.php';

// 1. Get Parameters from URL
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'All';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 100;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// 2. Perform Filtering
$products = array_filter($all_products, function($p) use ($selected_category, $min_price, $max_price) {
    // Category Match
    $category_match = ($selected_category === 'All' || $p['category'] === $selected_category);
    // Price Match
    $price_match = ($p['price'] >= $min_price && $p['price'] <= $max_price);
    
    return $category_match && $price_match;
});

// 3. Perform Sorting
if ($sort === 'price_low') {
    usort($products, function($a, $b) { return $a['price'] <=> $b['price']; });
} elseif ($sort === 'price_high') {
    usort($products, function($a, $b) { return $b['price'] <=> $a['price']; });
} elseif ($sort === 'newest') {
    // Dataset is already ordered, so we reverse it for "newest"
    $products = array_reverse($products);
}

// 4. Constants
$categories = ['All', 'Dresses', 'Shoes', 'Bags', 'Accessories', 'Jewelry'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Outfit', sans-serif; }
        .glass-header { 
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16">
    <div class="container mx-auto px-4 lg:px-6">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-12">
            <a href="index.php" class="hover:text-black">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-black font-medium">Shop</span>
            <?php if($selected_category !== 'All'): ?>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-black font-medium"><?= $selected_category ?></span>
            <?php endif; ?>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-32">
                    <h3 class="text-xl font-bold mb-8">Categories</h3>
                    <ul class="space-y-4">
                        <?php foreach($categories as $cat): ?>
                        <li>
                            <a href="shop.php?category=<?= $cat ?>&min_price=<?= $min_price ?>&max_price=<?= $max_price ?>&sort=<?= $sort ?>#results" 
                               class="flex items-center justify-between group">
                                <span class="<?= $selected_category === $cat ? 'text-black font-bold' : 'text-gray-500 hover:text-black' ?> transition">
                                    <?= $cat ?>
                                </span>
                                <span class="bg-gray-100 text-gray-400 text-[10px] py-1 px-2 rounded-full opacity-0 group-hover:opacity-100 transition">
                                    <?php 
                                        if($cat === 'All') echo count($all_products);
                                        else {
                                            $count = array_filter($all_products, function($p) use ($cat) { return $p['category'] === $cat; });
                                            echo count($count);
                                        }
                                    ?>
                                </span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Filter by Price (Functional Form) -->
                    <form action="shop.php#results" method="GET" class="mt-12 group/filter">
                        <input type="hidden" name="category" value="<?= $selected_category ?>">
                        <input type="hidden" name="sort" value="<?= $sort ?>">
                        
                        <h3 class="text-xl font-bold mb-8">Filter by Price</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center gap-2 p-1 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex-1">
                                    <input type="number" name="min_price" value="<?= $min_price ?>" min="0" max="100" class="w-full bg-transparent border-none py-3 px-4 text-center font-bold focus:ring-0 text-sm" placeholder="Min">
                                </div>
                                <div class="w-2 h-[2px] bg-gray-300"></div>
                                <div class="flex-1">
                                    <input type="number" name="max_price" value="<?= $max_price ?>" min="0" max="100" class="w-full bg-transparent border-none py-3 px-4 text-center font-bold focus:ring-0 text-sm" placeholder="Max">
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-black text-white h-14 rounded-2xl font-bold hover:bg-gray-800 transition shadow-xl hover:-translate-y-1 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-filter text-xs"></i> Apply Range
                            </button>
                            
                            <?php if($min_price > 0 || $max_price < 100): ?>
                                <a href="shop.php?category=<?= $selected_category ?>&sort=<?= $sort ?>#results" class="block text-center text-xs font-bold text-gray-400 hover:text-black transition">
                                    Reset Price Filter
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-10">
                    <p class="text-gray-500">Showing 1–<?= count($products) ?> of <?= count($products) ?> results</p>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-medium">Sort by:</span>
                        <form action="shop.php#results" method="GET" class="flex items-center">
                            <input type="hidden" name="category" value="<?= $selected_category ?>">
                            <input type="hidden" name="min_price" value="<?= $min_price ?>">
                            <input type="hidden" name="max_price" value="<?= $max_price ?>">
                            
                            <select name="sort" class="border group-hover:border-black bg-white rounded-lg py-1 px-3 text-sm font-bold focus:ring-0 cursor-pointer appearance-none">
                                <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Default sorting</option>
                                <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                                <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                            </select>
                            
                            <button type="submit" class="ml-2 bg-black text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-gray-800 transition">
                                Apply
                            </button>
                        </form>
                    </div>
                </div>

                <div id="results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 scroll-mt-32">
                    <?php if(empty($products)): ?>
                        <div class="col-span-full py-20 text-center text-gray-400">
                            <p class="text-2xl font-bold mb-4 text-black italic">"No items matched your filter..."</p>
                            <p class="mb-8">Try adjusting your price range or category.</p>
                            <a href="shop.php" class="inline-block bg-black text-white px-8 py-4 rounded-2xl font-bold hover:bg-gray-800 transition shadow-xl">
                                Clear All Filters
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach($products as $product): ?>
                        <div class="group">
                            <div class="relative rounded-3xl overflow-hidden mb-6 aspect-[4/5] bg-gray-50">
                                <a href="product-details.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </a>
                                
                                <?php if($product['old_price']): ?>
                                    <span class="absolute top-4 left-4 bg-red-500 text-white text-[11px] font-bold px-3 py-1 rounded-full">-22% sale</span>
                                <?php endif; ?>

                                <!-- Hover Actions -->
                                <div class="absolute inset-x-0 bottom-0 p-4 transition-all duration-300 transform translate-y-full group-hover:translate-y-0">
                                    <div class="absolute top-4 right-4 flex flex-col gap-2 translate-x-12 group-hover:translate-x-0 transition-transform duration-300">
                                        <a href="product-details.php?id=<?= $product['id'] ?>" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white transition">
                                            <i class="fa-solid fa-expand"></i>
                                        </a>
                                    </div>
                                    <div class="glass-header rounded-2xl p-4 flex justify-center space-x-3">
                                        <a href="cart_action.php?action=add&id=<?= $product['id'] ?>&name=<?= urlencode($product['name']) ?>&price=<?= $product['price'] ?>&image=<?= urlencode($product['img']) ?>&redirect=shop.php" class="w-full h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-black hover:text-white transition shadow-lg font-bold text-sm">
                                            <i class="fa-solid fa-cart-shopping mr-2"></i> Add to Cart
                                        </a>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
