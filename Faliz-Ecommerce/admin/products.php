<?php
include 'auth_session.php';
require_once '../includes/db.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: products.php?msg=Product deleted successfully");
    exit();
}

// Handle Add Product Request
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_product') {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : "NULL";
    $description = $conn->real_escape_string($_POST['description']);
    
    // Handle Sizes
    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : 'One Size';
    $sizes = $conn->real_escape_string($sizes);

    // Handle Colors
    $colors = isset($_POST['colors']) ? $conn->real_escape_string($_POST['colors']) : 'Black';
    
    // IMAGE HANDLING: Prefer File Upload over URL
    $image = "";
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $filename = time() . "_" . basename($_FILES["image_file"]["name"]);
        $target_file = $target_dir . $filename;
        $db_path = "assets/uploads/" . $filename; // Path for DB
        
        $check = getimagesize($_FILES["image_file"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                $image = $conn->real_escape_string($db_path);
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    } else {
        $image = $conn->real_escape_string($_POST['image_url']);
    }

    if (empty($error)) {
        $sql = "INSERT INTO products (name, category, price, old_price, sizes, colors, image, description) 
                VALUES ('$name', '$category', '$price', $old_price, '$sizes', '$colors', '$image', '$description')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: products.php?msg=Product added successfully");
            exit();
        } else {
            $error = "Error adding product: " . $conn->error;
        }
    }
}

// Fetch Categories for Filter
$cat_result = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");

