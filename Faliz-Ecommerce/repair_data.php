<?php
require_once 'includes/db.php';

// Force update everything to have data so the UI looks good
$sql1 = "UPDATE products SET sizes='XS,S,M,L,XL' WHERE sizes IS NULL OR sizes = '' OR sizes = 'One Size'";
if ($conn->query($sql1)) {
    echo "Updated Sizes explicitly.<br>";
}

$sql2 = "UPDATE products SET colors='Black,Peach,Gray,White' WHERE colors IS NULL OR colors = ''";
if ($conn->query($sql2)) {
    echo "Updated Colors explicitly.<br>";
}

echo "Done.";
?>
