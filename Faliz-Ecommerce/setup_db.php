<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "faliz_db";

// 1. Connect to MySQL server (without specifying DB first)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    die("Error creating database: " . $conn->error);
}

// 3. Select Database
$conn->select_db($dbname);

// 4. Create Users Table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully\n";
} else {
    echo "Error creating table users: " . $conn->error . "\n";
}

// 5. Create Products Table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    old_price DECIMAL(10, 2) DEFAULT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    sales_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' created successfully\n";
} else {
    echo "Error creating table products: " . $conn->error . "\n";
}

// 6. Create Orders Table
$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -- FOREIGN KEY (user_id) REFERENCES users(id) -- Optional: Add constraint later
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'orders' created successfully\n";
} else {
    echo "Error creating table orders: " . $conn->error . "\n";
}

// 7. Seed Admin User
$admin_email = "admin@faliz.com";
$check_admin = "SELECT * FROM users WHERE email='$admin_email'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    // Note: In real app, password should be hashed. Using plain text for demo as per previous context, 
    // but better to use password_hash('admin123', PASSWORD_DEFAULT)
    $password = 'admin123'; 
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('Admin', '$admin_email', '$password', 'admin')";
    if ($conn->query($sql) === TRUE) {
        echo "Admin user created successfully\n";
    } else {
        echo "Error creating admin user: " . $conn->error . "\n";
    }
}

// 8. Seed Products from Static File
include 'includes/products.php'; // Defines $all_products array

$check_products = "SELECT count(*) as count FROM products";
$result = $conn->query($check_products);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "Seeding products...\n";
    $stmt = $conn->prepare("INSERT INTO products (id, category, name, price, old_price, image) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($all_products as $p) {
        // Handle nullable old_price
        $op = isset($p['old_price']) ? $p['old_price'] : null;
        $stmt->bind_param("isssds", $p['id'], $p['category'], $p['name'], $p['price'], $op, $p['img']);
        $stmt->execute();
    }
    echo "Products seeded successfully (" . count($all_products) . " items)\n";
    $stmt->close();
} else {
    echo "Products already exist, skipping seed.\n";
}

$conn->close();
?>
