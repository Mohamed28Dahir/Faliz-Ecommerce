<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .about-hero-bg { background-color: #f0f4f9; }
    </style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main>
    <!-- About Hero Section -->
    <section class="about-hero-bg py-20 lg:py-32 overflow-hidden">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-5xl lg:text-7xl font-bold mb-8">Empowering Women Through Style.</h1>
                <p class="text-lg text-gray-600 leading-relaxed">Faliz is a premium fashion destination dedicated exclusively to women. We believe that every woman deserves to feel confident, elegant, and uniquely herself.</p>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 lg:py-32">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800" alt="About Faliz" class="rounded-[40px] shadow-2xl">
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-bold mb-8">What is Faliz?</h2>
                    <div class="space-y-6 text-gray-600 leading-relaxed">
                        <p>Faliz is more than just an online shop; it's a curated collection of modern women's fashion. Our platform is designed for those who appreciate quality, sophistication as well as simplicity.</p>
                        <p>From timeless dresses to contemporary stilettoes, we search the globe for pieces that tell a story. We focus 100% on women's needs, ensuring that every click brings you closer to your perfect look.</p>
                        <div class="grid grid-cols-2 gap-8 pt-8">
                            <div>
                                <h4 class="text-black font-bold text-2xl mb-2">10k+</h4>
                                <p class="text-sm">Happy Customers</p>
                            </div>
                            <div>
                                <h4 class="text-black font-bold text-2xl mb-2">500+</h4>
                                <p class="text-sm">Exclusive Designs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use the Website Section -->
    <section class="bg-gray-50 py-20 lg:py-32">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">How to Shop at Faliz</h2>
                <p class="text-gray-500">A simple guide to the best shopping experience.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-8">1</div>
                    <h3 class="text-xl font-bold mb-4">Explore Categories</h3>
                    <p class="text-gray-500">Navigate to our <strong>Shop</strong> page to see our full list of categories: Dresses, Shoes, Bags, Accessories, and Jewelry.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-8">2</div>
                    <h3 class="text-xl font-bold mb-4">Filter Your Search</h3>
                    <p class="text-gray-500">Use our smart sidebar on the Shop page to filter by specific categories or price ranges to find exactly what you need.</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-8">3</div>
                    <h3 class="text-xl font-bold mb-4">Quick Actions</h3>
                    <p class="text-gray-500">Hover over any product to reveal quick actions. You can wishlist your favorites, view details, or add to your shopping bag instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 lg:py-32">
        <div class="container mx-auto px-4 lg:px-6 text-center">
            <h2 class="text-4xl font-bold mb-16">Why Choose Faliz?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <i class="fa-solid fa-certificate text-4xl mb-6 text-black"></i>
                    <h4 class="font-bold mb-2">Quality First</h4>
                    <p class="text-sm text-gray-500">Each piece is hand-selected and verified for quality.</p>
                </div>
                <div>
                    <i class="fa-solid fa-venus text-4xl mb-6 text-black"></i>
                    <h4 class="font-bold mb-2">Women Exclusive</h4>
                    <p class="text-sm text-gray-500">We understand women's fashion like nobody else.</p>
                </div>
                <div>
                    <i class="fa-solid fa-truck-fast text-4xl mb-6 text-black"></i>
                    <h4 class="font-bold mb-2">Fast Logistics</h4>
                    <p class="text-sm text-gray-500">Worldwide shipping with premium tracking.</p>
                </div>
                <div>
                    <i class="fa-solid fa-headset text-4xl mb-6 text-black"></i>
                    <h4 class="font-bold mb-2">24/7 Support</h4>
                    <p class="text-sm text-gray-500">Our dedicated team is always here to assist you.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
