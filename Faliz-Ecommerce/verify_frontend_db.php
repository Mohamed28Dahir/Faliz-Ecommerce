<?php
require_once 'includes/db.php';
include 'includes/products.php';

echo "Total Products Fetched from DB: " . count($all_products) . "\n";
if (count($all_products) > 0) {
    echo "First Product: " . $all_products[0]['name'] . " - $" . $all_products[0]['price'] . "\n";
} else {
    echo "No products found.\n";
}
?>
