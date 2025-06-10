<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>

<h2>Your Orders</h2>

<?php while ($order = mysqli_fetch_assoc($orders)): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
        <strong>Order #<?= $order['id'] ?></strong><br>
        Total: ₹<?= number_format($order['total_amount'], 2) ?><br>
        Status: <?= $order['status'] ?><br>
        Date: <?= $order['order_date'] ?>

        <ul>
        <?php
        $order_id = $order['id'];
        $items = mysqli_query($conn, "
            SELECT p.name, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = $order_id
        ");
        while ($item = mysqli_fetch_assoc($items)) {
            echo "<li>{$item['name']} ({$item['quantity']} × ₹{$item['price']})</li>";
        }
        ?>
        </ul>
    </div>
<?php endwhile; ?>
