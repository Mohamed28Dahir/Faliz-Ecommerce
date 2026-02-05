<?php
require_once 'includes/db.php';
$result = $conn->query("DESCRIBE orders");
if ($result) {
    echo "Table 'orders' structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Table 'orders' does not exist or error: " . $conn->error;
}
?>
