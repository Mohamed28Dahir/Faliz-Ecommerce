<?php
require_once 'includes/db.php';

// Add 'sizes' column if it doesn't exist
$sql = "ALTER TABLE products ADD COLUMN sizes VARCHAR(255) DEFAULT NULL AFTER old_price";

if ($conn->query($sql) === TRUE) {
    echo "Column 'sizes' added successfully to 'products' table.<br>";
} else {
    echo "Error adding column (or it already exists): " . $conn->error . "<br>";
}

// Update existing products with default sizes based on category
$update_dresses = "UPDATE products SET sizes = 'XS,S,M,L,XL' WHERE category = 'Dresses'";
$update_shoes = "UPDATE products SET sizes = '37,38,39,40,41' WHERE category = 'Shoes'";
$update_others = "UPDATE products SET sizes = 'One Size' WHERE category NOT IN ('Dresses', 'Shoes')";

if ($conn->query($update_dresses) && $conn->query($update_shoes) && $conn->query($update_others)) {
    echo "Existing products updated with default sizes.<br>";
} else {
    echo "Error updating existing products: " . $conn->error;
}
?>
