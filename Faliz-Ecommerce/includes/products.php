<?php
// Connect to Database if not already connected (this file might be included after db.php in some places, so check)
if (!isset($conn)) {
    require_once __DIR__ . '/db.php';
}

// Fetch All Products from MySQL
$all_products = [];
$sql = "SELECT * FROM products ORDER BY id DESC"; // Newest products first
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $all_products[] = [
            'id' => $row['id'],
            'category' => $row['category'],
            'name' => $row['name'],
            'price' => $row['price'],
            'old_price' => $row['old_price'],
            'img' => $row['image'],
            'description' => $row['description'],
            'sizes' => $row['sizes'],
            'colors' => $row['colors']
        ];
    }
}
?>
