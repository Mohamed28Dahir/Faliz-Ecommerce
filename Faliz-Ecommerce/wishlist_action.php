<?php
session_start();

// Initialize wishlist if not exists
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

$redirect_url = $_SERVER['HTTP_REFERER'] ?? 'shop.php';

// Action: ADD
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $product_id = (int)$_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $image = $_GET['image'];

    // Avoid duplicates
    if (!isset($_SESSION['wishlist'][$product_id])) {
        $_SESSION['wishlist'][$product_id] = [
            'id' => $product_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'date_added' => date('Y-m-d H:i:s')
        ];
    }
    
    // Redirect back to where they came from
    header("Location: $redirect_url");
    exit();
}

// Action: REMOVE
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['wishlist'][$id]);
    header("Location: wishlist.php");
    exit();
}

// Action: CLEAR
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $_SESSION['wishlist'] = [];
    header("Location: wishlist.php");
    exit();
}

header("Location: wishlist.php");
exit();
?>
