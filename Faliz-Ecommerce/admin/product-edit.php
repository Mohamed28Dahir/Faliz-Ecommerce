<?php
include 'auth_session.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: products.php"); exit(); }

$success = "";
$error = "";

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    
    // Existing Image
    $image = $_POST['current_image'];

    // 1. Check if new file uploaded
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $filename = time() . "_" . basename($_FILES["image_file"]["name"]);
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
            $image = $conn->real_escape_string("assets/uploads/" . $filename);
        }
    } 
    // 2. Else check if new URL provided
    elseif (!empty($_POST['image_url'])) {
        $image = $conn->real_escape_string($_POST['image_url']);
    }

    $sql = "UPDATE products SET 
            name='$name', category='$category', price='$price', old_price=$old_price, 
            sizes='$sizes', colors='$colors', image='$image', description='$description' 
            WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: products.php?msg=Product updated successfully");
        exit();
    } else {
        $error = "Error updating product: " . $conn->error;
    }
}

// Fetch Existing Data
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-2xl border border-gray-100">
        <h2 class="text-3xl font-bold mb-8">Edit Product</h2>

        <?php if($success): ?>
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-600 text-sm font-bold text-center">
                <?= $success ?> <a href="products.php" class="underline">Back to List</a>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="current_image" value="<?= $product['image'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Product Name</label>
                    <input type="text" name="name" value="<?= $product['name'] ?>" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Category</label>
                    <select name="category" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                        <?php 
                        $cats = ['Dresses', 'Shoes', 'Bags', 'Accessories', 'Jewelry'];
                        foreach($cats as $c) {
                            $sel = ($c == $product['category']) ? 'selected' : '';
                            echo "<option value='$c' $sel>$c</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- SIZES -->
            <?php $current_sizes = explode(',', $product['sizes'] ?? ''); ?>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Available Sizes</label>
                <div class="flex flex-wrap gap-2">
                    <!-- Check all relevant sizes based on what's saved, or show all options if mixed -->
                    <?php 
                    // Show a merged list of common sizes for simplicity in Edit Mode
                    $all_possible_sizes = array_merge(['XS','S','M','L','XL','XXL'], ['36','37','38','39','40','41','42'], ['One Size']);
                    // Filter down to likely relevant ones based on category to keep UI clean
                    if($product['category'] == 'Shoes') $show_sizes = ['36','37','38','39','40','41','42'];
                    elseif($product['category'] == 'Dresses') $show_sizes = ['XS','S','M','L','XL','XXL'];
                    else $show_sizes = ['One Size'];
                    
                    foreach($show_sizes as $s): 
                        $checked = in_array($s, $current_sizes) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer">
                        <input type="checkbox" name="sizes[]" value="<?= $s ?>" class="peer hidden" <?= $checked ?>>
                        <span class="block px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-500 text-sm font-bold peer-checked:bg-black peer-checked:text-white peer-checked:border-black transition select-none"><?= $s ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Old Price ($)</label>
                    <input type="number" step="0.01" name="old_price" value="<?= $product['old_price'] ?>" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Change Image (Upload)</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:border-black transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">OR New Image URL</label>
                    <input type="url" name="image_url" placeholder="<?= $product['image'] ?>" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-black transition"><?= $product['description'] ?></textarea>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">Save Changes</button>
                <a href="products.php" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-xl font-bold hover:bg-gray-200 transition text-center flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
