<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Determine Redirect URL
$redirect_url = $_REQUEST['redirect'] ?? $_SERVER['HTTP_REFERER'] ?? 'shop.php';

// Action: ADD (GET - From Shop Page)
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $product_id = (int)$_GET['id'];
    $name = $_GET['name'];
    $price = (float)$_GET['price'];
    $image = $_GET['image'];
    $size = 'One Size'; // Default for quick add
    $color = 'Black';   // Default for quick add
    $qty = 1;

    // Create unique key for item (ID + Size + Color)
    $cart_key = $product_id . '_' . $size . '_' . $color;

    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'product_id' => $product_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'size' => $size,
            'color' => $color,
            'qty' => $qty
        ];
    }
    header("Location: $redirect_url");
    exit();
}
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $product_id = (int)$_POST['product_id'];
    $name = $_POST['name'];
    $price = (float)$_POST['price'];
    $image = $_POST['image'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $qty = (int)$_POST['quantity'];

    // Create unique key for item (ID + Size + Color)
    $cart_key = $product_id . '_' . $size . '_' . $color;

    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'product_id' => $product_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'size' => $size,
            'color' => $color,
            'qty' => $qty
        ];
    }
    
    // Redirect to Cart or stay
    header("Location: $redirect_url");
    exit();
}

// Action: REMOVE
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['key'])) {
    $key = $_GET['key'];
    unset($_SESSION['cart'][$key]);
    header("Location: cart.php");
    exit();
}

// Action: CLEAR
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit();
}

header("Location: cart.php");
exit();
?>
