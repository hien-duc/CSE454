CREATE DATABASE IF NOT EXISTS lab6;
USE lab6;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    address TEXT,
    date_register DATETIME DEFAULT CURRENT_TIMESTAMP,
    type ENUM('admin', 'author', 'normal') NOT NULL DEFAULT 'normal',
    status ENUM('activated', 'disabled') NOT NULL DEFAULT 'activated'
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    brand VARCHAR(255),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_url VARCHAR(255),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
