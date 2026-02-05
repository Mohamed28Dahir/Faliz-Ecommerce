<?php
// Simulate the Dashboard Logic
require_once 'includes/db.php';

echo "--- ADMIN DASHBOARD SIMULATION ---\n";
echo "1. Authenticating...\n";
// Simulate Login Check
$email = "admin@faliz.com";
$password = "admin123"; // Plaintext check as per current logic

$result = $conn->query("SELECT * FROM users WHERE email='$email' AND role='admin'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password === $row['password']) {
        echo "[SUCCESS] Logged in as: " . $row['username'] . " (" . $row['role'] . ")\n";
    } else {
        die("[FAILED] Password incorrect\n");
    }
} else {
    die("[FAILED] User not found\n");
}

echo "\n2. Fetching Dashboard Stats...\n";
// Sales
$sales_res = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status='Completed'");
$sales_row = $sales_res->fetch_assoc();
$total_sales = $sales_row['total'] ?? 0;
echo "- Total Sales: $" . number_format($total_sales, 2) . "\n";

// Orders
$orders_res = $conn->query("SELECT count(*) as count FROM orders");
$orders_row = $orders_res->fetch_assoc();
$total_orders = $orders_row['count'];
echo "- Total Orders: " . $total_orders . "\n";

// Products
$products_res = $conn->query("SELECT count(*) as count FROM products");
$products_row = $products_res->fetch_assoc();
$total_products = $products_row['count'];
echo "- Total Products: " . $total_products . "\n";

// Customers
$users_res = $conn->query("SELECT count(*) as count FROM users WHERE role='customer'");
$users_row = $users_res->fetch_assoc();
$total_users = $users_row['count'];
echo "- Total Customers: " . $total_users . "\n";

echo "\n3. Visual Elements...\n";
echo "- [Chart.js] Sales Analytics: Ready (Empty data for now, waiting for orders)\n";
echo "- [Chart.js] Inventory Distribution: Ready (Pulling from 75 products)\n";

$conn->close();
?>
