```
<?php
session_start();
include('../includes/db.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR category LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyShopping - Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            min-height: 100vh;
            margin: auto;
        }

        .navbar {
            background: #fcfbfb;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            color: #9b59b6;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            width: 40%;
        }

        .search-bar input {
            flex: 1;
            padding: 8px 15px;
        }

        .search-bar button {
            width: auto;
            padding: 8px 15px;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            margin-left: 20px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #9b59b6;
        }

        .nav-links a.active {
            color: #9b59b6;
            font-weight: bold;
        }

        .hero {
            text-align: center;
            padding: 80px 15px;
            background: white;
            color: black;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .sarp {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .sarp img {
            width: 110px;
            height: 110px;
            padding: 10px;
        }

        .sar img {
            width: 100px;
            height: 68px;
            padding: 20px;
        }

        .products-container {
            max-width: 100%;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .products-container h2 {
            text-align: center;
            color: #9b59b6;
            margin-bottom: 30px;
        }

        .products-scroll {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }

        .product-card {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            width: 300px;
            padding: 1.5rem 1rem;
            text-align: center;
            transition: box-shadow 0.2s;
            margin-bottom: 20px;
        }

        .product-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }

        .product-card img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .productsp h6 {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .productsp p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .price-compare {
            margin-bottom: 10px;
        }

        .price-compare span {
            display: block;
            color: #4CAF50;
            font-weight: bold;
            font-size: 1rem;
        }

        .buy-btn {
            background-color: #9b59b6;
            color: #fff;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 5px;
            width: 100%;
            transition: background 0.2s;
        }

        .buy-btn:hover {
            background: #7d3c98;
        }

        footer {
            width: 100%;
            background-color: #333;
            color: white;
            padding: 2rem 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            margin: 0 1rem;
        }

        .footer-section ul {
            list-style: none;
            margin-top: 1rem;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background: none;
            color: black;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .slider-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #fff;
        }

        .slider {
            display: flex;
            width: 300%;
            height: 100%;
            animation: slide 5s infinite;
        }

        .slide {
            width: 33.33%;
            height: 100%;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @keyframes slide {
            0%, 30% { transform: translateX(0); }
            35%, 65% { transform: translateX(-33.33%); }
            70%, 100% { transform: translateX(-66.66%); }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">EasyShopping</div>
        <form method="GET" action="index.php" class="search-bar">
            <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <div class="nav-links">
            <a href="index.php" class="active">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
                <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
            <div class="dropdown">
                <button class="dropbtn">Categories ▼</button>
                <div class="dropdown-content">
                    <a href="category/electronics.php">Electronics</a>
                    <a href="category/fashion.php">Fashion</a>
                    <a href="category/furniture.php">Home & Living</a>
                    <a href="category/books.php">Books</a>
                    <a href="category/sports.php">Sports</a>
                    <a href="category/beauty.php">Beauty</a>
                </div>
            </div>
            <a href="#" class="cart"><i class="fas fa-shopping-cart"></i> Cart</a>
        </div>
    </nav>

    <div class="hero">
        <div class="sar">
            <img src="../images/banner.jpg">
        </div>
        <div>
            <h1>Welcome to EasyShopping</h1>
            <p>Find the best deals on your favorite products</p>
        </div>
        <div class="sarp">
            <img src="../images/cosma.jpg">
            <img src="../images/earbuds.jpeg">
            <img src="../images/shoes.jpg">
            <img src="../images/smartphones.jpg">
            <img src="../images/toys.jpg">
            <img src="../images/watches.jpeg">
            <img src="../images/shirts.jpg">
            <img src="../images/furniture.jpeg">
            <img src="../images/utensils.jpg">
            <img src="../images/tracks.jpeg">
            <img src="../images/refrigerator.jpeg">
        </div>
    </div>

    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="../images/banner.jpg" alt="Summer Sale">
            </div>
            <div class="slide">
                <img src="../images/su.jpg" alt="New Collection">
            </div>
            <div class="slide">
                <img src="../images/far.jpg" alt="Special Offers">
            </div>
        </div>
    </div>

    <div class="products-container">
        <h2>Featured Products - Price Comparison</h2>
        <div class="products-scroll">
            <?php if ($result->num_rows === 0): ?>
                <p>No products found.</p>
            <?php endif; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="../images/products/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <div class="productsp">
                        <h6><?= htmlspecialchars($row['name']) ?></h6>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <p style="color:#888;font-size:0.9em;">Category: <?= htmlspecialchars($row['category']) ?></p>
                        <div class="price-compare">
                            <span>Price: <b>₹<?= htmlspecialchars($row['price']) ?></b></span>
                        </div>
                        <button class="buy-btn" disabled>Add to Cart</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Your one-stop shop for price comparison and smart shopping.</p>
            </div>
            <div class="footer-section">
                <h3>Help & Support</h3>
                <ul>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="#shipping">Shipping Info</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
```