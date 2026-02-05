<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Faliz.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .contact-hero-bg { background-color: #fce7f3; }
    </style>
</head>
<body class="bg-white text-black antialiased">

<?php include 'includes/header.php'; ?>

<main>
    <!-- Contact Hero Section -->
    <section class="contact-hero-bg py-20 lg:py-32 overflow-hidden">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-5xl lg:text-7xl font-bold mb-8">Get In Touch.</h1>
                <p class="text-lg text-gray-700 leading-relaxed">We'd love to hear from you. Whether you have a question about our products, pricing, or anything else, our team is ready to answer all your questions.</p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-24 lg:py-32">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex flex-col lg:flex-row gap-20">
                <!-- Contact Info -->
                <div class="lg:w-1/3">
                    <h2 class="text-3xl font-bold mb-10">Contact Information</h2>
                    <div class="space-y-12">
                        <!-- Office -->
                        <div class="flex gap-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2">Our Office</h4>
                                <p class="text-gray-500 leading-relaxed">123 Fashion Ave, Suite 500<br>Gulshan 2, Dhaka, Bangladesh</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex gap-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2">Phone Number</h4>
                                <p class="text-gray-500 leading-relaxed">+880 1234 567 890<br>Available Mon - Sat (9am - 6pm)</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex gap-6">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2">Email Address</h4>
                                <p class="text-gray-500 leading-relaxed">hello@faliz.com<br>support@faliz.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-16">
                        <h4 class="font-bold text-lg mb-6">Follow Our Journey</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 border border-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="w-12 h-12 border border-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="w-12 h-12 border border-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition"><i class="fa-brands fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:w-2/3">
                    <div class="bg-white p-8 lg:p-12 rounded-[40px] shadow-xl border border-gray-50">
                        <h2 class="text-3xl font-bold mb-4">Send us a Message</h2>
                        <p class="text-gray-500 mb-10">Use the form below to send us a message and we'll get back to you as soon as possible.</p>
                        
                        <form action="#" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold mb-3">Your Name</label>
                                    <input type="text" placeholder="John Doe" class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-black transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-3">Email Address</label>
                                    <input type="email" placeholder="john@example.com" class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-black transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-3">Subject</label>
                                <input type="text" placeholder="How can we help?" class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-black transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-3">Your Message</label>
                                <textarea rows="6" placeholder="Tell us more about your query..." class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-black transition resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-black text-white py-5 rounded-2xl font-bold text-lg hover:bg-gray-800 transition transform hover:-translate-y-1">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Placeholder -->
    <section class="h-[500px] w-full bg-gray-100 relative grayscale hover:grayscale-0 transition duration-1000">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center group">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl mb-4 group-hover:scale-110 transition mx-auto">
                    <i class="fa-solid fa-location-dot text-3xl"></i>
                </div>
                <p class="font-bold text-xl uppercase tracking-widest">Find us in Dhaka</p>
                <p class="text-gray-500 text-sm mt-2">Gulshan 2, Dhaka 1212</p>
            </div>
        </div>
        <!-- In a real app, you'd embed a Google Map iframe here -->
    </section>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
