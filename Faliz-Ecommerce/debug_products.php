<?php
require_once 'includes/db.php';
require_once 'includes/products.php';

echo "<h1>Product Data Dump</h1>";
echo "<pre>";
print_r($all_products);
echo "</pre>";
?>
