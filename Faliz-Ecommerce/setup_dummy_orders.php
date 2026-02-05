<?php
require_once 'includes/db.php';

// 1. Ensure we have at least one user
$user_id = 1;
$check_user = $conn->query("SELECT id FROM users LIMIT 1");
if ($check_user->num_rows > 0) {
    $row = $check_user->fetch_assoc();
    $user_id = $row['id'];
} else {
    // Create a dummy user if none exists
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('Demo Customer', 'customer@faliz.com', 'password', 'customer')");
    $user_id = $conn->insert_id;
}

// 2. Clear existing orders (optional, for clean slate)
// $conn->query("TRUNCATE TABLE orders"); 

// 3. Insert Dummy Orders
$orders = [
    ['total_amount' => 125.00, 'status' => 'Pending', 'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))],
    ['total_amount' => 45.00,  'status' => 'Completed', 'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))],
    ['total_amount' => 210.50, 'status' => 'Shipped', 'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))],
    ['total_amount' => 85.00,  'status' => 'Pending', 'created_at' => date('Y-m-d H:i:s')]
];

foreach ($orders as $o) {
    $sql = "INSERT INTO orders (user_id, total_amount, status, created_at) 
            VALUES ($user_id, {$o['total_amount']}, '{$o['status']}', '{$o['created_at']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Order added: {$o['status']} - \${$o['total_amount']}<br>";
    } else {
        echo "Error: " . $conn->error . "<br>";
    }
}
?>
