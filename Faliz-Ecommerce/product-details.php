<?php
// Include Expanded Product Dataset
include 'includes/products.php';

// Get Product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Find Product in Dataset
$product = null;
foreach ($all_products as $p) {
    if ($p['id'] == $product_id) {
        $product = $p;
        break;
    }
}

// Redirect if product not found
if (!$product) {
    header('Location: shop.php');
    exit;
}

// Define sizes based on category
$available_sizes = !empty($product['sizes']) ? explode(',', $product['sizes']) : ['One Size'];

// Get Current State (Size, Color, Qty) from URL for No-JS interactivity
$current_size = isset($_GET['size']) ? $_GET['size'] : $available_sizes[0];
$current_color = isset($_GET['color']) ? $_GET['color'] : 'black';
$current_qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
if ($current_qty < 1) $current_qty = 1;

// Ensure selected size exists in available sizes (fallback to first if not)
if (!in_array($current_size, $available_sizes)) {
    $current_size = $available_sizes[0];
}

// Mock Related Products (same category, excluding current)
$related_products = array_filter($all_products, function($p) use ($product) {
    return $p['category'] === $product['category'] && $p['id'] !== $product['id'];
});
$related_products = array_slice($related_products, 0, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?> | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        /* Professional Selection System (No-JS) - No Reload */
        .attr-pill:checked + label {
            background-color: black;
            color: white;
            border-color: black;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .color-pill:checked + label {
            outline: 2px solid black;
            outline-offset: 2px;
            transform: scale(1.1);
        }
        /* Custom Quantity Styling */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 1;
            height: 30px;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main class="py-16">
    <div class="container mx-auto px-4 lg:px-6">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-12">
            <a href="index.php" class="hover:text-black transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="shop.php" class="hover:text-black transition">Shop</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="shop.php?category=<?= $product['category'] ?>" class="hover:text-black transition"><?= $product['category'] ?></a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-black font-medium"><?= $product['name'] ?></span>
        </div>

        <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 mb-32">
            <!-- Product Images -->
            <div class="lg:w-1/2">
                <div class="rounded-[40px] overflow-hidden bg-gray-50 mb-6 aspect-[4/5]">
                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="w-full h-full object-cover">
                </div>
                <!-- Thumbnail Grid (Mock) -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="aspect-square rounded-2xl overflow-hidden border-2 border-black">
                        <img src="<?= $product['img'] ?>" alt="Thumb" class="w-full h-full object-cover">
                    </div>
                    <?php for($i=1; $i<=3; $i++): ?>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-50 cursor-pointer hover:opacity-80 transition">
                        <img src="<?= $product['img'] ?>" alt="Thumb" class="w-full h-full object-cover opacity-50">
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:w-1/2">
                <form action="cart_action.php" method="POST" class="h-full">
                    <input type="hidden" name="redirect" value="product-details.php?id=<?= $product['id'] ?>">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                    <input type="hidden" name="image" value="<?= $product['img'] ?>">

                    <div class="mb-10">
                        <span class="inline-block bg-gray-100 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6"><?= $product['category'] ?></span>
                        <h1 class="text-4xl lg:text-5xl font-bold mb-6"><?= $product['name'] ?></h1>
                        
                        <div class="flex items-center gap-4 mb-8">
                            <?php if($product['old_price']): ?>
                                <span class="text-2xl text-gray-400 line-through">$<?= $product['old_price'] ?></span>
                            <?php endif; ?>
                            <span class="text-3xl font-bold text-black font-Outfit">$<?= $product['price'] ?></span>
                        </div>

                        <p class="text-gray-500 leading-relaxed max-w-lg"><?= !empty($product['description']) ? nl2br(htmlspecialchars($product['description'])) : "Experience elegance and comfort with this premium item. Crafted with the finest materials to ensure a perfect fit for every occasion." ?></p>
                    </div>

                    <!-- Attributes Selection -->
                    <div class="space-y-10 mb-12">
                        <!-- Size Selector -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold">Select Size</h4>
                                <button type="button" class="text-sm text-gray-400 border-b border-gray-400 hover:text-black hover:border-black transition">Size Guide</button>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach($available_sizes as $index => $size): ?>
                                <div class="relative">
                                    <input type="radio" name="size" id="size-<?= $size ?>" value="<?= $size ?>" class="hidden attr-pill" <?= $index === 0 ? 'checked' : '' ?>>
                                    <label for="size-<?= $size ?>" class="min-w-[3.5rem] h-14 px-5 flex items-center justify-center rounded-2xl border-2 border-gray-100 cursor-pointer hover:border-black transition-all duration-300 font-bold select-none whitespace-nowrap">
                                        <?= $size ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Color Selector -->
                        <div>
                            <h4 class="font-bold mb-4">Select Color</h4>
                            <div class="flex flex-wrap gap-4">
                                <?php 
                                $available_colors = !empty($product['colors']) ? explode(',', $product['colors']) : ['Black'];
                                foreach($available_colors as $index => $color): 
                                    $color = trim($color);
                                    // Simple mapping for demo colors to CSS classes/hex
                                    $bg_color = 'bg-gray-200';
                                    if(strtolower($color) == 'black') $bg_color = 'bg-black';
                                    if(strtolower($color) == 'white') $bg_color = 'bg-white border border-gray-200';
                                    if(strtolower($color) == 'red') $bg_color = 'bg-red-500';
                                    if(strtolower($color) == 'blue') $bg_color = 'bg-blue-500';
                                    if(strtolower($color) == 'green') $bg_color = 'bg-green-500';
                                    if(strtolower($color) == 'beige') $bg_color = 'bg-[#F5F5DC]';
                                    if(strtolower($color) == 'peach') $bg_color = 'bg-orange-200';
                                    if(strtolower($color) == 'gray') $bg_color = 'bg-gray-400';
                                    if(strtolower($color) == 'navy') $bg_color = 'bg-blue-900';
                                ?>
                                <div class="relative group">
                                    <input type="radio" name="color" id="color-<?= $index ?>" value="<?= $color ?>" class="hidden color-pill" <?= $index === 0 ? 'checked' : '' ?>>
                                    <label for="color-<?= $index ?>" class="block w-10 h-10 rounded-full <?= $bg_color ?> cursor-pointer transition active:scale-95 shadow-sm relative overflow-hidden" title="<?= $color ?>">
                                        <!-- Fallback for unmapped colors -->
                                        <?php if($bg_color == 'bg-gray-200'): ?>
                                            <span class="absolute inset-0 flex items-center justify-center text-[8px] font-bold uppercase text-gray-500"><?= substr($color, 0, 3) ?></span>
                                        <?php endif; ?>
                                    </label>
                                    <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs font-bold opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap"><?= $color ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Quantity & Add to Bag -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex items-center bg-gray-50 rounded-2xl px-6 h-14 border border-gray-100">
                                <span class="text-xs font-black text-gray-400 tracking-widest mr-4 uppercase">Pieces</span>
                                <input type="number" name="quantity" value="1" min="1" max="99" 
                                       class="bg-transparent border-none text-center font-black text-xl w-16 focus:ring-0 cursor-pointer">
                            </div>

                            <button type="submit" class="flex-1 bg-black text-white h-14 rounded-2xl font-bold text-lg hover:bg-gray-800 transition transform hover:-translate-y-1 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-bag-shopping"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Extras -->
                <div class="border-t border-gray-100 pt-10 space-y-4">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-truck text-gray-400"></i>
                        <span class="text-gray-500">Free worldwide shipping on orders over $50.00</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-rotate-left text-gray-400"></i>
                        <span class="text-gray-500">30 days easy return policy</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Tabs (UI) -->
        <div class="mb-32">
            <div class="flex gap-12 border-b border-gray-100 mb-12 overflow-x-auto pb-px">
                <button class="pb-6 border-b-2 border-black font-bold whitespace-nowrap">Description</button>
                <button class="pb-6 border-b-2 border-transparent text-gray-400 font-bold hover:text-black transition whitespace-nowrap">Specifications</button>
                <button class="pb-6 border-b-2 border-transparent text-gray-400 font-bold hover:text-black transition whitespace-nowrap">Reviews (12)</button>
                <button class="pb-6 border-b-2 border-transparent text-gray-400 font-bold hover:text-black transition whitespace-nowrap">Shipping & Returns</button>
            </div>
            <div class="max-w-4xl text-gray-500 leading-relaxed space-y-6">
                <p><?= !empty($product['description']) ? nl2br(htmlspecialchars($product['description'])) : "This premium item represents the pinnacle of quality and style. Each piece is constructed using traditional techniques combined with modern manufacturing." ?></p>
                <ul class="list-disc pl-6 space-y-3">
                    <li>Premium high-grade materials sourced ethically.</li>
                    <li>Double-stitched seams for enhanced durability.</li>
                    <li>Ergonomic design tailored for a perfect silhouette.</li>
                    <li>Breathable fabric suitable for all-day wear.</li>
                </ul>
            </div>
        </div>

        <!-- Related Products -->
        <section>
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-3xl font-bold">You may also like</h2>
                <a href="shop.php?category=<?= $product['category'] ?>" class="text-black font-bold border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach($related_products as $rp): ?>
                <div class="group">
                    <a href="product-details.php?id=<?= $rp['id'] ?>" class="block relative rounded-3xl overflow-hidden mb-6 aspect-[4/5] bg-gray-50">
                        <img src="<?= $rp['img'] ?>" alt="<?= $rp['name'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </a>
                    <div>
                        <h3 class="text-[17px] font-medium mb-2 group-hover:text-gray-600 transition"><?= $rp['name'] ?></h3>
                        <div class="flex items-center gap-3">
                            <?php if($rp['old_price']): ?>
                                <span class="text-gray-400 line-through text-sm">$<?= $rp['old_price'] ?></span>
                            <?php endif; ?>
                            <span class="font-bold text-black font-lg">$<?= $rp['price'] ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
