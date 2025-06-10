```
<?php
session_start();
include('../../includes/db.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM products WHERE category = 'Electronics'";
if ($search !== '') {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $like = "%$search%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics - EasyShopping</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EasyShopping</div>
        <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="electronics.php" class="active">Electronics</a>
            <a href="fashion.php">Fashion</a>
            <a href="furniture.php">Furniture</a>
            <a href="books.php">Books</a>
            <a href="sports.php">Sports</a>
            <a href="beauty.php">Beauty</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../logout.php">Logout</a>
                <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
            <?php else: ?>
                <a href="../login.php">Login</a>
                <a href="../register.php">Register</a>
            <?php endif; ?>
            <a href="#" class="cart"><i class="fas fa-shopping-cart"></i> Cart</a>
        </div>
    </nav>
    <div class="category-hero">
        <h1>Electronics</h1>
        <p>Latest gadgets and devices at the best prices!</p>
    </div>
    <form method="GET" action="electronics.php" style="text-align:center; margin: 20px 0;">
        <input type="text" name="search" placeholder="Search electronics..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>
    <div class="products-container">
        <div class="products-scroll">
            <?php if ($result->num_rows === 0): ?>
                <p>No products found.</p>
            <?php endif; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="../../images/products/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <div class="productsp">
                        <h6><?= htmlspecialchars($row['name']) ?></h6>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <p style="color:#888;font-size:0.9em;">Category: <?= htmlspecialchars($row['category']) ?></p>
                        <div class="price-compare">
                            <span>Our Price: <b>₹<?= htmlspecialchars($row['price']) ?></b></span>
                            <span>Flipkart: <a href="https://www.flipkart.com/search?q=<?= urlencode($row['name']) ?>" target="_blank" style="color:#2874f0;">Check Price</a></span>
                            <span>Amazon: <a href="https://www.amazon.in/s?k=<?= urlencode($row['name']) ?>" target="_blank" style="color:#ff9900;">Check Price</a></span>
                        </div>
                        <button class="buy-btn" disabled>Add to Cart</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
```