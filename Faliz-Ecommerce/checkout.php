<?php
session_start();
require_once 'includes/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    // Save cart intent? For now just redirect to login
    header("Location: login.php?redirect=checkout");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_amount = $_POST['total_amount'] ?? 0;

// Validate Cart
if (empty($_SESSION['cart']) || $total_amount <= 0) {
    header("Location: cart.php");
    exit();
}

// 1. Create Order
$sql = "INSERT INTO orders (user_id, total_amount, status, created_at) VALUES ($user_id, $total_amount, 'Pending', NOW())";
if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;
    
    // 2. (Optional) Save Order Items - For now we just save the main order as per current schema
    // In a full system, we'd have an order_items table.
    
    // 3. Clear Cart
    unset($_SESSION['cart']);
    
    // 4. Redirect to Profile (or success page)
    header("Location: profile.php?msg=Order placed successfully!");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
