-- init.sql
DROP DATABASE IF EXISTS moyce_jae_db;
CREATE DATABASE moyce_jae_db;
USE moyce_jae_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    compare_price DECIMAL(10, 2),
    is_active BOOLEAN DEFAULT true,
    is_featured BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT false,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    size VARCHAR(20),
    color VARCHAR(50),
    sku VARCHAR(100) UNIQUE,
    stock INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Paid', 'Processing', 'Shipped', 'Delivered', 'Cancelled', 'Return Requested', 'Refunded') DEFAULT 'Pending',
    shipping_address TEXT NOT NULL,
    shipping_fee DECIMAL(10, 2) DEFAULT 0.00,
    payment_method VARCHAR(50) DEFAULT 'Cash on Delivery',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    variant_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    session_id VARCHAR(100),
    product_id INT,
    variant_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

CREATE TABLE IF NOT EXISTS coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_type ENUM('percentage', 'fixed') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    min_purchase DECIMAL(10,2) DEFAULT 0.00,
    is_active BOOLEAN DEFAULT true,
    expires_at DATETIME
);

-- Seed Data
INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES 
('Super', 'Admin', 'superadmin@moycejae.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Admin', 'User', 'admin@moycejae.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); -- password is 'password'

INSERT INTO categories (name, slug) VALUES 
('Oversized Tees', 'oversized-tees'),
('Hoodies', 'hoodies'),
('Graphic Tees', 'graphic-tees'),
('Accessories', 'accessories');

INSERT INTO products (category_id, name, slug, description, price, is_featured) VALUES 
(2, 'Graphite Heavyweight Hoodie', 'graphite-heavyweight-hoodie', 'Premium 500gsm heavyweight cotton hoodie in matte graphite.', 120.00, true),
(1, 'Charcoal Washed Tee', 'charcoal-washed-tee', 'Oversized luxury drop shoulder tee in soft charcoal wash.', 65.00, true),
(1, 'Ivory Essential Tee', 'ivory-essential-tee', 'The perfect oversized everyday tee in off-white ivory.', 60.00, false),
(2, 'Midnight Black Hoodie', 'midnight-black-hoodie', 'Classic oversized black hoodie with dropped shoulders.', 115.00, true),
(3, 'Vintage Logo Graphic Tee', 'vintage-logo-graphic-tee', 'Washed vintage tee with signature Moyce Jae distressed logo.', 75.00, false),
(4, 'Signature Nylon Tote', 'signature-nylon-tote', 'Durable lightweight nylon tote bag for everyday carry.', 55.00, false),
(4, 'Ribbed Beanie', 'ribbed-beanie', 'Thick ribbed knit beanie in charcoal grey.', 35.00, true),
(3, 'Acid Wash Tour Tee', 'acid-wash-tour-tee', 'Limited edition acid wash tee with tour graphics.', 85.00, true),
(1, 'Olive Drab Boxy Tee', 'olive-drab-boxy-tee', 'Boxy fit heavy cotton tee in olive drab green.', 65.00, false),
(2, 'Bone Zip-Up Hoodie', 'bone-zip-up-hoodie', 'Heavyweight zip-up hoodie in light bone color.', 130.00, false);

INSERT INTO product_variants (product_id, size, color, sku, stock) VALUES
(1, 'Medium', 'Graphite', 'HOOD-GR-M', 10),
(1, 'Large', 'Graphite', 'HOOD-GR-L', 15),
(2, 'Medium', 'Charcoal', 'TEE-CH-M', 20),
(2, 'Large', 'Charcoal', 'TEE-CH-L', 20),
(3, 'Medium', 'Ivory', 'TEE-IV-M', 15),
(3, 'Large', 'Ivory', 'TEE-IV-L', 15),
(4, 'Medium', 'Black', 'HOOD-BK-M', 25),
(4, 'Large', 'Black', 'HOOD-BK-L', 20),
(5, 'Medium', 'Vintage Black', 'TEE-VG-M', 10),
(6, 'One Size', 'Black', 'ACC-TOTE-BK', 30),
(7, 'One Size', 'Charcoal', 'ACC-BEAN-CH', 40),
(8, 'Large', 'Acid Wash', 'TEE-AW-L', 5),
(9, 'Medium', 'Olive', 'TEE-OL-M', 15),
(9, 'Large', 'Olive', 'TEE-OL-L', 20),
(10, 'Medium', 'Bone', 'HOOD-BN-M', 10);

