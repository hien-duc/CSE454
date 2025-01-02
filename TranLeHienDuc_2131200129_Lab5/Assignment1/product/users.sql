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
