CREATE DATABASE IF NOT EXISTS nguyennghianhan_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nguyennghianhan_database;

CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    catename VARCHAR(100) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    status TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    brandname VARCHAR(100) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    status TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    brand_id INT,
    proname VARCHAR(200) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    price DECIMAL(10,0) NOT NULL,
    discount_price DECIMAL(10,0) NOT NULL,
    quantity INT DEFAULT 0,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    status TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (brand_id) REFERENCES brands(id)
);

CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    role TINYINT DEFAULT 0,
    status TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NULL,
    address VARCHAR(255) NULL,
    note TEXT NULL
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    user_id INT NULL,
    order_code VARCHAR(30) NOT NULL UNIQUE,
    total_amount DECIMAL(12,2) DEFAULT 0,
    note TEXT NULL,
    status TINYINT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    subtotal DECIMAL(12,2),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert dummy data (5 records per table)
INSERT INTO categories (catename, slug, description) VALUES 
('Laptop', 'laptop', 'Máy tính xách tay'),
('Điện thoại', 'dien-thoai', 'Điện thoại thông minh'),
('Chuột', 'chuot', 'Chuột máy tính'),
('Bàn phím', 'ban-phim', 'Bàn phím cơ'),
('Tai nghe', 'tai-nghe', 'Tai nghe bluetooth');

INSERT INTO brands (brandname, slug) VALUES 
('Apple', 'apple'),
('Samsung', 'samsung'),
('Dell', 'dell'),
('Logitech', 'logitech'),
('Sony', 'sony');

INSERT INTO products (category_id, brand_id, proname, slug, price, discount_price, quantity) VALUES 
(1, 1, 'MacBook Air M1', 'macbook-air-m1', 20000000, 18000000, 10),
(2, 2, 'Galaxy S23 Ultra', 'galaxy-s23-ultra', 25000000, 23000000, 5),
(1, 3, 'Dell XPS 13', 'dell-xps-13', 30000000, 28000000, 8),
(3, 4, 'Chuột Logitech G102', 'chuot-logitech-g102', 400000, 350000, 50),
(5, 5, 'Tai nghe Sony WH-1000XM5', 'tai-nghe-sony-wh-1000xm5', 7000000, 6500000, 20);

INSERT INTO product_images (product_id, image) VALUES 
(1, 'macbook1.jpg'),
(2, 's23ultra1.jpg'),
(3, 'xps1.jpg'),
(4, 'g102.jpg'),
(5, 'sony1.jpg');

INSERT INTO users (fullname, username, password, role) VALUES 
('Nguyễn Nghĩa Nhân', 'admin', '123456', 1),
('Trần Ngọc Hải', 'nhanvien1', '123456', 0),
('Lê Thị C', 'nhanvien2', '123456', 0),
('Phạm Văn D', 'nhanvien3', '123456', 0),
('Hoàng Văn E', 'admin2', '123456', 1);

INSERT INTO customers (fullname, phone) VALUES 
('Nguyễn Văn A', '0901234567'),
('Trần Thị B', '0912345678'),
('Lê Văn C', '0923456789'),
('Phạm Thị D', '0934567890'),
('Hoàng Văn E', '0945678901');

INSERT INTO orders (customer_id, user_id, order_code, total_amount, status) VALUES 
(1, 1, 'DH001', 18000000, 1),
(2, 2, 'DH002', 23000000, 0),
(3, 1, 'DH003', 28000000, 2),
(4, 3, 'DH004', 350000, 1),
(5, 2, 'DH005', 6500000, 0);

INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) VALUES 
(1, 1, 1, 18000000, 18000000),
(2, 2, 1, 23000000, 23000000),
(3, 3, 1, 28000000, 28000000),
(4, 4, 1, 350000, 350000),
(5, 5, 1, 6500000, 6500000);
