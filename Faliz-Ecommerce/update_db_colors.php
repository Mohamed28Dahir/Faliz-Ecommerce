<?php
require_once 'includes/db.php';

// Add 'colors' column if it doesn't exist
$sql = "ALTER TABLE products ADD COLUMN colors VARCHAR(255) DEFAULT NULL AFTER sizes";

if ($conn->query($sql) === TRUE) {
    echo "Column 'colors' added successfully to 'products' table.<br>";
} else {
    echo "Error adding column (or it already exists): " . $conn->error . "<br>";
}

// Update existing products with default colors for demo
$update_sql = "UPDATE products SET colors = 'Black,White,Beige' WHERE colors IS NULL";

if ($conn->query($update_sql) === TRUE) {
    echo "Existing products updated with default colors (Black, White, Beige).<br>";
} else {
    echo "Error updating existing products: " . $conn->error;
}
?>
