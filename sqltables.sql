```
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, image, price, category) VALUES
('Sample Smartphone', 'Latest model with 128GB storage', 'smartphone.jpg', 25000.00, 'Electronics'),
('Casual Shirt', 'Comfortable cotton shirt', 'shirt.jpg', 1500.00, 'Fashion'),
('Wooden Chair', 'Modern ergonomic chair', 'chair.jpg', 5000.00, 'Furniture'),
('Sample Book', 'Bestseller novel', 'book.jpg', 500.00, 'Books'),
('Sports Shoes', 'High-performance running shoes', 'sports_shoes.jpg', 3000.00, 'Sports'),
('Beauty Cream', 'Moisturizing face cream', 'cream.jpg', 800.00, 'Beauty');
```