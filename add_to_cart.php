<?php
session_start();

if (!isset($_GET['id'])) {
    die("Invalid product.");
}

$id = $_GET['id'];
if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = 1;
} else {
    $_SESSION['cart'][$id]++;
}

header("Location: cart.php");
exit();
