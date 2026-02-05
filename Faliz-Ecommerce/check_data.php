<?php
require_once 'includes/db.php';
$result = $conn->query("SELECT id, name, category, sizes, colors FROM products LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . "\n";
    echo "Name: " . $row['name'] . "\n";
    echo "Category: " . $row['category'] . "\n";
    echo "Sizes: " . ($row['sizes'] ? $row['sizes'] : "NULL/EMPTY") . "\n";
    echo "Colors: " . ($row['colors'] ? $row['colors'] : "NULL/EMPTY") . "\n";
    echo "------------------------\n";
}
?>
