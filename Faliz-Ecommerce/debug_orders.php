<?php
require_once 'includes/db.php';

// Check Orders Table
echo "<h2>Orders Table Data</h2>";
$result = $conn->query("SELECT * FROM orders LIMIT 5");
if (!$result) {
    echo "Query Error (Orders): " . $conn->error . "<br>";
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print_r($row);
            echo "<hr>";
        }
    } else {
        echo "No orders found in 'orders' table.<br>";
    }
}

// Check Join Query used in Admin
echo "<h2>Admin Query Test</h2>";
$sql = "SELECT orders.*, users.name as customer_name, users.email 
        FROM orders 
        LEFT JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC";
$result = $conn->query($sql);
if (!$result) {
    echo "Query Error (Admin): " . $conn->error . "<br>";
} else {
    echo "Admin query successful. Rows: " . $result->num_rows . "<br>";
}
?>
