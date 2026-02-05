<?php
require_once 'includes/db.php';

echo "<h2>Users Table</h2>";
$res = $conn->query("DESCRIBE users");
while($row = $res->fetch_assoc()) { echo $row['Field'] . " | "; }

echo "<h2>Orders Table</h2>";
$res = $conn->query("DESCRIBE orders");
while($row = $res->fetch_assoc()) { echo $row['Field'] . " | "; }
?>