// Handle Filter
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch Products
$sql = "SELECT * FROM products";
if ($category_filter) {
    $sql .= " WHERE category = '" . $conn->real_escape_string($category_filter) . "'";
}
$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        /* Modal Transitions */
        .modal {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
        .modal.active .modal-content {
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="ml-64 w-full p-8 lg:p-12">
        <header class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Product Inventory</h2>
                <p class="text-gray-500">Manage your catalog, prices, and stock.</p>
            </div>
            
            <?php if(isset($_GET['msg'])): ?>
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-8 py-4 rounded-xl shadow-2xl z-50 animate-in fade-in slide-in-from-top-4 duration-500 font-bold flex items-center gap-3">
                <i class="fa-solid fa-check-circle"></i>
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
            <?php endif; ?>
            
            <?php if($error): ?>
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-8 py-4 rounded-xl shadow-2xl z-50 animate-in fade-in slide-in-from-top-4 duration-500 font-bold flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <div class="flex gap-4">
                <!-- Category Filter -->
                <form method="GET" class="relative">
                    <i class="fa-solid fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <select name="category" onchange="this.form.submit()" class="pl-10 pr-8 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold focus:outline-none focus:border-black appearance-none cursor-pointer hover:bg-gray-50 transition shadow-sm">
                        <option value="">All Categories</option>
                        <?php 
                        if ($cat_result->num_rows > 0) {
                            $cat_result->data_seek(0); // Reset pointer
                            while($cat = $cat_result->fetch_assoc()) {
                                $selected = ($category_filter === $cat['category']) ? 'selected' : '';
                                echo "<option value='" . $cat['category'] . "' $selected>" . $cat['category'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </form>

                <button onclick="toggleModal('addProductModal')" class="bg-black text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg text-sm flex items-center">
                    <i class="fa-solid fa-plus mr-2"></i> Add Product
                </button>
            </div>
        </header>

        <!-- Product Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-widest border-b border-gray-100">
                        <th class="p-6">Product</th>
                        <th class="p-6">Category</th>
                        <th class="p-6">Price</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <img src="<?= $row['image'] ?>" alt="" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                                <div>
                                    <p class="font-bold text-black"><?= $row['name'] ?></p>
                                    <p class="text-xs text-gray-400">ID: #<?= $row['id'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500">
                                <?= $row['category'] ?>
                            </span>
                        </td>
                        <td class="p-6 font-bold">
                            $<?= $row['price'] ?>
                            <?php if($row['old_price']): ?>
                                <span class="text-xs text-gray-400 line-through ml-2">$<?= $row['old_price'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="product-edit.php?id=<?= $row['id'] ?>" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-black hover:text-white flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <a href="products.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product permanently?');" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- ADD PRODUCT MODAL -->
    <div id="addProductModal" class="modal fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-2xl border border-gray-100 modal-content max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Add New Product</h2>
                <button onclick="toggleModal('addProductModal')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-times text-gray-500"></i>
                </button>
            </div>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="add_product">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g. Silk Summer Dress" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Category</label>
                        <select name="category" id="modalCategory" onchange="updateSizeOptions()" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                            <option value="Dresses">Dresses</option>
                            <option value="Shoes">Shoes</option>
                            <option value="Bags">Bags</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Jewelry">Jewelry</option>
                        </select>
                    </div>
                </div>

                <!-- DYNAMIC SIZES -->
                <div id="sizeContainer" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Available Sizes</label>
                    
                    <!-- Dress Sizes -->
                    <div id="sizes-Dresses" class="size-group flex flex-wrap gap-2">
                        <?php foreach(['XS','S','M','L','XL','XXL'] as $s): ?>
                        <label class="cursor-pointer">
                            <input type="checkbox" name="sizes[]" value="<?= $s ?>" class="peer hidden" checked>
                            <span class="block px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-500 text-sm font-bold peer-checked:bg-black peer-checked:text-white peer-checked:border-black transition select-none"><?= $s ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <!-- Shoe Sizes -->
                    <div id="sizes-Shoes" class="size-group flex flex-wrap gap-2 hidden">
                        <?php foreach(['36','37','38','39','40','41','42'] as $s): ?>
                        <label class="cursor-pointer">
                            <input type="checkbox" name="sizes[]" value="<?= $s ?>" class="peer hidden">
                            <span class="block px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-500 text-sm font-bold peer-checked:bg-black peer-checked:text-white peer-checked:border-black transition select-none"><?= $s ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>

                     <!-- Default -->
                     <div id="sizes-Default" class="size-group hidden">
                        <label class="cursor-pointer">
                            <input type="checkbox" name="sizes[]" value="One Size" class="peer hidden" checked>
                            <span class="block px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-500 text-sm font-bold peer-checked:bg-black peer-checked:text-white peer-checked:border-black transition select-none">One Size</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Available Colors (Comma Separated)</label>
                    <input type="text" name="colors" placeholder="e.g. Black, Red, Navy Blue" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Price ($)</label>
                        <input type="number" step="0.01" name="price" required placeholder="0.00" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Old Price ($) <span class="text-[10px] font-normal lowercase">(Optional)</span></label>
                        <input type="number" step="0.01" name="old_price" placeholder="0.00" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Upload Image</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:border-black transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">OR Image URL</label>
                        <input type="url" name="image_url" placeholder="https://..." class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition"></textarea>
                </div>

                <div class="pt-2 flex gap-4">
                    <button type="submit" class="flex-1 bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">Create Product</button>
                    <button type="button" onclick="toggleModal('addProductModal')" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-xl font-bold hover:bg-gray-200 transition text-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateSizeOptions() {
            const category = document.getElementById('modalCategory').value;
            const sizeGroups = document.querySelectorAll('.size-group');
            const checkboxes = document.querySelectorAll('input[name="sizes[]"]');

            // Hide All Groups and Uncheck
            sizeGroups.forEach(g => echo = g.classList.add('hidden'));
            checkboxes.forEach(c => c.checked = false);

            // Show Relevant Group
            let activeGroup;
            if (category === 'Dresses') {
                activeGroup = document.getElementById('sizes-Dresses');
            } else if (category === 'Shoes') {
                activeGroup = document.getElementById('sizes-Shoes');
            } else {
                activeGroup = document.getElementById('sizes-Default');
            }

            if (activeGroup) {
                activeGroup.classList.remove('hidden');
                // Auto-check all options for convenience
                activeGroup.querySelectorAll('input').forEach(c => c.checked = true);
            }
        }

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('active');
        }
    </script>
</body>
</html>
