CREATE DATABASE shop;
USE shop;

-- Categories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  photo_url VARCHAR(255)
);

INSERT INTO categories (name, photo_url) VALUES
('Shirts', 'photos/shirt1.jpg'),
('Jeans', 'photos/jeans1.jpg'),
('Ethnic', 'photos/ethnic1.jpg');

-- Products
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  price DECIMAL(7,2) NOT NULL,
  category_id INT,
  size VARCHAR(45),
  color VARCHAR(45),
  description TEXT,
  image1 VARCHAR(255),
  stock INT DEFAULT 10
);

INSERT INTO products (name, price, category_id, size, color, description, image1, stock) VALUES
('Black Shirt', 599.00, 1, 'S,M,L,XL', 'Black', 'Stylish black shirt for men.', 'photos/shirt1.jpg', 7),
('Blue Jeans', 899.00, 2, '30,32,34,36', 'Blue', 'Best fit blue jeans.', 'photos/jeans1.jpg', 9),
('Kurta Set', 1249.00, 3, 'S,M,L,XL', 'White', 'Ethnic kurta set.', 'photos/ethnic1.jpg', 5);

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(40),
  email VARCHAR(100),
  password VARCHAR(100),
  otp VARCHAR(8),
  otp_time DATETIME
);

INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@email.com', 'admin123');

-- Orders
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  quantity INT,
  size VARCHAR(10),
  color VARCHAR(20),
  status VARCHAR(30) DEFAULT 'Pending'
);

-- Cart
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  quantity INT,
  size VARCHAR(10),
  color VARCHAR(20)
);

-- Slider (Homepage banners)
CREATE TABLE slider (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(80),
  details TEXT,
  image VARCHAR(200)
);
ALTER TABLE orders ADD COLUMN address VARCHAR(200), ADD COLUMN mobile VARCHAR(20);
ALTER TABLE users ADD COLUMN mobile VARCHAR(20) AFTER email;
CREATE TABLE product_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  image_url VARCHAR(255)
);
ALTER TABLE products ADD COLUMN images VARCHAR(1000);
CREATE TABLE deliveryboys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  mobile VARCHAR(15) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(200) NOT NULL
);
ALTER TABLE orders ADD COLUMN deliveryboy_id INT DEFAULT NULL;
ALTER TABLE deliveryboys ADD COLUMN delivered_count INT DEFAULT 0;




INSERT INTO slider (title, details, image) VALUES
('Welcome to CLOTHES!', 'Get the best deals on fresh arrivals.', 'photos/banner1.jpg'),
('Festive Offer!', 'Flat 30% off on ethnic wear.', 'photos/banner2.jpg');
