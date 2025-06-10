<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

if (empty($cart)) {
    echo "Cart is empty.";
    exit();
}

$ids = implode(',', array_keys($cart));
$result = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

$total = 0;
$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $pid = $row['id'];
    $qty = $cart[$pid];
    $price = $row['price'];
    $subtotal = $qty * $price;
    $total += $subtotal;
    $items[] = ['product_id' => $pid, 'quantity' => $qty, 'price' => $price];
}

// Save order
mysqli_query($conn, "INSERT INTO orders (user_id, total_amount) VALUES ($user_id, $total)");
$order_id = mysqli_insert_id($conn);

// Save order items
foreach ($items as $item) {
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) 
    VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})");
}

// Clear cart
unset($_SESSION['cart']);

echo "Order placed successfully! <a href='orders.php'>View Orders</a>";
