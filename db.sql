-- 1. Buat Database
CREATE DATABASE gymsystem;
USE gymsystem;

-- 2. Tabel Users
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    gender ENUM('Laki-Laki', 'Wanita'),
    password VARCHAR(255),git commit -m "kirim database dan folder project"
    role ENUM('Member', 'Admin') DEFAULT 'Member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Tabel Packages
CREATE TABLE packages (
    id_package INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100) DEFAULT 'default.jpg',
    price DECIMAL(10, 2) NOT NULL,
    day_duration INT NOT NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 4. Tabel 