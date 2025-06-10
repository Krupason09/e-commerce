<?php
session_start();
include 'db.php'; // your DB connection

// Handle remove
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// Handle quantity update
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $_SESSION['cart'][$id] = $qty;
    }
    header("Location: cart.php");
    exit();
}

// Fetch product data
$cart_items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

    while ($row = mysqli_fetch_assoc($query)) {
        $pid = $row['id'];
        $qty = $_SESSION['cart'][$pid];
        $row['quantity'] = $qty;
        $row['subtotal'] = $qty * $row['price'];
        $total += $row['subtotal'];
        $cart_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
    <h2>Shopping Cart</h2>
    <?php if (empty($cart_items)) : ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="post">
            <table border="1" cellpadding="10">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>
                        <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1">
                    </td>
                    <td>₹<?= number_format($item['price'], 2) ?></td>
                    <td>₹<?= number_format($item['subtotal'], 2) ?></td>
                    <td><a href="cart.php?remove=<?= $item['id'] ?>">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <p>Total: ₹<?= number_format($total, 2) ?></p>
            <button type="submit" name="update_cart">Update Cart</button>
            <a href="checkout.php">Proceed to Checkout</a>
        </form>
    <?php endif; ?>
</body>
</html>
