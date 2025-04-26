-- Create Database
CREATE DATABASE IF NOT EXISTS agency_x_users 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE agency_x_users;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NULL,
    last_name VARCHAR(50) NULL,
    role ENUM('admin', 'user', 'manager') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    profile_image VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert admin user
INSERT INTO users (username, email, password_hash, first_name, last_name, role)
VALUES (
    'admin', 
    'admin@agencyx.com', 
    '$2y$10$GVP/XuypRGdYjng7/kz.9exdK/Q5BbpMsGm7r66ftMhKMxNVRodiy',
    'Agency', 
    'Admin', 
    'admin'
) ON DUPLICATE KEY UPDATE username=username;
